<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Reset Password - Invozen</title>
</head>
<body>
<div class="form-container">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="email" readonly name="email" value="{{old('email', $request->email)}}" required autofocus
               autocomplete="username">
        <x-input-error :messages="$errors->get('email')" class="error-mgs"/>
        <input type="password" name="password" placeholder="New Password" required>
        <x-input-error :messages="$errors->get('password')" class="error-mgs"/>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <x-input-error :messages="$errors->get('password_confirmation')" class="error-mgs"/>
        <button type="submit" class="login">Reset Password</button>
    </form>
</div>
</body>
</html>

