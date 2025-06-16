<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>500 | Server Error</title>
    @include('custom-layouts.headTagContent')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="text-center p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-6xl font-bold text-red-600">500</h1>
    <h2 class="text-2xl font-semibold mt-4 text-gray-800">Internal Server Error</h2>
    <p class="text-gray-600 mt-2">Sorry, something went wrong on our end.</p>
    <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Go to Homepage</a>
</div>

</body>
</html>
