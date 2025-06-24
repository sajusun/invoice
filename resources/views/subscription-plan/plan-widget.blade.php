<div class="max-w-5xl mx-auto text-center mb-10">
    <h1 class="text-4xl font-bold text-gray-800">Choose Your Plan</h1>
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
                <button class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-default">Activated
                </button>
            @endif
        @else
            <button class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                Choose Free
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
                <button class="mt-auto bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition cursor-default">
                    Activated
                </button>
            @endif
        @else
            <button class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                Choose Premium
            </button>
        @endauth
    </div>

    <!-- Another Plan Example (optional) -->
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
                <button class="mt-auto bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition cursor-default">
                    Activated
                </button>
            @endif
        @else
            <button class="mt-auto bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                Choose Business
            </button>
        @endauth
    </div>

</div>
