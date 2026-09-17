<x-guest-layout>
    <x-slot name="title">Verify Email Address - Invozen</x-slot>

    <div>
        <div class="text-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verify your email</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent to your inbox.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>A new verification link has been sent to your email address.</span>
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all cursor-pointer">
                    <i class="fa-solid fa-paper-plane mr-2 text-xs"></i>
                    Resend Verification Email
                </button>
            </form>

            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('profile.edit') }}" class="font-medium text-slate-600 hover:text-indigo-600 transition">
                    Edit Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-medium text-rose-600 hover:text-rose-700 hover:underline cursor-pointer">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
