<x-guest-layout>
    <x-slot name="title">Reset Password - Invozen</x-slot>

    <div>
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Set new password</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Please create a secure new password for your account.
            </p>
        </div>

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

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required readonly autocomplete="username"
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600 cursor-not-allowed">
                </div>
            </div>

            <!-- New Password -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">New Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required autofocus autocomplete="new-password"
                           class="w-full pl-9 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                           placeholder="At least 8 characters">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Confirm Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                        <i class="fa-solid fa-shield-check"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                           class="w-full pl-9 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                           placeholder="Repeat new password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                        <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all cursor-pointer">
                    Update Password & Sign In
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
