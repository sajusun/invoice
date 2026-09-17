<x-app-layout>
    <x-slot name="title">Pricing Plans & Subscriptions - Invozen</x-slot>

    <div class="bg-slate-50 min-h-screen py-16 px-4 sm:px-6 lg:px-8" x-data="{ billing: '{{ $user->billing_cycle ?? 'monthly' }}' }">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-4">
                    <i class="fa-solid fa-sparkles"></i> Simple, Transparent Pricing
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Plans built for freelancers, agencies & enterprises
                </h1>
                <p class="mt-4 text-slate-500 text-sm sm:text-base leading-relaxed">
                    Scale your invoicing without limits. Upgrade or switch plans anytime. All paid plans include automated recurring invoicing, webhooks, and REST API keys.
                </p>

                <!-- Billing Toggle -->
                <div class="mt-8 inline-flex items-center gap-1.5 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
                    <button @click="billing = 'monthly'"
                            :class="billing === 'monthly' ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200">
                        Monthly Billing
                    </button>
                    <button @click="billing = 'annual'"
                            :class="billing === 'annual' ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center gap-2">
                        <span>Annual Billing</span>
                        <span class="text-[10px] font-extrabold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full shadow-xs">
                            Save 20%
                        </span>
                    </button>
                </div>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                @forelse($plans as $plan)
                    @php
                        $isFeatured = (bool) $plan->is_popular || strtolower($plan->type) === 'premium' || $loop->iteration == 2;
                        $isBusiness = strtolower($plan->type) === 'business' || $loop->iteration == 3;
                        $isCurrentPlan = $user && $user->plan_id === $plan->id;
                    @endphp

                    <div class="bg-white rounded-3xl p-8 border flex flex-col justify-between transition-all duration-200 relative
                        {{ $isCurrentPlan ? 'border-emerald-500 ring-2 ring-emerald-100 shadow-lg' : ($isFeatured ? 'border-indigo-600 shadow-2xl shadow-indigo-100 ring-2 ring-indigo-600' : 'border-slate-200/80 shadow-sm hover:shadow-md') }}">
                        
                        @if($isCurrentPlan)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-emerald-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-md flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-xs"></i> Active Plan
                            </div>
                        @elseif($isFeatured)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-md">
                                Most Popular
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-2xl font-bold text-slate-900">{{ $plan->name }}</h2>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($isFeatured) bg-indigo-50 text-indigo-700 border border-indigo-100
                                    @elseif($isBusiness) bg-purple-50 text-purple-700 border border-purple-100
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ ucfirst($plan->slug ?? $plan->type) }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mb-6 min-h-[36px] leading-relaxed">
                                {{ $plan->description ?? 'Essential tools for freelancers and growing billing needs.' }}
                            </p>

                            <!-- Price Display -->
                            <div class="mb-8 pb-6 border-b border-slate-100 min-h-[96px] flex flex-col justify-center">
                                @if($plan->monthly_price == 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono">$0</span>
                                        <span class="text-sm font-semibold text-slate-500">/ month</span>
                                    </div>
                                    <span class="text-xs font-medium text-emerald-600 mt-1">Included free forever</span>
                                @else
                                    <!-- Monthly Price View -->
                                    <div x-show="billing === 'monthly'" class="space-y-1">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                            <span class="text-sm font-semibold text-slate-500">/ month</span>
                                        </div>
                                        <span class="text-xs font-medium text-slate-400 block">Billed monthly</span>
                                    </div>

                                    <!-- Annual Price View -->
                                    <div x-show="billing === 'annual'" class="space-y-1" style="display: none;">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono text-indigo-600">
                                                ${{ number_format($plan->annual_monthly_equivalent, 0) }}
                                            </span>
                                            <span class="text-sm font-semibold text-slate-500">/ mo</span>
                                            <span class="text-sm font-semibold text-slate-400 line-through">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                            <i class="fa-solid fa-tag text-[10px]"></i>
                                            <span>Billed ${{ number_format($plan->annual_price, 0) }}/yr (Save ${{ number_format($plan->annual_savings, 0) }})</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Features List -->
                            <div class="mb-8">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-3.5">Included Features:</span>
                                <ul class="space-y-3 text-xs text-slate-600">
                                    @if($plan->features && is_array($plan->features))
                                        @foreach($plan->features as $feat)
                                            <li class="flex items-center gap-2.5">
                                                <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                    <i class="fa-solid fa-check text-[9px]"></i>
                                                </div>
                                                <span class="leading-relaxed">{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span><strong>{{ $plan->max_invoices ? number_format($plan->max_invoices) : 'Unlimited' }}</strong> Invoices / month</span>
                                        </li>
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span><strong>{{ $plan->max_customers ? number_format($plan->max_customers) : 'Unlimited' }}</strong> Client Directory profiles</span>
                                        </li>
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span>RESTful Developer API & Webhooks</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100">
                            @auth
                                @if($isCurrentPlan)
                                    <button disabled class="w-full py-3.5 px-4 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 cursor-default flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i> Current Active Plan
                                    </button>
                                @elseif($plan->monthly_price == 0)
                                    <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                        Included Free Plan
                                    </a>
                                @else
                                    <a :href="'{{ url('/checkout') }}/{{ $plan->id }}?cycle=' + billing"
                                       class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl text-xs font-bold text-white transition-all shadow-md
                                       {{ $isFeatured ? 'bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800' }}">
                                        Upgrade to {{ $plan->name }}
                                        <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                                    </a>
                                @endif
                            @else
                                <a :href="'{{ route('register') }}?plan={{ $plan->slug ?? $plan->type }}&cycle=' + billing"
                                   class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl text-xs font-bold text-white transition-all shadow-md
                                   {{ $isFeatured ? 'bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800' }}">
                                    Get Started
                                    <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        No pricing plans found. Please seed the database.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
