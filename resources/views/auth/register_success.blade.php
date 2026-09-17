<x-guest-layout>
    <x-slot name="title">Signup Successful - Invozen</x-slot>

    <div class="text-center">
        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Signup Successful!</h2>
        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
            Thank you for registering. We've sent an activation link to <span class="font-bold text-slate-900">{{ $email }}</span>.
        </p>
        <p class="text-xs text-slate-400 mt-1">
            Please check your inbox and verify your email to unlock all features.
        </p>

        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col gap-2.5">
            <a href="{{ route('dashboard') }}"
               class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition">
                Continue to Dashboard
            </a>
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
                Back to Homepage
            </a>
        </div>
    </div>
</x-guest-layout>
