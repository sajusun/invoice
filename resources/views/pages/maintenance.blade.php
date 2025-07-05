<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Under Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<div class="text-center bg-white p-8 rounded-lg shadow-lg">
    <svg class="mx-auto mb-6 w-20 h-20 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>

    <h1 class="text-3xl font-bold text-gray-800 mb-4">This Page is Under Maintenance</h1>
    <p class="text-gray-600 mb-6">We're updating this page. It'll be available soon. Thanks for your patience!</p>

    <a href="{{ url('/') }}" class="text-blue-500 hover:underline">← Back to Home</a>
</div>

</body>
</html>
