<x-admin-layout>

    <div class="bg-gray-50 p-6 overflow-y-auto">
        <div class="flex-1 p-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <a href="{{route('admin.dashboard.users-list')}}">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Users</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{$totalUsers}}</h3>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 12% from last
                            month
                        </p>
                    </div>
                </a>

                <a href="{{route('admin.dashboard.users-list','status=verified&sort_by=created_at&order=asc')}}">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                                <i class="fa-solid fa-user-secret text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Verified</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{$verifiedUsers}}</h3>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 12% from last
                            month
                        </p>
                    </div>
                </a>

                <a href="{{route('admin.dashboard.users-list','status=unverified&sort_by=created_at&order=asc')}}">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Unverified</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{$unverifiedUsers}}</h3>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 12% from last
                            month
                        </p>
                    </div>
                </a>

                <a href="{{route('admin.dashboard.users-list','status=new&sort_by=created_at&order=asc')}}">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                                <i class="fa-solid fa-user-plus text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">New User</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{$usersThisWeek}}</h3>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 12% from last
                            month
                        </p>
                    </div>
                </a>
            </div>
            <!-- User Table -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div>
                    <form method="GET" action="{{route('admin.dashboard')}}" class="mb-4 flex flex-wrap gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by ID, Name, Email"
                               class="border rounded px-3 py-0 w-64 text-sm"/>

                        <select name="status" class="border rounded px-3 py-2">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified
                            </option>
                            <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>
                                Unverified
                            </option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Today</option>
                        </select>

                        <select name="sort_by" class="border rounded px-3 py-2">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                Registered
                                Date
                            </option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>

                        <select name="order" class="border rounded px-3 py-2">
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Asc</option>
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Desc</option>
                        </select>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Apply
                        </button>
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
        </div>
    </div>
</x-admin-layout>
