<x-home-layout>
    <x-slot name="meta">
        <title>{{config('app.name')}} - Admin Access</title>
        <meta name="description"
              content="Log in to your Invozen account to manage your invoices, clients, and payments securely.">
        <meta name="keywords" content="login, invozen, account login, invoice software login">
        <meta name="robots" content="noindex, nofollow">
        <link rel="canonical" href="{{ route('admin.login') }}">
    </x-slot>
    <x-slot name="header"></x-slot>
    <div class="auth-container flex items-center justify-center py-12 px-4">
        <div id="login-form" class="w-full max-w-md auth-card bg-white p-8">
            <div class="text-center mb-8">
                <a href="/"><h1 class="text-3xl font-bold text-primary">{{config('app.name')}} Admin</h1></a>
                <p class="text-gray-600 mt-2">Sign in admin account</p>
            </div>
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
</x-home-layout>
