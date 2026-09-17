<x-dashboard-layout>
    <x-slot name="title">Subscription & Billing - {{ $user->settings?->company_name ?? 'Invozen' }}</x-slot>

    <div class="content p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl mx-auto overflow-y-auto"
         x-data="{ billing: '{{ $user->billing_cycle ?? 'monthly' }}', showUpgradeModal: false }">

        <!-- 1. Header & Breadcrumbs -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    <span class="text-slate-800">Subscription & Billing</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>Subscription & Billing Center</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Manage your active plan, monitor real-time monthly usage quotas, and download official payment receipts.
                </p>
            </div>

            <!-- Top Action -->
            <div class="flex items-center gap-3 shrink-0">
                <a href="#available-plans"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-200">
                    <i class="fa-solid fa-sparkles text-xs"></i>
                    <span>Upgrade Plan</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                    <div>
                        <strong class="font-bold block text-emerald-950">Success</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @php
            $currentPlan = $user->plan ?? $plans->first();
            $maxInvoices = $currentPlan?->max_invoices;
            $invoicePercent = $maxInvoices ? min(100, round(($invoicesThisMonth / $maxInvoices) * 100)) : 15;
            $invoicesLeft = $maxInvoices ? max(0, $maxInvoices - $invoicesThisMonth) : null;

            $maxClients = $currentPlan?->max_customers;
            $clientPercent = $maxClients ? min(100, round(($totalClientsCount / $maxClients) * 100)) : 15;
            $clientsLeft = $maxClients ? max(0, $maxClients - $totalClientsCount) : null;

            $isFree = ($currentPlan->monthly_price == 0 || $currentPlan->type === 'free');
            $isAnnual = ($user->billing_cycle === 'annual');

            $nextRenewal = $user->current_period_ends_at ?? $user->expires_at;
            $daysLeft = $nextRenewal ? now()->diffInDays(\Carbon\Carbon::parse($nextRenewal), false) : null;
        @endphp

        <!-- 2. Hero Active Plan Overview Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-9 text-white shadow-2xl border border-slate-800">
            <!-- Background Decorative Glows -->
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid lg:grid-cols-12 gap-8 items-center">
                <!-- Left: Tier Title & Details -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-500/20 border border-blue-400/30 text-blue-200 backdrop-blur-md">
                            <i class="fa-solid fa-crown text-amber-400 text-xs"></i>
                            Current Active Plan
                        </span>
                        
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ ($user->subscription_status ?? 'active') === 'active' ? 'bg-emerald-500/20 border border-emerald-400/30 text-emerald-300' : 'bg-amber-500/20 border border-amber-400/30 text-amber-300' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ ($user->subscription_status ?? 'active') === 'active' ? 'bg-emerald-400 animate-pulse' : 'bg-amber-400' }}"></span>
                            {{ ucfirst($user->subscription_status ?? 'Active') }}
                        </span>

                        <span class="text-xs text-slate-400 capitalize">
                            • {{ $user->billing_cycle ?? 'Monthly' }} Frequency
                        </span>
                    </div>

                    <div>
                        <div class="flex items-baseline gap-3">
                            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                                {{ $currentPlan->name }} Plan
                            </h2>
                            <span class="text-sm sm:text-base font-semibold text-slate-400">
                                @if($isFree)
                                    ($0.00 / Free Forever)
                                @elseif($isAnnual)
                                    ${{ number_format($currentPlan->annual_monthly_equivalent, 2) }} / mo
                                    <span class="text-xs text-indigo-300">(${{ number_format($currentPlan->annual_price, 2) }} billed yearly)</span>
                                @else
                                    ${{ number_format($currentPlan->monthly_price, 2) }} / month
                                @endif
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-xl leading-relaxed">
                            {{ $currentPlan->description ?? 'Empowering your invoicing operations with professional workflows and fast dispatch.' }}
                        </p>
                    </div>

                    <!-- Annual Discount Upgrade Callout (if on monthly paid plan) -->
                    @if(!$isFree && !$isAnnual && $currentPlan->annual_savings > 0)
                        <div class="inline-flex items-center gap-3 p-3 rounded-2xl bg-indigo-500/15 border border-indigo-400/30 text-xs text-indigo-200">
                            <i class="fa-solid fa-tag text-emerald-400 text-sm shrink-0"></i>
                            <span>
                                Switch to Annual billing to save <strong class="text-white">${{ number_format($currentPlan->annual_savings, 0) }} / year (20% OFF)</strong>.
                            </span>
                            <a href="{{ route('payment.form', ['plan' => $currentPlan->id, 'cycle' => 'annual']) }}"
                               class="ml-auto shrink-0 px-2.5 py-1 bg-white text-indigo-900 font-bold rounded-lg hover:bg-indigo-50 transition text-[11px]">
                                Switch & Save
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right: Renewal Stats & Quick Action Box -->
                <div class="lg:col-span-5 bg-white/5 backdrop-blur-md rounded-2xl p-5 border border-white/10 space-y-4">
                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-white/10 text-xs">
                        <div>
                            <span class="text-slate-400 block mb-1">Next Billing Date</span>
                            <span class="font-bold text-white text-sm">
                                @if($nextRenewal)
                                    {{ \Carbon\Carbon::parse($nextRenewal)->format('M d, Y') }}
                                    @if($daysLeft !== null && $daysLeft >= 0)
                                        <span class="text-[10px] text-indigo-300 font-normal block">({{ $daysLeft }} days remaining)</span>
                                    @endif
                                @else
                                    Lifetime Access
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-1">Payment Method</span>
                            <span class="font-bold text-white text-sm flex items-center gap-1.5">
                                @if(!$isFree)
                                    <i class="fa-brands fa-stripe text-indigo-400 text-base"></i> Stripe Secure
                                @else
                                    <i class="fa-solid fa-badge-check text-emerald-400"></i> Free Account
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2.5">
                        <a href="#available-plans"
                           class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white text-slate-900 hover:bg-slate-100 text-xs font-bold rounded-xl transition shadow-md">
                            <i class="fa-solid fa-arrows-rotate text-blue-600 text-xs"></i>
                            <span>Change Subscription</span>
                        </a>

                        <a href="{{ route('subscription.plans') }}"
                           class="inline-flex items-center justify-center gap-2 py-3 px-4 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl border border-white/15 transition">
                            <span>Compare Features</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Usage & Quota Consumption Cards -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie-simple text-blue-600"></i>
                        <span>Monthly Quota Consumption</span>
                    </h2>
                    <p class="text-xs text-slate-500">Real-time resource tracking for the current billing cycle.</p>
                </div>
                <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                    Resets on {{ now()->endOfMonth()->format('M d, Y') }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Invoices Quota Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shadow-xs">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full
                                {{ $invoicePercent > 80 ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                {{ $invoicePercent }}% Used
                            </span>
                        </div>

                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Invoices This Month</h3>
                        <div class="flex items-baseline gap-2 mb-4">
                            <span class="text-3xl font-black text-slate-900 font-mono">
                                {{ number_format($invoicesThisMonth) }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">
                                / {{ $maxInvoices ? number_format($maxInvoices) . ' allowed' : 'Unlimited' }}
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden mb-3">
                            <div class="h-full rounded-full transition-all duration-700
                                {{ $invoicePercent > 85 ? 'bg-gradient-to-r from-amber-500 to-rose-500' : 'bg-gradient-to-r from-blue-600 to-indigo-600' }}"
                                style="width: {{ $maxInvoices ? $invoicePercent : 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                        <span>
                            @if($invoicesLeft !== null)
                                <strong class="text-slate-800">{{ $invoicesLeft }}</strong> invoices left this cycle
                            @else
                                <strong class="text-emerald-600">Infinite</strong> monthly quota
                            @endif
                        </span>
                        <a href="{{ route('invoice.builder') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">
                            + Create
                        </a>
                    </div>
                </div>

                <!-- Customers Directory Quota Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-xs">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full
                                {{ $clientPercent > 80 ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                {{ $clientPercent }}% Used
                            </span>
                        </div>

                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Client Directory Slots</h3>
                        <div class="flex items-baseline gap-2 mb-4">
                            <span class="text-3xl font-black text-slate-900 font-mono">
                                {{ number_format($totalClientsCount) }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">
                                / {{ $maxClients ? number_format($maxClients) . ' contacts' : 'Unlimited' }}
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden mb-3">
                            <div class="h-full rounded-full transition-all duration-700
                                {{ $clientPercent > 85 ? 'bg-gradient-to-r from-amber-500 to-rose-500' : 'bg-gradient-to-r from-emerald-500 to-teal-500' }}"
                                style="width: {{ $maxClients ? $clientPercent : 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                        <span>
                            @if($clientsLeft !== null)
                                <strong class="text-slate-800">{{ $clientsLeft }}</strong> client slots available
                            @else
                                <strong class="text-emerald-600">Unlimited</strong> client directory
                            @endif
                        </span>
                        <a href="{{ route('customers.add') }}" class="font-bold text-emerald-600 hover:text-emerald-800 transition">
                            + Add Client
                        </a>
                    </div>
                </div>

                <!-- Developer & Automation Capabilities Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-base shadow-xs">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full
                                {{ ($currentPlan->has_api_access ?? false) ? 'bg-purple-50 text-purple-700 border border-purple-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ ($currentPlan->has_api_access ?? false) ? 'Developer Ready' : 'Locked' }}
                            </span>
                        </div>

                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Capabilities & Add-ons</h3>
                        
                        <ul class="space-y-2.5 text-xs text-slate-600 mb-4">
                            <li class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-key {{ ($currentPlan->has_api_access ?? false) ? 'text-purple-600' : 'text-slate-400' }}"></i>
                                    <span>RESTful Developer API</span>
                                </span>
                                <span class="font-bold {{ ($currentPlan->has_api_access ?? false) ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ ($currentPlan->has_api_access ?? false) ? 'Enabled' : 'Pro Tier' }}
                                </span>
                            </li>

                            <li class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-repeat {{ ($currentPlan->has_recurring_invoices ?? false) ? 'text-purple-600' : 'text-slate-400' }}"></i>
                                    <span>Recurring Schedulers</span>
                                </span>
                                <span class="font-bold {{ ($currentPlan->has_recurring_invoices ?? false) ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ ($currentPlan->has_recurring_invoices ?? false) ? 'Active' : 'Pro Tier' }}
                                </span>
                            </li>

                            <li class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-palette {{ ($currentPlan->has_custom_branding ?? false) ? 'text-purple-600' : 'text-slate-400' }}"></i>
                                    <span>Remove Watermark</span>
                                </span>
                                <span class="font-bold {{ ($currentPlan->has_custom_branding ?? false) ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ ($currentPlan->has_custom_branding ?? false) ? 'Enabled' : 'Pro Tier' }}
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                        <span>API Keys & Webhooks</span>
                        <a href="{{ route('developer.api-keys') }}" class="font-bold text-purple-600 hover:text-purple-800 transition">
                            Manage &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Available Plans & Upgrade Comparison (In-Page Switcher) -->
        <div id="available-plans" class="bg-white rounded-3xl p-6 sm:p-9 border border-slate-200/80 shadow-sm scroll-mt-6">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                    <i class="fa-solid fa-sparkles text-[10px] mr-1"></i> Flexible Options
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 mb-2">
                    Upgrade or Switch Your Plan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Instantly upgrade quotas with Stripe. Subscriptions apply immediately without downtime.
                </p>

                <!-- Billing Frequency Toggle inside Dashboard -->
                <div class="mt-6 inline-flex items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200">
                    <button @click="billing = 'monthly'"
                            :class="billing === 'monthly' ? 'bg-white text-slate-900 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 rounded-xl text-xs transition-all duration-200">
                        Monthly Billing
                    </button>
                    <button @click="billing = 'annual'"
                            :class="billing === 'annual' ? 'bg-white text-slate-900 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5">
                        <span>Annual Billing</span>
                        <span class="text-[9px] font-extrabold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">
                            Save 20%
                        </span>
                    </button>
                </div>
            </div>

            <!-- Plans Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto items-stretch">
                @foreach($plans as $plan)
                    @php
                        $isPlanSelected = ($user->plan_id === $plan->id);
                        $isFeatured = (bool) $plan->is_popular || strtolower($plan->type) === 'premium';
                        $isBusiness = strtolower($plan->type) === 'business';
                    @endphp

                    <div class="rounded-3xl p-6 sm:p-7 border flex flex-col justify-between transition-all duration-300 relative
                        {{ $isPlanSelected ? 'bg-indigo-50/40 border-indigo-600 ring-2 ring-indigo-500/20 shadow-md' : 'bg-slate-50/50 border-slate-200 hover:border-slate-300 hover:bg-white hover:shadow-md' }}">
                        
                        @if($isPlanSelected)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider shadow-sm flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Current Tier
                            </div>
                        @elseif($isFeatured)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                Most Popular
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">{{ $plan->name }}</h3>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                    {{ $isFeatured ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ ucfirst($plan->slug ?? $plan->type) }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mb-5 min-h-[32px] leading-relaxed">
                                {{ $plan->description ?? 'Reliable invoicing and business scaling tools.' }}
                            </p>

                            <!-- Price Display -->
                            <div class="mb-5 pb-5 border-b border-slate-200/80 min-h-[72px] flex flex-col justify-center">
                                @if($plan->monthly_price == 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-3xl sm:text-4xl font-black text-slate-900 font-mono">$0</span>
                                        <span class="text-xs font-semibold text-slate-500">/ month</span>
                                    </div>
                                    <span class="text-[11px] text-emerald-600 font-medium">Free forever</span>
                                @else
                                    <div x-show="billing === 'monthly'" class="space-y-0.5">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl sm:text-4xl font-black text-slate-900 font-mono">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                            <span class="text-xs font-semibold text-slate-500">/ month</span>
                                        </div>
                                        <span class="text-[11px] text-slate-400">Billed monthly</span>
                                    </div>

                                    <div x-show="billing === 'annual'" class="space-y-0.5" style="display: none;">
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="text-3xl sm:text-4xl font-black text-indigo-600 font-mono">
                                                ${{ number_format($plan->annual_monthly_equivalent, 0) }}
                                            </span>
                                            <span class="text-xs font-semibold text-slate-500">/ mo</span>
                                            <span class="text-xs text-slate-400 line-through">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                        </div>
                                        <span class="text-[11px] text-emerald-700 font-bold block">
                                            Billed ${{ number_format($plan->annual_price, 0) }}/yr (Save ${{ number_format($plan->annual_savings, 0) }})
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Features List -->
                            <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                                @if($plan->features && is_array($plan->features))
                                    @foreach(array_slice($plan->features, 0, 5) as $feat)
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs shrink-0"></i>
                                            <span class="leading-tight">{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <!-- Action Button -->
                        <div>
                            @if($isPlanSelected)
                                <button disabled class="w-full py-3 px-4 rounded-xl text-xs font-bold bg-slate-200/80 text-slate-500 cursor-not-allowed flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-xs"></i> Active Plan
                                </button>
                            @elseif($plan->monthly_price == 0)
                                <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition">
                                    Downgrade to Free
                                </a>
                            @else
                                <a :href="'{{ url('/checkout') }}/{{ $plan->id }}?cycle=' + billing"
                                   class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl text-xs font-bold text-white transition-all shadow-md
                                   {{ $isFeatured ? 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-blue-500/20' : 'bg-slate-900 hover:bg-slate-800' }}">
                                    <span>Select {{ $plan->name }}</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 5. Payment & Billing History Table -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-blue-600"></i>
                        <span>Payment & Renewal History</span>
                    </h3>
                    <p class="text-xs text-slate-500">Official records of all transactions processed for this account.</p>
                </div>

                <span class="text-xs font-semibold text-slate-400">
                    {{ $payments->count() }} Total Transactions
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-[11px] uppercase tracking-wider font-bold border-b border-slate-100">
                            <th class="py-3.5 px-4">Transaction Date</th>
                            <th class="py-3.5 px-4">Plan / Cycle</th>
                            <th class="py-3.5 px-4">Billed Amount</th>
                            <th class="py-3.5 px-4">Payment Method</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Invoice Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-calendar-check text-slate-400 text-xs"></i>
                                        <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-mono block ml-5">
                                        {{ $payment->created_at->format('h:i A') }}
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-900">{{ $payment->plan->name ?? 'Subscription Plan' }}</div>
                                    <div class="text-[11px] text-slate-400 capitalize flex items-center gap-1">
                                        <i class="fa-solid fa-arrows-rotate text-[9px]"></i>
                                        <span>{{ $payment->billing_cycle ?? 'Monthly' }} Billing</span>
                                    </div>
                                </td>

                                <td class="py-4 px-4 font-mono font-bold text-slate-900">
                                    ${{ number_format($payment->amount, 2) }}
                                    <span class="text-[10px] font-normal text-slate-400">{{ $payment->currency ?? 'USD' }}</span>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                                        @if(str_contains(strtolower($payment->payment_method), 'stripe'))
                                            <i class="fa-brands fa-stripe text-indigo-600 text-lg"></i> Stripe Checkout
                                        @else
                                            <i class="fa-solid fa-credit-card text-slate-400 text-xs"></i> {{ ucfirst($payment->payment_method) }}
                                        @endif
                                    </span>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $payment->payment_status === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-right">
                                    @if($payment->receipt_url)
                                        <a href="{{ $payment->receipt_url }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[11px] transition">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> View
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                                            <i class="fa-solid fa-check text-[10px]"></i> Settled
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">No transaction records found</p>
                                    <p class="text-xs text-slate-400 mt-0.5">When you upgrade or renew subscriptions, invoice receipts will show up here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 6. Billing Security & Support Guarantee Banner -->
        <div class="grid sm:grid-cols-3 gap-4 text-xs text-slate-600">
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-shield-halved text-sm"></i>
                </div>
                <div>
                    <strong class="text-slate-900 block font-bold">256-bit Stripe Security</strong>
                    Encrypted end-to-end payment processing.
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-arrows-rotate text-sm"></i>
                </div>
                <div>
                    <strong class="text-slate-900 block font-bold">Cancel Anytime</strong>
                    No locked contracts. Switch tiers freely.
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-headset text-sm"></i>
                </div>
                <div>
                    <strong class="text-slate-900 block font-bold">Dedicated Support</strong>
                    Have billing questions? <a href="{{ route('contact.form') }}" class="text-blue-600 font-semibold hover:underline">Contact us</a>.
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
