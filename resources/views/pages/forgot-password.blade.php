<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')

    <title>Forgot Password - Invozen</title>

</head>
<body>
<div class="form-container">
    <h2>Forgot Password</h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <p>Enter your registered email to reset your password.</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <button type="submit" class="register">Send Reset Link</button>
    </form>
    <a href="{{ route('login') }}" class="link">Back to Login</a>
</div>
</body>
</html>

