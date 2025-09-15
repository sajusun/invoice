<x-guest-layout>
    <x-slot name="head">
            <title>Login to Invozen - Secure Access</title>
            <meta name="description"
                  content="Log in to your Invozen account to manage your invoices, clients, and payments securely.">
            <meta name="keywords" content="login, invozen, account login, invoice software login">
            <meta name="robots" content="index, follow">
            <link rel="canonical" href="{{config('app.url')}}/login">
    </x-slot>
    <x-slot name="header"></x-slot>
<div class="auth-container flex items-center justify-center py-12 px-4">
    <!-- Login Form -->
    <div id="login-form" class="w-full max-w-md auth-card bg-white p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary">{{config('app.name', 'Laravel')}}</h1>
            <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>
                @if ($errors->any())
                    <div class="text-red-400 text-sm align-baseline">
                        @foreach ($errors->all() as $error)
                            <span class="text-sm">{{ $error }}</span>
                        @endforeach
                    </div>
                @endif
        <form action="{{ route('login') }}" method="post" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" id="email" name="email"
                       class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-colors"
                       placeholder="you@example.com">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password"
                       class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-colors"
                       placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary-dark">Forgot password?</a>
            </div>
            <button type="submit" id="login-btn"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                Sign in
            </button>
        </form>
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-3 text-gray-400 text-sm">Or</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>
        <!-- Social Login Section -->
        <div class="mt-6 space-y-4">
            <div class="flex justify-center items-center space-x-4">
                <!-- Google Login -->
                <a href="{{ url('login/google') }}"
                   class="w-full flex justify-center items-center border rounded-lg py-2 bg-white text-gray-700 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/archive/c/c1/20221203181232%21Google_%22G%22_logo.svg"
                        alt="Google"
                        class="w-5 h-5 mr-3"> Google
                </a>
            </div>
            <div class="flex justify-center items-center space-x-4">
                <!-- Facebook Login -->
                <a href="{{ url('login/facebook') }}"
                   class="w-full flex justify-center items-center border rounded-lg py-2 bg-blue-600 text-white shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                         alt="Facebook" class="w-5 h-5 mr-3"> Facebook
                </a>
            </div>
        </div>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{route('register')}}" id="show-signup"
                   class="text-primary hover:text-primary-dark font-medium">Sign up</a>
            </p>
        </div>
    </div>
</div>
</x-guest-layout>
