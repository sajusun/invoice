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
    <aside class="w-64 bg-gray-800 text-white p-5">
        <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
        <nav class="space-y-4">
            <a href="#" class="block hover:text-yellow-400">Dashboard</a>
            <a href="{{route('admin.dashboard.users-list')}}" class="block hover:text-yellow-400">Users</a>
            <a href="{{route('admin.dashboard.payments')}}" class="block hover:text-yellow-400">Payments</a>
            <a href="#" class="block hover:text-yellow-400">Settings</a>
            <form id="logoutForm" method="POST" action="{{route('admin.logout')}}">
                @csrf
                <button type="submit"
                        class="text-red-500 hover:text-red-700 font-medium">Logout
                </button>
            </form>
        </nav>
    </aside>
    <main class="flex-1 p-2">
        <div class="mb-2">
{{--            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>--}}
            <p class="text-gray-500 mt-1">{{Auth::guard('admin')->user()->name}}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">

            <a href="{{route('admin.dashboard.users-list')}}">
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
            </a>

            <a href="{{route('admin.dashboard.users-list','status=verified&sort_by=created_at&order=asc')}}">
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
            </a>

            <a href="{{route('admin.dashboard.users-list','status=unverified&sort_by=created_at&order=asc')}}">
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
            </a>

            <a href="{{route('admin.dashboard.users-list','status=new&sort_by=created_at&order=asc')}}">
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
            </a>
        </div>
        <!-- User Table -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div>
                <form method="GET" action="{{route('admin.dashboard')}}" class="mb-4 flex flex-wrap gap-2">

                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by ID, Name, or Email"
                           class="border rounded px-3 py-2 w-96"/>

                    <select name="status" class="border rounded px-3 py-2">
                        <option value="">All Status</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified
                        </option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Today</option>
                    </select>

                    <select name="sort_by" class="border rounded px-3 py-2">
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Registered
                            Date
                        </option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>

                    <select name="order" class="border rounded px-3 py-2">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Asc</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Desc</option>
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Apply</button>

                </form>

            </div>
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
                    @foreach($usersList as $list)

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
                <div class="mt-4">
                    {{ $usersList->links() }}
                </div>
            </div>
        </div>

    </main>

</div>

</body>
</html>
