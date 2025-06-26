<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Custom Payment Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">

    <form action="{{ route('admin.dashboard.payments.create') }}" method="Post">
        @csrf
        <input class="mb-4 border rounded px-3 py-2 w-full" type="text" name="user_id" placeholder="User ID" required>

        <select name="plan_id" class="mb-4 border rounded px-3 py-2 w-full">
            @foreach($plans as $plan)
            <option value="{{$plan->id}}">{{$plan->name}}</option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Set Payment</button>
    </form>
</div>

</body>
</html>
