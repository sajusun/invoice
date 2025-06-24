<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 space-y-2 container">
<div class="shadow-sm border py-4 my-4">
    <div class="max-w-5xl mx-auto text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800">Our Subscription Plan</h1>
        <p class="text-gray-600 mt-2">Select the plan that fits your needs and start managing your invoices.</p>
    </div>
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Free Plan -->
        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{$plans[0]->name}}</h2>
            <p class="text-gray-600 mb-6">Perfect for individuals and startups.</p>
            <div class="text-4xl font-bold text-blue-600 mb-6">${{$plans[0]->price}} <span
                    class="text-base font-medium text-gray-500">/Year</span></div>

            <ul class="text-gray-700 mb-8 space-y-3 text-left">
                <li>✔️ Store Up to {{$plans[0]->max_invoices}} invoices</li>
                <li>✔️ Save Max {{$plans[0]->max_customers}} customers Data</li>
                <li>❌ No premium templates</li>
                <li>❌ No priority support</li>
            </ul>
            @auth()
                @if($user->plan_id===$plans[0]->id)
                    <button class="mt-auto bg-gray-700 text-white py-2 px-4 rounded cursor-not-allowed">Activated
                    </button>
                @else
                    <a href="#" class="mt-auto bg-blue-600 text-white py-2 px-4 rounded cursor-not-allowed">
                        Free
                    </a>
                @endif
            @else
                <button class="mt-auto bg-blue-600 text-white py-2 px-4 rounded cursor-not-allowed">
                    Free Plan
                </button>
            @endauth
        </div>

        <!-- Premium Plan -->
        <div class="bg-white rounded-lg shadow p-6 border-2 border-yellow-500 flex flex-col">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{$plans[1]->name}}</h2>
            <p class="text-gray-600 mb-6">For businesses with higher invoicing needs.</p>
            <div class="text-4xl font-bold text-yellow-500 mb-6">${{$plans[1]->price}} <span
                    class="text-base font-medium text-gray-500">/Year</span>
            </div>
            <ul class="text-gray-700 mb-8 space-y-3 text-left">
                <li>✔️ Store Up to {{$plans[1]->max_invoices}} invoices</li>
                <li>✔️ Save Max {{$plans[1]->max_customers}} customers Data</li>
                <li>✔️ Premium templates</li>
                <li>✔️ Priority support</li>
            </ul>
            @auth()
                @if($user->plan_id===$plans[1]->id)
                    <button class="mt-auto bg-yellow-600 text-white py-2 px-4 rounded cursor-not-allowed">
                        Activated
                    </button>
                @else
                    <a href="{{route('payment.form',$plans[1]->id)}}" class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                        Choose Premium
                    </a>
                @endif
            @else
                <a href="{{route('payment.form',$plans[1]->id)}}" class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                    Choose Premium
                </a>
            @endauth
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{$plans[2]->name}}</h2>
            <p class="text-gray-600 mb-6">For growing companies with extra needs.</p>
            <div class="text-4xl font-bold text-green-600 mb-6">${{$plans[2]->price}} <span
                    class="text-base font-medium text-gray-500">/Year</span>
            </div>
            <ul class="text-gray-700 mb-8 space-y-3 text-left">
                <li>✔️ Store Up to {{$plans[2]->max_invoices}} invoices</li>
                <li>✔️ Save Max {{$plans[2]->max_customers}} customers Data</li>
                <li>✔️ Custom invoice branding</li>
                <li>✔️ Dedicated account manager</li>
            </ul>
            @auth()
                @if($user->plan_id===$plans[2]->id)
                    <button class="mt-auto bg-green-700 text-white py-2 px-4 rounded cursor-not-allowed">
                        Activated
                    </button>
                @else
                    <a href="{{route('payment.form',$plans[2]->id)}}" class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                        Choose Business
                    </a>
                @endif
            @else
                <a href="{{route('payment.form',$plans[2]->id)}}" class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                    Choose Business
                </a>
            @endauth
        </div>

    </div>

</div>
<div>
    <span class="text-2xl font-bold text-gray-800 mb-6 text-center mx-auto p-4">Payment History</span>
    <div class="bg-white p-6 rounded-lg shadow">
        <table class="w-full table-auto">
            <thead>
            <tr class="text-left border-b">
                <th class="py-3">Date</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($payments as $payment)
                <tr class="border-b text-gray-700">
                    <td class="py-3">{{ $payment->created_at->format('Y-m-d') }}</td>
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
