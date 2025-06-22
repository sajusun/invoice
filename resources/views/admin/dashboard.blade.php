@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white p-5">
        <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
        <nav class="space-y-4">
            <a href="#" class="block hover:text-yellow-400">Dashboard</a>
            <a href="#" class="block hover:text-yellow-400">Users</a>
            <a href="#" class="block hover:text-yellow-400">Orders</a>
            <a href="#" class="block hover:text-yellow-400">Settings</a>
            <form id="logoutForm" method="POST" action="{{route('admin.logout')}}">
                @csrf
                <button type="submit"
                   class="text-red-500 hover:text-red-700 font-medium">Logout</button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">{{Auth::guard('admin')->user()->name}}</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow flex items-center">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Users</p>
                    <h3 class="text-xl font-bold">{{$totalUsers}}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center">
                <div class="p-3 bg-green-100 text-green-600 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M3 10h18M9 21h6M12 3v3"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Verified</p>
                    <h3 class="text-xl font-bold">{{$verifiedUsers}}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center">
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Unverified</p>
                    <h3 class="text-xl font-bold">{{$unverifiedUsers}}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center">
                <div class="p-3 bg-red-100 text-red-600 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">New User</p>
                    <h3 class="text-xl font-bold">{{$usersThisWeek}}</h3>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Recent Users </h3>
            <div class="overflow-x-auto h-min">
                <table class="min-w-full table-auto">
                    <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-2">User ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                    @foreach($userListThisWeek as $list)

                        <tr class="border-b cursor-pointer hover:bg-gray-200">
                            <td class="px-4 py-2">#{{$list->id}}</td>
                            <td class="px-4 py-2">{{$list->name}}</td>
                            <td class="px-4 py-2">{{$list->email}}</td>
                            <td class="px-4 py-2">{{$list->created_at}}</td>
                            <td class="px-4 py-2">
                                @if($list->email_verified_at)
                                    <span class="text-green-600 font-medium ">Verified</span>
                                @else
                                <span class="text-gray-600 font-medium">Unverified</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

</body>
</html>
