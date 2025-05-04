<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Invoices;
use App\Models\User;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use function MongoDB\BSON\toJSON;


class InvoicesController extends Controller
{
    /**
     * @throws ValidationException
     */

    public function view()
    {
        $invoiceId = InvoiceService::invoiceIdGenerator();
        $settings = new SettingsController();
        return view('pages/invoice', ['invoiceId' => $invoiceId, 'settings' => $settings]);
    }

    public function previewInvoice($id = '')
    {
        if (Auth::check())
           $data= InvoiceService::find_invoice($id);
        elseif (session($id))
            $data = session($id);
        else
            return Redirect()->route('invoiceBuilder');

        //return Redirect()->route('invoiceBuilder');
        //return response();
        //session()->forget($id);
        return view('pages/invoice_preview', ['invoice_data' => $data]);
    }

    public function makeInvoice(Request $request)
    {

        $validated = validator($request->all(), [
            'issue_to' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'nullable|email',
            'date' => 'required|date',
            'currency' => 'required|string',
            'company_name' => 'required|string',
            'tax' => 'nullable|numeric',
            'need_tax' => 'nullable|boolean',
            'invoiceNotes' => 'nullable|string',
            'invoice_number' => 'required|string|max:255',
            'amount_paid' => 'nullable|numeric',
            'amount_total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Input All Required Fields",
                'error' => $validated->errors(),
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
                    //insert new customer
                    $customer = Customers::create([
                        'user_id' => Auth::id(),
                        'name' => $validatedData['issue_to'],
                        'phone' => $validatedData['phone'],
                        'email' => $validatedData['email'],
                        'address' => $validatedData['address'],
                    ]);
                }

                //inset invoice for the user
                $invoice = Invoices::create([
                    'user_id' => Auth::id(),
                    'customer_id' => $customer->id,
                    'invoice_number' => 467689787,
                    'invoice_date' => $validatedData['date'],
                    'items' => json_encode($validatedData['items']),
                    'tax_amount' => $validatedData['tax'],
                    'need_tax' => $validatedData['need_tax'],
                    'notes' => $validatedData['invoiceNotes'],
                    'currency' => $validatedData['currency'],
                    'paid_amount' => $validatedData['amount_paid'],
                    'total_amount' => $validatedData['amount_total']
                ]);

                //commited the state...
                DB::commit();

//            return response()->json([
//                "success" => true,
//                'message' => 'Invoice Created Success',
//                "invoice" => $invoice,
//                'customer'=>$customer
//            ]);
                return view('pages/invoice_preview');


            } catch (Exception $e) {
                //back if any errors in transactions
                DB::rollBack();

//                return response()->json([
//                    'success' => false,
//                    'message' => 'Something Went Wrong',
//                    'error' => $e->getMessage()
//                ]);
                return back()->with([
                    'success' => false,
                    'message' => "Input All Required Fields",
                    'error' => $validated->errors()
                ]);
            }
        } else {
            //return redirect()->route('previewInvoice')->with(['message'=>'generate success','data'=>$request->all()]);
            session([$request->invoice_number => $validatedData]);
            return response()->json([
                'success' => true,
                'message' => 'redirect to preview page with data',
                'redirect' => route('previewInvoice', $request->invoice_number)// or your target route
            ]);
        }

//        return redirect()->route('previewInvoice')->with('message', 'Registered successfully! Please check your email to verify.');

    }


    public function get_all_invoices(): Collection
    {
        //return all invoices for current user
        return Invoices::with('customer')->where('user_id', Auth::id())->get();
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
        return Invoices::where('user_id', Auth::id())->sum('total_amount');
    }

    public function invoice_status()
    {
        return Invoices::where('user_id', Auth::id())->get('status')->count();
    }

//    public function errorHandle(): string
//    {
//        return '@if ($errors->any())
//        <div class="alert alert-danger">
//            @foreach ($errors->all() as $error)
//                <span style="font-size: .8rem">{{ $error }}</span>
//            @endforeach
//        </div>
//    @endif';
//    }
}
