<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Login - Invozen</title>

</head>
<body>
<div class="form-container">
    <h2>Login to Invozen</h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="text" name="email" placeholder="Username or Email" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <input type="password" name="password" placeholder="Password" required>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <button type="submit" class="login">Login</button>
    </form>
{{--    <a href="{{ route('register') }}" class="link">Don't have an account? Register</a>--}}
{{--    <br>--}}
    <a href="{{ route('password.request') }}" class="link">Forgot Your Password?</a>
</div>
</body>
</html>
