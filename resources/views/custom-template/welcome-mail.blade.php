<!DOCTYPE html>
<html>
<head>
    <title>Welcome, {{ $name }}!</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; text-align: center; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, {{ $name }}!</h2>
    <p>Thank you for registering. Your email: <strong>{{ $email }}</strong></p>
    <p>We are happy to have you on board.</p>
    <a href="{{ url('/') }}" class="btn">Visit Our Website</a>
</div>
</body>
</html>
