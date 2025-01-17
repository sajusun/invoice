<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Invozen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .form-container .link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .form-container .link:hover {
            text-decoration: underline;
        }
    </style>
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

        <button type="submit">Login</button>
    </form>
    <a href="{{ route('register') }}" class="link">Don't have an account? Register</a>
</div>
</body>
</html>
