<x-guest-layout>
    <x-slot name="title">Sign In - Invozen</x-slot>

    <div>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Welcome back</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Sign in to manage your invoices and clients.</p>
        </div>

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

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                           placeholder="you@example.com">
                </div>
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                           class="w-full pl-9 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                           placeholder="••••••••">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" id="remember_me" name="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
                <label for="remember_me" class="ml-2 block text-xs font-medium text-slate-600 cursor-pointer">Remember this device</label>
            </div>

            <!-- Submit Button -->
            <div class="pt-1">
                <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all cursor-pointer">
                    Sign in to Dashboard
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                Create free account
            </a>
        </div>
    </div>
</x-guest-layout>
