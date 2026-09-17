<x-guest-layout>
    <x-slot name="title">Forgot Password - Invozen</x-slot>

    <div>
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-key"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Forgot password?</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                No problem. Enter your email address and we'll send you a password reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($errors->any())
            <div class="mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-700 text-xs font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Account Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                           placeholder="you@example.com">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all cursor-pointer">
                    Email Password Reset Link
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-xs">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to sign in
            </a>
        </div>
    </div>
</x-guest-layout>
