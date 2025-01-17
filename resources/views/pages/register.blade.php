<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Invozen</title>
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
        .form-container input[type="email"],
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
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
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
    <h2>Create an Account</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="Name" placeholder="Name" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

        <input type="email" name="email" placeholder="Email" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <input type="password" name="password" placeholder="Password" required>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <button type="submit">Register</button>
    </form>
    <a href="{{ route('login') }}" class="link">Already have an account? Login</a>
</div>
</body>
</html>
