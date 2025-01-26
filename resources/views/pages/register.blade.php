<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Register - Invozen</title>
</head>
<body>
<div class="form-container">
    <h2>Create an Account</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="Name" placeholder="Name" required>
        <x-input-error :messages="$errors->get('name')" class="error-mgs"/>
        <input type="email" name="email" placeholder="Email" required>
        <x-input-error :messages="$errors->get('email')" class="error-mgs"/>
        <input type="password" name="password" placeholder="Password" required>
        <x-input-error :messages="$errors->get('password')" class="error-mgs"/>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <x-input-error :messages="$errors->get('password_confirmation')" class="error-mgs"/>
        <button type="submit" class="register">Register</button>
    </form>
    <a href="{{ route('login') }}" class="link">Already have an account? Login</a>
</div>
</body>
</html>
