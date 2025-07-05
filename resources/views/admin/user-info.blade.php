<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <p>{{ $errors->first() }}</p>
    </div>
@endif
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow space-y-2">
    <!-- 🔹 User Info -->
    <section class="p-4 shadow-sm">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">Account Information</h2>
        </div>
        <form method="post" action="{{route('user.data',$user->id)}}" class="mb-4 flex flex-col gap-2">
            @csrf
            <div class="grid grid-cols-3 gap-4 border-b pb-4">
                <div class="space-x-1">
                    <label for="name">Name :</label>
                    <input name="name" class="border rounded px-2 py-1" value="{{$user->name}}"/>
                </div>
                <div class="space-x-1">
                    <label for="name">Email :</label>
                    <input name="email" class="border rounded px-2 py-1" value="{{$user->email}}"/>
                </div>
                <div class="space-x-1">
                    <select name="email_verified_at" class="border rounded px-2 py-1">
                        <option value="verified" {{ $user->email_verified_at  ? 'selected' : '' }}>Verified</option>
                        <option value="" {{ $user->email_verified_at =='' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div class="space-x-1">
                    <button type="submit"
                            class="py-1 px-4 rounded-sm text-white bg-blue-500 transition hover:bg-blue-600 shadow-sm">
                        Save
                    </button>
                </div>
            </div>
        </form>

        <form method="post" action="{{route('user.password',$user->id)}}">
            @csrf
            <div class="grid grid-cols-3 gap-4 border-b pb-4">
                <div class="space-x-1">
                    <label for="password">New Password :</label>
                    <input type="password" name="password" class="border rounded px-2 py-1"/>
                </div>
                <div class="space-x-1">
                    <label for="confirm_password">Confirm Password :</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="border rounded px-2 py-1"/>
                </div>
                <div class="space-x-1">
                    <button class="py-1 px-4 rounded-sm text-white bg-red-400 transition hover:bg-red-600 shadow-sm">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </section>

    {{--    company information--}}
    <section class="p-4 shadow-sm">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">Company Information</h2>
        </div>
        <form method="post" action="{{route('user.company',$user->id)}}" class="mb-4 flex flex-col gap-2">
            @csrf
            <div class="grid grid-cols-3 gap-4">
                <div class="space-x-1">
                    <label for="company_name">Name :</label>
                    <input name="company_name" class="border rounded px-2 py-1" value="{{$user->settings->company_name}}"/>
                </div>
                <div class="space-x-1">
                    <label for="company_email">Email :</label>
                    <input name="company_email" class="border rounded px-2 py-1" value="{{$user->settings->company_email}}"/>
                </div>
                <div class="space-x-1">
                    <label for="company_phone">Phone :</label>
                    <input name="company_phone" class="border rounded px-2 py-1" value="{{$user->settings->company_phone}}"/>
                </div>
                <div class="space-x-1">
                    <label for="company_address">Address :</label>
                    <input name="company_address" class="border rounded px-2 py-1" value="{{$user->settings->company_address}}"/>
                </div>
                <div class="space-x-1">
                    <select id="default_currency" name="default_currency" class="w-32 py-1 px-4">
                        <option class="bg-gray-400" value="{{$user->settings->default_currency}}" selected >
                            {{$user->settings->default_currency}} selected
                        </option>
                        <option value="BDT">BDT</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
                </div>
                <div class="space-x-1">
                    <button type="submit" class="py-1 px-4 rounded-sm text-white bg-blue-500 transition hover:bg-blue-600 shadow-sm">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- 🔹 Saved Customers -->
    <section>
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">Saved Customers</h2>
            <a href="#" class="text-blue-600 hover:underline">Edit</a>
        </div>
        <div class="bg-gray-50 rounded p-4">
            @forelse ($user->customers as $customer)
                <div class="border-b py-2">
                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                </div>
            @empty
                <p class="text-gray-500">No customer records found.</p>
            @endforelse
        </div>
    </section>

    <!-- 🔹 Payments -->
    <section>
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">Payment History</h2>
            <a href="#" class="text-blue-600 hover:underline">View All</a>
        </div>
        <div class="bg-gray-50 rounded p-4">
            @forelse ($user->payments as $payment)
                <div class="border-b py-2">
                    <p><strong>Amount:</strong> ${{ $payment->amount }}</p>
                    <p><strong>Date:</strong> {{ $payment->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                </div>
            @empty
                <p class="text-gray-500">No payment records found.</p>
            @endforelse
        </div>
    </section>

    <!-- 🔹 Subscription Plan -->
    <section>
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">Current Plan</h2>
            <a href="#" class="text-blue-600 hover:underline">Change</a>
        </div>
        @if ($user->plan)
            <div class="bg-gray-50 rounded p-4">
                <p><strong>Plan:</strong> {{ $user->plan->name }}</p>
                <p><strong>Limit:</strong> {{ $user->plan->max_invoices }} invoices, {{ $user->plan->max_customers }}
                    customers</p>
                <p><strong>Expires:</strong> {{ $user->plan_expires_at ?? 'N/A' }}</p>
            </div>
        @else
            <p class="text-gray-500">No active plan.</p>
        @endif
    </section>

</div>
</body>
</html>

