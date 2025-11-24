<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;


class MethodService
{
    public function filter_invoices(Request $request)
    {
        $query = User::query();

        if ($request->has('status')) {
            if ($request->status == 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status == 'unverified') {
                $query->whereNull('email_verified_at');
            } elseif ($request->status == 'new') {
                $query->whereDate('created_at', now()->toDateString());
            }
        }

        // Search by name, id, or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%")
                    ->orWhere('id', $searchTerm);
            });
        }

        return $query;
    }

}
