<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Login - Invozen</title>

</head>
<body class="center-div">
<div class="form-container">
    <h2>Login to Invozen</h2>
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <span style="font-size: .8rem">{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="text" name="email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login">Login</button>
    </form>
    <a href="{{ route('password.request') }}" class="link">Forgot Your Password?</a>
</div>
</body>
</html>
