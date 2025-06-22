
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Successful — Verify Your Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center">
    <div class="mb-6">
        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12l2 2 4-4m1-4h-8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V8l-4-4z"/>
        </svg>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-4">Signup Successful!</h1>
    <p class="text-gray-600 mb-6">Thank you for registering.
        We've sent a verification link to your email address. <b class="text-gray-500">{{$email}}</b>
        Please check your inbox and confirm your email to activate your account.</p>

    <a href="/" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Go to Home</a>
</div>

</body>
</html>
