<x-app-layout>
    <x-slot name="header">
        <x-admin-navbar></x-admin-navbar>
    </x-slot>

<div class="flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full max-h-screen bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-red-500 mb-6 text-center">Admin Login</h2>
        @if ($errors->any())
            <div class="text-red-400 text-sm align-baseline">
                @foreach ($errors->all() as $error)
                    <span style="font-size: .8rem">{{ $error }}</span>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2
                    focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                    placeholder="your@email.com" required
                />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                <input
                    type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2
                     focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                    placeholder="••••••••" required
                />
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" id="remember_me" class="rounded border-gray-300 text-indigo-600
                    focus:ring-indigo-500" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600" >Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm color-main hover:text-indigo-500">Forgot
                    password?</a>
            </div>
            <button
                class="w-full bg-primary hover:bg-primary-dark text-white
                 font-medium py-2.5 rounded-lg transition-colors"
                type="submit">
                Sign In
            </button>
        </form>
    </div>
</div>

</x-app-layout>
