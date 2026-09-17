<x-app-layout>
    <x-slot name="title">Checkout Cancelled - Invozen</x-slot>

    <div class="min-h-screen bg-slate-50 flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 shadow-xl text-center">
            <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                <i class="fa-solid fa-arrow-rotate-left text-2xl"></i>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-100">
                Checkout Incomplete
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-4 mb-2 tracking-tight">
                No charges were made
            </h1>

            <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                You cancelled the Stripe checkout process. Your current plan remains unchanged. If you have questions about our plans or pricing, feel free to contact us.
            </p>

            <div class="space-y-3">
                <a href="{{ route('subscription.plans') }}" class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition-all shadow-lg shadow-indigo-100">
                    Try Again / View Plans
                </a>

                <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
