<?php

namespace App\Http\Controllers;

use App\Helpers\AdminNotifier;
use App\Models\Customers;
use App\Models\Invoices;
use App\Models\User;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;


class InvoicesController extends Controller
{
    /**
     * @throws ValidationException
     */

    public function view()
    {
        $invoiceId = InvoiceService::invoiceIdGenerator();
        if (Auth::check()) {
            $settings = Auth::user()->settings;

            return view('pages/invoice', ['invoiceId' => $invoiceId, 'settings' => $settings]);
        } else {
            return view('pages/invoice', ['invoiceId' => $invoiceId]);

        }
    }
    public function invoiceList()
    {
            return view('pages.invoice.invoice-list');

    }

    public function theme()
    {
        return View('pages.invoice.builder');
    }

    public function previewInvoice($id = '')
    {
        if (Auth::check()) {
            $settings = new SettingsController();
            $companyData = ['name' => $settings->companyName(),
                'address' => $settings->companyAddress(),
                'phone' => $settings->companyPhone(),
                'email' => $settings->companyEmail(),
            ];
            $data = InvoiceService::find_invoice($id);
            return view('pages/invoice_preview', ['invoice_data' => $data, 'company_data' => $companyData]);

        } elseif (session($id)) {
            $data = session($id);
        } else {
            return Redirect()->route('invoiceBuilder');
        }
        return view('pages/invoice_preview', ['invoice_data' => $data]);
    }

    public function makeInvoice(Request $request)
    {

        $validated = validator($request->all(), [
            'issueFrom' => 'nullable|string',
            'issueAddress' => 'nullable|string',
            'issuePhone' => 'nullable|string',
            'issueEmail' => 'nullable|string',

            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'nullable|email',

            'status' => 'nullable|string',
            'invoice_date' => 'required|date',
            'currency' => 'required|string',
            'tax_amount' => 'nullable|numeric',
            'need_tax' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'invoice_number' => 'required|string|max:255',
            'paid_amount' => 'nullable|numeric',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validated->errors()->first(),
                'error' => $validated->errors()->first(),
                'redirect' => route('invoiceBuilder') // or your target route
            ]);

        }

        $validatedData = $validated->validated();

        if (auth()->check()) {
            DB::beginTransaction();
            try {
                //find  any existing customer else add as new
                $user = User::find(Auth::id());
                $customer = $user->customers()->where('phone', $validatedData['phone'])->first();

                if (!$customer) {
                    $customer = Customers::create([
                        'user_id' => Auth::id(),
                        'name' => $validatedData['name'],
                        'phone' => $validatedData['phone'],
                        'email' => $validatedData['email'],
                        'address' => $validatedData['address'],
                    ]);
                }
                $status = $validatedData['paid_amount'] >= $validatedData['total_amount'] ? 'Paid' : 'Pending';


                //inset invoice for the user
                $invoice = Invoices::create([
                    'user_id' => Auth::id(),
                    'customer_id' => $customer->id,
                    'invoice_number' => $validatedData['invoice_number'],
                    'invoice_date' => $validatedData['invoice_date'],
                    'items' => json_encode($validatedData['items']),
                    'tax_amount' => $validatedData['tax_amount'],
                    'need_tax' => $validatedData['need_tax'],
                    'notes' => $validatedData['notes'],
                    'currency' => $validatedData['currency'],
                    'paid_amount' => $validatedData['paid_amount'],
                    'total_amount' => $validatedData['total_amount'],
                    'status' => $status
                ]);
                DB::commit();
                AdminNotifier::invoiceGenerate($invoice);
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice Created Success',
                    'redirect' => route('previewInvoice', $validatedData['invoice_number'])// or your target route
                ]);

            } catch (Exception $e) {
                //back if any errors in transactions
                DB::rollBack();
                return back()->with([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'redirect' => route('invoiceBuilder')
                ]);
            }
        } else {
            //return redirect()->route('previewInvoice')->with(['message'=>'generate success','data'=>$request->all()]);
            session([$validatedData['invoice_number'] => $validatedData]);
            return response()->json([
                'success' => true,
                'message' => 'redirect to preview page with data',
                'redirect' => route('previewInvoice', $request->invoice_number)// or your target route
            ]);
        }

//        return redirect()->route('previewInvoice')->with('message', 'Registered successfully! Please check your email to verify.');

    }


    public function get_all_invoices()
    {
        $user = Auth::user();
        $data=$user->invoices()->select('id', 'user_id', 'customer_id', 'invoice_number', 'status', 'total_amount', 'paid_amount', 'invoice_date')
        ->with(['customer:id,name,email,phone,address'])->orderBy('created_at', 'desc')->paginate(100);
        return response()->json([
        "success"=>true,
        "message"=>'Success',
        "data"=>$data,
        ]);

    }

    public function search_invoice(Request $request)
    {
        $user = Auth::user();
        // Search by customer name or invoice number
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;

            $invoices = $user->invoices()->select('id', 'user_id', 'customer_id', 'invoice_number', 'status', 'total_amount', 'paid_amount', 'invoice_date')->with('customer')
                ->when($search, function ($query, $search) {
                    return $query->where('invoice_number', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                })->orderBy('created_at', 'desc')->paginate(10);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'search input is empty',
                'invoices' => $this->get_all_invoices()
            ]);
        }

        return response()->json([
            'success' => true,
            'invoices' => $invoices,
            'input' => $search
        ]);
    }

//    return a specific customers invoice
    public function find_invoice($id): array
    {
        return User::find(Auth::id())->invoices->where('customer_id', $id)->all();
    }

    public function num_of_invoices()
    {
        return User::find(Auth::id())->invoices->count();
    }

    public function get_invoice($id): JsonResponse
    {
        $invoices = Invoices::all()->where('user_id', Auth::id())->where('id', $id);
        return response()->json($invoices);
    }


    public function sum_of_total()
    {
        $user = Auth::user();
        return $user->invoices()->where('status', '!=', 'cancelled')->sum('total_amount');
    }

    public function sum_of_paid()
    {
        $user = Auth::user();
        return $user->invoices()->where('status', '!=', 'cancelled')->sum('paid_amount');
    }

    public function sum_of_due()
    {
        return $this->sum_of_total() - $this->sum_of_paid();
    }

    public function invoice_status(string $status = 'pending')
    {
        return Invoices::where('user_id', Auth::id())->where('status', $status)->get('status')->count();
    }

    public function change_status(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $invoice = $user->invoices->where('invoice_number', $request->id)->first();
        //$invoice= Invoices::where('user_id', Auth::id())->where('invoice_number', $request->id)->first();

        if ($request->paymentStatus === 'Paid') {
            $invoice->paid_amount = $invoice->total_amount;
            $invoice->status = $request->paymentStatus;
        } else {
            $invoice->status = $request->paymentStatus;
        }
        $invoice->save();
        return redirect()->back()->with('message', 'Updated');
    }

    public function delete_invoice($invoiceNumber)
    {
        $deleted = InvoiceService::delete_invoice($invoiceNumber);

        if ($deleted) {
            return redirect()->back()->with(['message' => 'Delete Successfully.', 'response' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Failed.', 'response' => 'error']);
        }
    }

}
