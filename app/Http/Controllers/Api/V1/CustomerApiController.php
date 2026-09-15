<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateCustomerRequest;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Models\Customers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    /**
     * List user customers.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = $user->customers();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $perPage = min(100, max(5, (int) $request->get('per_page', 15)));
        $customers = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => CustomerResource::collection($customers),
            'meta'    => [
                'current_page' => $customers->currentPage(),
                'per_page'     => $customers->perPage(),
                'total'        => $customers->total(),
                'last_page'    => $customers->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new customer.
     */
    public function store(CreateCustomerRequest $request): JsonResponse
    {
        $user = $request->user();

        // Check plan customer limit
        $plan = $user->plan;
        if ($plan && $plan->max_customers !== null) {
            $currentCount = $user->customers()->count();
            if ($currentCount >= $plan->max_customers) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Quota Exceeded',
                    'message' => "You have reached your plan limit of {$plan->max_customers} customers.",
                ], 403);
            }
        }

        $validated = $request->validated();
        $validated['user_id'] = $user->id;

        $customer = Customers::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully.',
            'data'    => new CustomerResource($customer),
        ], 201);
    }

    /**
     * Retrieve single customer details.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $customer = $user->customers()->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Customer '{$id}' not found.",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => new CustomerResource($customer),
        ]);
    }

    /**
     * Delete customer.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $customer = $user->customers()->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'error'   => 'Not Found',
                'message' => "Customer '{$id}' not found.",
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
