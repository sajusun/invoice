<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment for {{ $plan->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Pay for {{ $plan->name }}</h1>
    <p class="text-gray-600 mb-6">Amount: <span class="text-xl font-semibold">${{ $plan->price }}</span></p>

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

        <!-- Mock Payment Method -->
        <select name="payment_method" class="mb-4 border rounded px-3 py-2 w-full">
            <option value="manual">Manual Payment</option>
            <!-- or bKash, Stripe etc -->
        </select>

        <button type="submit"
                class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Confirm Payment</button>
    </form>
</div>

</body>
</html>
