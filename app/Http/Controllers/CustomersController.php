<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function create(): View
    {
        return view('pages.customers.customer_add');
    }

    public function customers()
    {
        return Auth::user()->customers()->latest()->get();
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone'        => [
                'required',
                'string',
                'max:30',
                Rule::unique('customers', 'phone')->where('user_id', $user->id),
            ],
            'email'        => 'nullable|email|max:255',
            'tax_id'       => 'nullable|string|max:50',
            'address'      => 'nullable|string|max:500',
            'notes'        => 'nullable|string|max:1000',
            'metadata'     => 'nullable|array',
        ]);

        try {
            CustomerService::findOrCreate($user, $validated);
            return redirect()->route('customers')->with('success', 'Client created successfully!');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Failed to create client: ' . $th->getMessage());
        }
    }

    public function total_customers(): int
    {
        return Auth::user()->customers()->count();
    }

    public function total_revenue(int $id): float
    {
        return (float) Auth::user()->invoices()->where('customer_id', $id)->where('status', '!=', 'cancelled')->sum('total_amount');
    }

    public function total_pending(int $id): int
    {
        return Auth::user()->invoices()->where('customer_id', $id)->whereIn('status', ['unpaid', 'pending'])->count();
    }

    public function customer_data(int $id): Customer
    {
        return Auth::user()->customers()->with('invoices')->findOrFail($id);
    }

    public function get_customer_by_invoiceId(int $customer_id): ?Customer
    {
        return Auth::user()->customers()->with('invoices')->where('id', $customer_id)->first();
    }

    public function get_customers(int $paginate = 15)
    {
        return CustomerService::paginateForUser(Auth::user(), request(), $paginate);
    }

    public function delete_customer(int $id): RedirectResponse
    {
        $deleted = CustomerService::deleteCustomer($id, Auth::user());

        if ($deleted) {
            return redirect()->back()->with(['message' => 'Client deleted successfully.', 'response' => 'success']);
        }

        return redirect()->back()->with(['message' => 'Failed to delete client.', 'response' => 'error']);
    }

    public function customer_details(int $id): View
    {
        $customer = Auth::user()->customers()->with('invoices')->findOrFail($id);
        $metrics = CustomerService::getCustomerMetrics($customer);

        return view('pages.customers.customers_details', compact('customer', 'metrics'));
    }

    public function customers_data_update(Request $request, int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $customer = $user->customers()->findOrFail($id);

        if ($request->isMethod('GET')) {
            $metrics = CustomerService::getCustomerMetrics($customer);
            return view('pages.customers.customers_details', compact('customer', 'metrics'));
        }

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => [
                'required',
                'string',
                'max:30',
                Rule::unique('customers', 'phone')->where('user_id', $user->id)->ignore($customer->id),
            ],
            'tax_id'       => 'nullable|string|max:50',
            'address'      => 'nullable|string|max:500',
            'notes'        => 'nullable|string|max:1000',
            'metadata'     => 'nullable|array',
        ]);

        $customer->update($validated);

        return redirect()->back()->with(['message' => 'Client updated successfully.', 'response' => 'success']);
    }

    public function customerStats(): array
    {
        $user = Auth::user();

        $totalCustomers = $user->customers()->count();
        $newCustomers = $user->customers()->where('created_at', '>=', now()->subDays(7))->count();

        $unpaidCustomers = $user->customers()->whereHas('invoices', function ($query) {
            $query->whereIn('status', ['pending', 'unpaid']);
        })->count();

        $overdueCustomers = $user->customers()->whereHas('invoices', function ($query) {
            $query->where('status', 'overdue');
        })->count();

        return [
            'total'   => $totalCustomers,
            'new'     => $newCustomers,
            'unpaid'  => $unpaidCustomers,
            'overdue' => $overdueCustomers,
        ];
    }
}
