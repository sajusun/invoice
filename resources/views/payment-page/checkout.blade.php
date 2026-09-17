<x-app-layout>
    <x-slot name="title">Checkout & Upgrade - {{ $plan->name }} | Invozen</x-slot>

    <div class="bg-slate-50 min-h-screen py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumbs / Top Navigation -->
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('subscription.plans') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to Plans
                </a>
                <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-shield-check text-emerald-500"></i> 256-bit SSL Encrypted Checkout
                </div>
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-start">
                <!-- Left Column: Order Summary & Selected Tier -->
                <div class="md:col-span-7 space-y-6">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Selected Tier
                                </span>
                                <h1 class="text-2xl font-extrabold text-slate-900 mt-2">{{ $plan->name }} Plan</h1>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-medium text-slate-400 block">Billing Frequency</span>
                                <span class="text-sm font-bold capitalize text-slate-700">{{ $billingCycle }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-slate-600 mb-6">
                            {{ $plan->description ?? 'Scale your business with high-volume invoicing and automation.' }}
                        </p>

                        <!-- Cycle Selector on Checkout -->
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200/80 mb-6">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Frequency</label>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('payment.form', ['plan' => $plan->id, 'cycle' => 'monthly']) }}"
                                   class="p-3 rounded-xl border text-center transition flex flex-col items-center justify-center {{ $billingCycle === 'monthly' ? 'bg-white border-indigo-600 shadow-sm ring-2 ring-indigo-50' : 'bg-slate-100/60 border-transparent hover:bg-white text-slate-600' }}">
                                    <span class="text-xs font-bold text-slate-900">Monthly</span>
                                    <span class="text-sm font-extrabold text-indigo-600">${{ number_format($plan->monthly_price, 2) }}/mo</span>
                                </a>

                                <a href="{{ route('payment.form', ['plan' => $plan->id, 'cycle' => 'annual']) }}"
                                   class="p-3 rounded-xl border text-center transition flex flex-col items-center justify-center relative {{ $billingCycle === 'annual' ? 'bg-white border-indigo-600 shadow-sm ring-2 ring-indigo-50' : 'bg-slate-100/60 border-transparent hover:bg-white text-slate-600' }}">
                                    <span class="absolute -top-2.5 bg-emerald-500 text-white text-[9px] font-extrabold px-2 py-0.5 rounded-full shadow-xs">
                                        Save 20%
                                    </span>
                                    <span class="text-xs font-bold text-slate-900">Annual</span>
                                    <span class="text-sm font-extrabold text-indigo-600">${{ number_format($plan->annual_monthly_equivalent, 2) }}/mo</span>
                                </a>
                            </div>
                        </div>

                        <!-- Included Key Features -->
                        <div class="border-t border-slate-100 pt-6">
                            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Included with {{ $plan->name }}:</h2>
                            <ul class="space-y-2.5 text-xs text-slate-600">
                                @if($plan->features && is_array($plan->features))
                                    @foreach($plan->features as $feat)
                                        <li class="flex items-center gap-2.5">
                                            <i class="fa-solid fa-circle-check text-indigo-600 text-xs shrink-0"></i>
                                            <span>{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-circle-check text-indigo-600 text-xs shrink-0"></i>
                                        <span>{{ $plan->max_invoices ? number_format($plan->max_invoices) . ' Invoices / month' : 'Unlimited Invoices' }}</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-circle-check text-indigo-600 text-xs shrink-0"></i>
                                        <span>{{ $plan->max_customers ? number_format($plan->max_customers) . ' Client Directory storage' : 'Unlimited Clients' }}</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-circle-check text-indigo-600 text-xs shrink-0"></i>
                                        <span>RESTful Developer API & Webhooks</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Cost Breakdown & Stripe Action -->
                <div class="md:col-span-5 space-y-6">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md">
                        <h2 class="text-lg font-bold text-slate-900 mb-6">Order Breakdown</h2>

                        <div class="space-y-3.5 text-sm pb-6 border-b border-slate-100">
                            <div class="flex justify-between items-center text-slate-600">
                                <span>{{ $plan->name }} ({{ ucfirst($billingCycle) }})</span>
                                <span class="font-bold text-slate-900 font-mono">
                                    @if($billingCycle === 'annual')
                                        ${{ number_format($plan->monthly_price * 12, 2) }}
                                    @else
                                        ${{ number_format($plan->monthly_price, 2) }}
                                    @endif
                                </span>
                            </div>

                            @if($billingCycle === 'annual' && $savings > 0)
                                <div class="flex justify-between items-center text-emerald-600">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-solid fa-tag text-xs"></i> Annual Discount (20%)
                                    </span>
                                    <span class="font-bold font-mono">-${{ number_format($savings, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center text-slate-600">
                                <span>Estimated Taxes & Fees</span>
                                <span class="font-medium text-slate-400 font-mono">$0.00</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="py-6 border-b border-slate-100">
                            <div class="flex justify-between items-baseline">
                                <div>
                                    <span class="text-base font-bold text-slate-900 block">Total Due Today</span>
                                    <span class="text-xs text-slate-400">
                                        {{ $billingCycle === 'annual' ? 'Renews annually' : 'Renews monthly' }}. Cancel anytime.
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl font-extrabold text-slate-900 font-mono">
                                        ${{ number_format($price, 2) }}
                                    </span>
                                    <span class="text-xs text-slate-500 font-medium block">USD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stripe Checkout Form -->
                        <div class="pt-6">
                            <form action="{{ route('stripe.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <input type="hidden" name="billing_cycle" value="{{ $billingCycle }}">

                                <button type="submit"
                                        class="w-full py-4 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition-all shadow-xl shadow-indigo-200 flex items-center justify-center gap-2.5">
                                    <i class="fa-brands fa-stripe text-lg"></i>
                                    <span>Pay with Stripe (${{ number_format($price, 2) }})</span>
                                </button>
                            </form>

                            <p class="text-[11px] text-center text-slate-400 mt-4 leading-relaxed">
                                By completing this checkout, you agree to our <a href="{{ route('t&c') }}" class="underline hover:text-slate-600">Terms of Service</a>. Your plan will be updated immediately upon payment confirmation.
                            </p>
                        </div>
                    </div>

                    <!-- Trust Card -->
                    <div class="p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100/80 flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <div class="text-xs text-slate-600">
                            <strong class="text-slate-900 block">Guaranteed Safe Checkout</strong>
                            We do not store your card details. All transactions are securely processed by Stripe.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
