<x-admin-layout>
    <x-slot name="title">User Details - {{ $user->name }}</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <!-- 1. Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">User Account Overview</h1>
                <p class="text-xs text-slate-500 mt-1">Comprehensive profile, billing history, connected clients, and administrative overrides.</p>
            </div>
            <a href="{{ route('admin.dashboard.users-list') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors self-start">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Users</span>
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- 2. User Hero Card -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 backdrop-blur-md p-1 border-2 border-white/20 shadow-lg overflow-hidden shrink-0 flex items-center justify-center font-black text-2xl text-white">
                    @if($user->profile_pic)
                        <img src="{{ $user->social_login ? $user->profile_pic : asset('storage/profile_pics/' . $user->profile_pic) }}"
                             alt="{{ $user->name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <span>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                    @endif
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-xl sm:text-2xl font-black">{{ $user->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $user->email_verified_at ? 'bg-emerald-400/20 text-emerald-300 border border-emerald-400/30' : 'bg-amber-400/20 text-amber-300 border border-amber-400/30' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-blue-100 border border-white/20">
                            {{ $user->plan?->name ?? 'Free Tier' }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 flex items-center gap-2">
                        <i class="fa-regular fa-envelope"></i> {{ $user->email }}
                        <span class="text-white/40">•</span>
                        <span>User ID #{{ $user->id }}</span>
                        <span class="text-white/40">•</span>
                        <span>Joined {{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard.payments.create') }}?user_id={{ $user->id }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-md transition-all">
                    <i class="fa-solid fa-plus"></i> Assign Plan
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 3. Account Information Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user text-rose-600"></i>
                        <span>Account Information</span>
                    </h3>
                </div>

                <form method="post" action="{{ route('user.data', $user->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">User Name</label>
                        <input name="name" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500" value="{{ $user->name }}" required />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                        <input name="email" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500" value="{{ $user->email }}" required />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Verification Status</label>
                        <select name="email_verified_at" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                            <option value="verified" {{ $user->email_verified_at ? 'selected' : '' }}>Verified</option>
                            <option value="" {{ !$user->email_verified_at ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </div>
                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all">
                            Save Account Info
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Reset User Password</h4>
                    <form method="post" action="{{ route('user.password', $user->id) }}" class="space-y-3">
                        @csrf
                        <div>
                            <input type="password" name="password" placeholder="New Password" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500" required />
                        </div>
                        <div>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500" required />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition-all">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 4. Company & Business Settings -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-building text-blue-600"></i>
                        <span>Company & Organization</span>
                    </h3>
                </div>

                <form method="post" action="{{ route('user.company', $user->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company Name</label>
                        <input name="company_name" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->settings?->company_name }}" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company Email</label>
                        <input name="company_email" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->settings?->company_email }}" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company Phone</label>
                        <input name="company_phone" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->settings?->company_phone }}" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company Address</label>
                        <input name="company_address" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->settings?->company_address }}" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Default Currency</label>
                        <select id="default_currency" name="default_currency" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @foreach(['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'BDT' => 'BDT (৳)', 'INR' => 'INR (₹)'] as $code => $label)
                                <option value="{{ $code }}" {{ ($user->settings?->default_currency ?? 'USD') == $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all">
                            Save Company Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 5. Payment Records Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-rose-600"></i>
                    <span>User Payment History</span>
                </h3>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                    {{ count($user->payments) }} Transactions
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-6">Date</th>
                            <th class="py-3 px-6">Plan</th>
                            <th class="py-3 px-6">Amount</th>
                            <th class="py-3 px-6">Method</th>
                            <th class="py-3 px-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse ($user->payments as $payment)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 px-6">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                <td class="py-3 px-6 font-bold text-slate-900">{{ $payment->plan?->name ?? 'Custom' }}</td>
                                <td class="py-3 px-6 font-extrabold text-slate-900">${{ number_format($payment->amount, 2) }}</td>
                                <td class="py-3 px-6">{{ ucfirst($payment->payment_method ?? 'Manual') }}</td>
                                <td class="py-3 px-6 text-right">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $payment->payment_status === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700' }}">
                                        {{ ucfirst($payment->payment_status ?? 'success') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">No payment records found for this user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
