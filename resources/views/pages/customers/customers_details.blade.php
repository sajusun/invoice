<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
@include('custom-layouts.headTagContent')
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Customer Details</h1>

    <!-- Success message placeholder -->
    <div id="successMessage" class="hidden mb-4 p-3 bg-green-100 text-green-800 rounded">
        Customer updated successfully!
    </div>

    <form id="customerForm" class="space-y-4">
        <div>
            <label class="block font-medium mb-1">Name:</label>
            <input type="text" id="name" value="{{$customer->name}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Email:</label>
            <input type="email" id="email" value="{{$customer->email}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Phone:</label>
            <input type="text" id="phone" value="{{$customer->phone}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Address:</label>
            <textarea id="address" rows="3" class="w-full border rounded p-2">{{$customer->address}}</textarea>
        </div>

        <div class="flex space-x-4">
            <button type="button" onclick="saveCustomer()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            <button type="button" onclick="goBack()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Back to List</button>
        </div>
    </form>
</div>

<script>
    function saveCustomer() {
        // Here you'd send the data via fetch/ajax
        console.log("Saving customer...");
        document.getElementById('successMessage').classList.remove('hidden');
    }

    function goBack() {
        window.location.href = '/dashboard/customers'; // example, replace with actual page
    }
</script>

</body>
</html>
