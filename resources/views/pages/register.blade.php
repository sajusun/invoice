<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Sign Up for Invozen - Create Your Free Account</title>
    <meta name="description" content="Join Invozen today and streamline your invoicing process. Sign up for free and start creating invoices in seconds.">
    <meta name="keywords" content="sign up, invozen register, create account, free invoicing">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.invozen.com/register">
</head>
<body class="w-screen h-screen">
<div class="h-full bg-gray-100 flex items-center justify-center">
<div class="max-w-lg w-full p-8  bg-white shadow-md rounded-lg">
    <div class="text-xl font-bold text-gray-800 text-center border-b pb-4 ">Create an account</div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ $errors->first() }}</p>
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST" class="space-y-2 pt-3">
        @csrf
        <div>
            <label class="block text-gray-700">Full Name</label>
            <input type="text" name="name" required class="w-full border px-3 py-2 rounded mt-1" value="{{old('name')}}">
        </div>

        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full border px-3 py-2 rounded mt-1" value="{{old('email')}}">
        </div>

{{--        <div>--}}
{{--            <label class="block text-gray-700">Phone Number</label>--}}
{{--            <input type="text" name="phone" required class="w-full border px-3 py-2 rounded mt-1" value="{{old('phone')}}">--}}
{{--        </div>--}}

        <div>
            <label class="block text-gray-700">Country</label>
            <select name="country" required class="w-full border px-3 py-2 rounded mt-1 cursor-pointer">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option class="cursor-pointer p-2" value="{{$country['name']}}">{{$country['name']}}</option>
                @endforeach
{{--                <option value="BD">Bangladesh</option>--}}
{{--                <option value="US">United States</option>--}}
{{--                <option value="IN">India (+91)</option>--}}
{{--                <option value="GB">United Kingdom</option>--}}
{{--                <option value="CA">Canada</option>--}}
            </select>
        </div>

{{--        <div>--}}
{{--            <label class="block text-gray-700">Preferred Currency</label>--}}
{{--            <select name="currency" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--                <option value="">Select Currency</option>--}}
{{--                <option value="USD">USD ($)</option>--}}
{{--                <option value="BDT">BDT (৳)</option>--}}
{{--                <option value="INR">INR (₹)</option>--}}
{{--                <option value="GBP">GBP (£)</option>--}}
{{--                <option value="EUR">EUR (€)</option>--}}
{{--            </select>--}}
{{--        </div>--}}
        <div>
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 rounded mt-1">
        </div>
        <div>
            <label class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border px-3 py-2 rounded mt-1">
        </div>
        <div class="h-min">
            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 mt-4 rounded">Sign Up</button>

        </div>
    </form>
  <div class="my-2 py-2 w-full text-right">
      <a href="{{ route('login') }}" class="text-blue-500 text-sm">Already have an account? Login</a>
  </div>
</div>
</div>
</body>
</html>
