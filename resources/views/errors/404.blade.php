<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
@include('custom-layouts.headTagContent')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="text-center">
    <h1 class="text-7xl font-bold text-red-600">404</h1>
    <p class="text-2xl mt-4">Page Not Found</p>
    <p class="mt-2 text-gray-600">The page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Go Home</a>
</div>
</body>
</html>
