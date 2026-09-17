<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    /**
     * Find or create a customer for a user based on email or phone.
     */
    public static function findOrCreate(User $user, array $data): Customer
    {
        $email = !empty($data['email']) ? trim($data['email']) : null;
        $phone = !empty($data['phone']) ? trim($data['phone']) : null;

        $customer = null;

        if ($email) {
            $customer = $user->customers()->where('email', $email)->first();
        }

        if (!$customer && $phone && $phone !== '0000000000') {
            $customer = $user->customers()->where('phone', $phone)->first();
        }

        if (!$customer) {
            $customer = $user->customers()->create([
                'name' => $data['name'] ?? 'Valued Client',
                'company_name' => $data['company_name'] ?? null,
                'email' => $email,
                'phone' => $phone ?? '0000000000',
                'tax_id' => $data['tax_id'] ?? null,
                'address' => $data['address'] ?? null,
                'notes' => $data['notes'] ?? null,
                'metadata' => $data['metadata'] ?? null,
            ]);
        } else {
            // Optionally update empty fields if newly provided
            $updates = [];
            if (empty($customer->company_name) && !empty($data['company_name'])) {
                $updates['company_name'] = $data['company_name'];
            }
            if (empty($customer->tax_id) && !empty($data['tax_id'])) {
                $updates['tax_id'] = $data['tax_id'];
            }
            if (empty($customer->address) && !empty($data['address'])) {
                $updates['address'] = $data['address'];
            }
            if (!empty($updates)) {
                $customer->update($updates);
            }
        }

        return $customer;
    }

    /**
     * Update an existing customer.
     */
    public static function updateCustomer(Customer $customer, array $data): Customer
    {
        $fields = ['name', 'company_name', 'email', 'phone', 'tax_id', 'address', 'notes', 'metadata'];
        $updates = [];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $updates[$field] = $data[$field];
            }
        }

        if (!empty($updates)) {
            $customer->update($updates);
        }

        return $customer->fresh();
    }

    /**
     * Delete customer ensuring multi-tenant ownership.
     */
    public static function deleteCustomer(int $customerId, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        if (!$user) {
            return false;
        }

        return (bool) $user->customers()->where('id', $customerId)->delete();
    }

    /**
     * Backward-compatible static method.
     */
    public static function delete_customer($customerId): bool
    {
        return static::deleteCustomer((int) $customerId);
    }

    /**
     * Get financial metrics for a specific customer.
     */
    public static function getCustomerMetrics(Customer $customer): array
    {
        $invoices = $customer->invoices()->where('status', '!=', 'cancelled')->get();

        $totalBilled = (float) $invoices->sum('total_amount');
        $totalPaid = (float) $invoices->sum('paid_amount');
        $totalDue = max(0, round($totalBilled - $totalPaid, 2));

        return [
            'total_invoices' => $customer->invoices()->count(),
            'total_billed' => $totalBilled,
            'total_paid' => $totalPaid,
            'total_due' => $totalDue,
            'unpaid_count' => $customer->invoices()->whereIn('status', ['unpaid', 'partially_paid', 'pending'])->count(),
            'overdue_count' => $customer->invoices()->where('status', 'overdue')->count(),
        ];
    }

    /**
     * List customers with dynamic cursor or offset pagination.
     */
    public static function paginateForUser(
        User $user,
        ?Request $request = null,
        int $perPage = 15
    ): CursorPaginator|LengthAwarePaginator {
        $request = $request ?? request();

        $query = $user->customers()->withCount('invoices');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $perPage = min(100, max(5, (int) $request->get('per_page', $perPage)));

        return $query->latest('created_at')->smartPaginate($perPage);
    }
}
