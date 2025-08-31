<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Login to Invozen - Secure Access</title>
    <meta name="description"
          content="Log in to your Invozen account to manage your invoices, clients, and payments securely.">
    <meta name="keywords" content="login, invozen, account login, invoice software login">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{config('app.url')}}/login">
</head>
<body class="w-screen h-screen">
{{--@include('custom-layouts.navbar')--}}
<div class="h-full bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-2xl font-bold text-gray-900 text-center border-b pb-4">Sign In</div>
        @if ($errors->any())
            <div class="text-red-400 text-sm align-baseline">
                @foreach ($errors->all() as $error)
                    <span style="font-size: .8rem">{{ $error }}</span>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2
                    focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                    placeholder="Example@email.com" required
                />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                <input
                    type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2
                     focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                    placeholder="At least 8 characters" required
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
                class="w-full bg-color-main hover:bg-indigo-700 text-white
                 font-medium py-2.5 rounded-lg transition-colors"
                type="submit">
                Sign In
            </button>
        </form>
        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-3 text-gray-400 text-sm">Or</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>
        <!-- Social Login Section -->
        <div class="mt-6 space-y-4">
            <div class="flex justify-center items-center space-x-4">
                <!-- Google Login -->
                <a href="{{ url('login/google') }}" class="w-full flex justify-center items-center border rounded-lg py-2 bg-white text-gray-700 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/archive/c/c1/20221203181232%21Google_%22G%22_logo.svg"
                         alt="Google"
                         class="w-5 h-5 mr-3"> Google
                </a>
            </div>

            <div class="flex justify-center items-center space-x-4">
                <!-- Facebook Login -->
                <a href="{{ url('login/facebook') }}" class="w-full flex justify-center items-center border rounded-lg py-2 bg-blue-600 text-white shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="w-5 h-5 mr-3"> Facebook
                </a>
            </div>
        </div>
        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{route('register')}}" class="color-main hover:text-indigo-500 font-medium">Sign up</a>
        </div>
    </div>
</div>

{{--@include('custom-layouts.footer')--}}
</body>
</html>
