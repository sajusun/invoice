<?php

namespace App\Http\Controllers;

use App\Helpers\AdminNotifier;
use App\Models\Customers;
use App\Models\Invoices;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\MethodService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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
    public function getInvoiceCounts()
    {
        $counts = [
            'all' => Invoices::count(),
            'paid' => Invoices::where('status', 'paid')->count(),
            'unpaid' => Invoices::where('status', 'unpaid')->count(),
            'overdue' => Invoices::where('status', 'overdue')
                //   ->where('due_date', '<', now())
                ->count(),
        ];

        return $counts;
    }

    public function previewInvoice($id = '')
    {
        if (Auth::check()) {
            $settings = new SettingsController();
            $companyData = [
                'name' => $settings->companyName(),
                'address' => $settings->companyAddress(),
                'phone' => $settings->companyPhone(),
                'email' => $settings->companyEmail(),
            ];
            $data = InvoiceService::find_invoice($id);
            return view('pages/invoice_preview', ['invoice_data' => $data, 'company_data' => $companyData]);
           // return [$data, $companyData];
        } elseif (session($id)) {
            $data = session($id);
        } else {
            return Redirect()->route('invoice.builder');
        }
        return view('pages/invoice/preview2', ['invoice_data' => $data]);
    }

    public function makeInvoice(Request $request): JsonResponse
    {
        $user = Auth::user();

        // Support both builder.vue nested format and flat request format
        $clientName    = $request->input('client.name', $request->input('name', 'Valued Client'));
        $clientEmail   = $request->input('client.email', $request->input('email'));
        $clientPhone   = $request->input('client.phone', $request->input('phone', '0000000000'));
        $clientAddress = $request->input('client.address', $request->input('address', ''));

        $invoiceNumber = $request->input('details.number', $request->input('invoice_number', InvoiceService::invoiceIdGenerator()));
        $invoiceDate   = $request->input('details.issueDate', $request->input('invoice_date', date('Y-m-d')));
        $dueDate       = $request->input('details.dueDate', $request->input('due_date'));
        $notes         = $request->input('notes', '');
        $terms         = $request->input('terms', '');
        $currency      = $request->input('currency', $user?->settings?->default_currency ?? 'USD');

        $rawItems = $request->input('items', []);
        $items = [];
        $subtotal = 0;

        foreach ($rawItems as $item) {
            $desc = $item['description'] ?? $item['name'] ?? 'Item';
            $qty  = max(1, (float) ($item['qty'] ?? 1));
            $rate = max(0, (float) ($item['rate'] ?? 0));
            $lineTotal = round($qty * $rate, 2);
            $subtotal += $lineTotal;

            $items[] = [
                'name' => $desc,
                'description' => $desc,
                'qty' => $qty,
                'rate' => $rate,
                'total' => $lineTotal,
            ];
        }

        if (empty($items)) {
            $items[] = [
                'name' => 'General Service',
                'description' => 'General Service',
                'qty' => 1,
                'rate' => 100,
                'total' => 100,
            ];
            $subtotal = 100;
        }

        $taxRate = (float) $request->input('tax_percentage', 10);
        $taxAmount = round($subtotal * ($taxRate / 100), 2);
        $totalAmount = round($subtotal + $taxAmount, 2);
        $paidAmount = (float) $request->input('paid_amount', 0);
        $status = $paidAmount >= $totalAmount ? 'paid' : ($paidAmount > 0 ? 'partially_paid' : 'unpaid');

        if ($user) {
            DB::beginTransaction();
            try {
                // Find or create customer
                $customer = null;
                if (!empty($clientEmail)) {
                    $customer = $user->customers()->where('email', $clientEmail)->first();
                }
                if (!$customer && !empty($clientPhone) && $clientPhone !== '0000000000') {
                    $customer = $user->customers()->where('phone', $clientPhone)->first();
                }
                if (!$customer) {
                    $customer = Customers::create([
                        'user_id' => $user->id,
                        'name' => $clientName,
                        'email' => $clientEmail,
                        'phone' => $clientPhone,
                        'address' => $clientAddress,
                    ]);
                }

                $invoice = Invoices::create([
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'invoice_number' => $invoiceNumber,
                    'invoice_date' => $invoiceDate,
                    'due_date' => $dueDate,
                    'items' => json_encode($items),
                    'tax_amount' => $taxAmount,
                    'need_tax' => $taxAmount > 0 ? 1 : 0,
                    'notes' => trim($notes . ($terms ? "\nTerms: " . $terms : '')),
                    'currency' => $currency,
                    'paid_amount' => $paidAmount,
                    'total_amount' => $totalAmount,
                    'status' => $status,
                ]);

                DB::commit();

                try {
                    AdminNotifier::invoiceGenerate($invoice);
                } catch (\Throwable $e) {
                    // Suppress notifier errors
                }

                try {
                    app(\App\Services\WebhookDispatcherService::class)->dispatchForUser($user, 'invoice.created', [
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'total_amount' => $invoice->total_amount,
                        'status' => $invoice->status,
                    ]);
                } catch (\Throwable $e) {
                    // Suppress webhook errors
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully!',
                    'invoice' => $invoice,
                    'redirect' => route('previewInvoice', $invoice->invoice_number),
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create invoice: ' . $e->getMessage(),
                ], 422);
            }
        } else {
            // Guest Session Storage
            session([$invoiceNumber => [
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $invoiceDate,
                'items' => $items,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'status' => 'unpaid',
                'customer' => [
                    'name' => $clientName,
                    'email' => $clientEmail,
                    'phone' => $clientPhone,
                    'address' => $clientAddress,
                ],
            ]]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice created in session!',
                'redirect' => route('previewInvoice', $invoiceNumber),
            ]);
        }
    }



    public function get_all_invoices()
    {
        $user = Auth::user();
        $data = $user->invoices()->select('id', 'user_id', 'customer_id', 'invoice_number', 'status', 'total_amount', 'paid_amount', 'invoice_date')
            ->with(['customer:id,name,email,phone,address'])->latest()->get();
        return $data;
    }

    public function all_invoices_by_paginate($paginate)
    {
        $user = Auth::user();
        $data = $user->invoices()->select('id', 'user_id', 'customer_id', 'invoice_number', 'status', 'total_amount', 'paid_amount', 'invoice_date')
            ->with(['customer:id,name,email,phone,address'])->latest()->paginate($paginate);
        return $data;
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
                })->latest()->paginate($request->paginate);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Get data from default',
                'status' => $this->getInvoiceCounts(),
                'invoices' => $this->all_invoices_by_paginate($request->paginate)

            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $this->getInvoiceCounts(),
            'invoices' => $invoices,
            'message' => 'search data',

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
