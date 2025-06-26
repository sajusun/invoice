<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 container">
<div>
    <a href="{{route('admin.dashboard.payments.create')}}" class="p-2 text-white bg-green-600 rounded transition hover:bg-green-600">Make Custom Payment</a>
    @if(session('success'))
        <p class="text-green-600 text-center">{{session('success')}}</p>
    @endif
    <p class="text-2xl font-bold text-gray-800 mb-6 text-center mx-auto py-2">Payment History</p>
    <div class="bg-white p-6 rounded-lg shadow">
        <table class="w-full table-auto">
            <thead>
            <tr class="text-left border-b">
                <th class="py-3">Date</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($payments as $payment)
                <tr class="border-b text-gray-700 cursor-pointer hover:bg-gray-100">
                    <td class="py-3">{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ $payment->user_id }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->plan->name }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>
              <span class="px-2 py-1 rounded text-white text-sm
                  {{ $payment->payment_status == 'success' ? 'bg-green-500' : 'bg-red-500' }}">
                {{ ucfirst($payment->payment_status) }}
              </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">No payment records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
