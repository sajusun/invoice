 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- Main Content -->

    <main class="flex-1 p-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <div>
                <form method="GET" action="{{route('admin.dashboard.users-list')}}"
                      class="mb-4 flex flex-row gap-2">

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

                    <div class="w-auto flex-auto">
                       <div class=" justify-items-end float-right h-8">
                           <label for="paginate">Per/Page :</label>
                           <select id="paginate" name="paginate" class="border rounded px-3 py-2 ">
                               <option value="25" {{ request('paginate') == '25' ? 'selected' : '' }}>25</option>
                               <option value="50" {{ request('paginate') == '50' ? 'selected' : '' }}>50</option>
                               <option value="100" {{ request('paginate') == '100' ? 'selected' : '' }}>100</option>
                               <option value="250" {{ request('paginate') == '250' ? 'selected' : '' }}>250</option>
                           </select>
                       </div>
                    </div>

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
                    @foreach($users as $user)

                        <tr class="border-b cursor-pointer hover:bg-gray-200">
                            <td class="px-4 py-2">#{{$user->id}}</td>
                            <td class="px-4 py-2">{{$user->name}}</td>
                            <td class="px-4 py-2">{{$user->email}}</td>
                            <td class="px-4 py-2">{{$user->created_at}}</td>
                            <td class="px-4 py-2">
                                @if($user->email_verified_at)
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
                    {{ $users->links() }}
                </div>

            </div>
        </div>

    </main>

</div>

</body>
</html>
