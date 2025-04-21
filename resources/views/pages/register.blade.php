<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Sign Up for Invozen - Create Your Free Account</title>
    <meta name="description" content="Join Invozen today and streamline your invoicing process. Sign up for free and start creating invoices in seconds.">
    <meta name="keywords" content="sign up, invozen register, create account, free invoicing">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.invozen.com/register">
</head>
<body>
@include('custom-layouts.navbar')
<section class="center-div">
<div class="form-container">
    <h2 class="color-main">Create an Account</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" required>
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
    </section>
@include('custom-layouts.footer')
</body>
</html>
