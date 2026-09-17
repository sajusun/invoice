<x-app-layout>
    <x-slot name="title">Pricing Plans & Subscriptions - Invozen</x-slot>

    <div class="bg-slate-50 min-h-screen py-16 px-4 sm:px-6 lg:px-8">
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
                    Scale your invoicing without limits. Upgrade or switch plans anytime. All plans include automated PDF generation and unlimited guest previews.
                </p>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                @forelse($plans as $plan)
                    @php
                        $isFeatured = strtolower($plan->type) === 'premium';
                        $isBusiness = strtolower($plan->type) === 'business';
                        $isCurrentPlan = $user && $user->plan_id === $plan->id;
                    @endphp

                    <div class="bg-white rounded-3xl p-8 border flex flex-col justify-between transition-all duration-200 relative
                        {{ $isFeatured ? 'border-indigo-600 shadow-2xl shadow-indigo-100 ring-2 ring-indigo-600' : 'border-slate-200/80 shadow-sm hover:shadow-md' }}">
                        
                        @if($isFeatured)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-md">
                                Most Popular
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-slate-900">{{ $plan->name }}</h2>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($isFeatured) bg-indigo-50 text-indigo-700 border border-indigo-100
                                    @elseif($isBusiness) bg-purple-50 text-purple-700 border border-purple-100
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ ucfirst($plan->type) }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mb-6 min-h-[32px]">
                                @if(strtolower($plan->type) === 'free')
                                    Essential tools for freelancers and personal billing.
                                @elseif(strtolower($plan->type) === 'premium')
                                    Complete power for growing agencies and high-volume billing.
                                @else
                                    Enterprise-grade capacity, unlimited quotas & dedicated features.
                                @endif
                            </p>

                            <!-- Price Display -->
                            <div class="flex items-baseline gap-1 mb-8 pb-6 border-b border-slate-100">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono">
                                    ${{ number_format($plan->price, 2) }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">/ year</span>
                            </div>

                            <!-- Features List -->
                            <ul class="space-y-3.5 text-xs text-slate-600 mb-8">
                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    </div>
                                    <span><strong>{{ $plan->max_invoices ? number_format($plan->max_invoices) : 'Unlimited' }}</strong> Invoices / year</span>
                                </li>

                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    </div>
                                    <span><strong>{{ $plan->max_customers ? number_format($plan->max_customers) : 'Unlimited' }}</strong> Clients directory</span>
                                </li>

                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full {{ $plan->price > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $plan->price > 0 ? 'fa-check' : 'fa-xmark' }} text-[10px]"></i>
                                    </div>
                                    <span>Direct Email PDF Dispatch</span>
                                </li>

                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full {{ $plan->price > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $plan->price > 0 ? 'fa-check' : 'fa-xmark' }} text-[10px]"></i>
                                    </div>
                                    <span>Automated Recurring Schedulers</span>
                                </li>

                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full {{ $isBusiness ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $isBusiness ? 'fa-check' : 'fa-xmark' }} text-[10px]"></i>
                                    </div>
                                    <span>Developer REST API & Webhooks</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100">
                            @auth
                                @if($isCurrentPlan)
                                    <button disabled class="w-full py-3 px-4 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 cursor-default flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i> Current Active Plan
                                    </button>
                                @elseif($plan->price == 0)
                                    <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                        Included Free Plan
                                    </a>
                                @else
                                    <a href="{{ route('payment.form', $plan->id) }}"
                                       class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl text-xs font-semibold text-white transition shadow-md
                                       {{ $isFeatured ? 'bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800' }}">
                                        Upgrade to {{ $plan->name }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}"
                                   class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl text-xs font-semibold text-white transition shadow-md
                                   {{ $isFeatured ? 'bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800' }}">
                                    Get Started Free
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
