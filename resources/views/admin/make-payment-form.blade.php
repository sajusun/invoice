<x-admin-layout>
    <x-slot name="title">Manual Payment & Plan Assignment</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Custom / Manual Subscription Assignment</h1>
                <p class="text-xs text-slate-500 mt-1">Assign or upgrade a platform user's plan manually without requiring an online payment gateway.</p>
            </div>
            <a href="{{ route('admin.dashboard.payments') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Payments</span>
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
            <form action="{{ route('admin.dashboard.payments.create') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">User ID</label>
                    <input type="number" name="user_id" value="{{ old('user_id', request('user_id')) }}" required placeholder="e.g. 15"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Enter the numeric user ID from the user directory.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Target Plan</label>
                    <select name="plan_id" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->name }} — ${{ number_format($plan->price, 2) }} ({{ ucfirst($plan->type) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.dashboard.payments') }}"
                       class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-rose-600/20 hover:shadow-md transition-all cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Confirm & Assign Subscription</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
