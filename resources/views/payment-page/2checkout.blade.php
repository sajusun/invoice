<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invozen Test Checkout | 2Checkout Sandbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 p-8">

<div class="max-w-lg mx-auto bg-white shadow-lg p-8 rounded">
    <h1 class="text-2xl font-bold mb-6">Checkout (Test Mode)</h1>
    <form action="https://www.2checkout.com/checkout/purchase" method="POST">
        <input type="hidden" name="sid" value="{{$merchant}}">
        <input type="hidden" name="mode" value="2CO">
        <input type="hidden" name="li_0_type" value="product">
        <input type="hidden" name="li_0_name" value="premium">
        <input type="hidden" name="li_0_price" value="10.00">
        <input type="hidden" name="li_0_quantity" value="1">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="x_receipt_link_url" value="http://127.0.0.1/return.php">
        <input type="submit" value="Pay Now">
    </form>
{{--    <form method="post" action="https://secure.2checkout.com/checkout/purchase">--}}
{{--        <!-- Required Seller ID -->--}}
{{--        <input type="hidden" name="sid" value="{{$merchant}}">--}}
{{--        <input type="hidden" name="mode" value="demo">--}}
{{--        <input type="hidden" name="li_0_type" value="product">--}}
{{--        <input type="hidden" name="li_0_name" value="premium">--}}
{{--        <input type="hidden" name="li_0_price" value="10">--}}
{{--        <input type="hidden" name="currency_code" value="USD">--}}
{{--        <input type="hidden" name="demo" value="Y">--}}

{{--        <div class="mb-4">--}}
{{--            <label class="block text-gray-700">Full Name</label>--}}
{{--            <input type="text" name="card_holder_name" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--        </div>--}}

{{--        <div class="mb-4">--}}
{{--            <label class="block text-gray-700">Email Address</label>--}}
{{--            <input type="email" name="email" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--        </div>--}}

{{--        <div class="mb-4">--}}
{{--            <label class="block text-gray-700">Phone Number</label>--}}
{{--            <input type="text" name="phone" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--        </div>--}}

{{--        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Proceed to Payment</button>--}}
{{--    </form>--}}

    <p class="text-sm text-gray-500 mt-4">Use <strong>test card numbers</strong> on the 2Checkout sandbox page.</p>
</div>

</body>
</html>
