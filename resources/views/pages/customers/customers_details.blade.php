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
 @if(session('response')==='success')
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
           {{session('message')}}
        </div>
 @endif
    @if(session('response')==='error')
        <div class="mb-4 p-3 bg-transparent text-red-400 rounded">
            {{session('message')}}
        </div>
    @endif
    <form id="customerForm" class="space-y-4" method="post" action="{{route('customers.update',$customer->id)}}">
        @csrf
        <div>
            <label class="block font-medium mb-1">Name:</label>
            <input type="text" name="name" value="{{$customer->name}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Email:</label>
            <input type="email" name="email" value="{{$customer->email}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Phone:</label>
            <input type="text" name="phone" value="{{$customer->phone}}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Address:</label>
            <textarea name="address" rows="3" class="w-full border rounded p-2">{{$customer->address}}</textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" onclick="saveCustomer()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
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
