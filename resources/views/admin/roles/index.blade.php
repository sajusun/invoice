<x-admin-layout>
    <div class="pt-2 pl-2">
        <div class="max-w-5xl mx-auto p-6 bg-white  rounded">
            <h1 class="text-2xl font-bold mb-6">Manage Role Permissions</h1>

            @if (session('role'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                    {{ session('role') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <form action="{{ route('admin.roles.update') }}" method="POST">
                    @csrf

                    <table class="table-auto w-full border capitalize text-gray-600">
                        <thead>
                        <tr class="bg-gray-100 text-center capitalize">
                            <th class="p-1 border">Permission</th>
                            @foreach($roles as $role)
                                <th>{{ $role->name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr class="text-center border p-2">
                                <td class="p-1 font-semibold border">{{ $permission->name }}</td>
                                @foreach($roles as $role)
                                    <td class="text-center border">
                                        <input type="checkbox" class="cursor-pointer"
                                               name="permissions[{{ $role->id }}][]"
                                               value="{{ $permission->id }}"
                                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @hasPermission('*')
                    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Save Permissions
                    </button>
                    @endhasPermission

                </form>

            </div>
        </div>

        {{--    --}}
        <div class="max-w-5xl mx-auto p-6 bg-white shadow rounded">

            <h1 class="text-2xl font-bold mb-4">Admin Users Management</h1>

            <!-- Success Message -->
            @if(session('admin'))
                <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                    {{ session('admin') }}
                </div>
            @endif

            <!-- Admin Users Table -->
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-lg">
                    <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Role</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($adminUsers as $index => $user)
                        <tr>
                            <td class="p-3 border">{{ $index + 1 }}</td>
                            <td class="p-3 border">{{ $user->name }}</td>
                            <td class="p-3 border">{{ $user->email }}</td>
                            <td class="p-3 border">
                                <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role_id" onchange="this.form.submit()"
                                            class="border-0 cursor-pointer p-1 w-full">
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="p-3 border space-x-2 text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                      class="inline-block" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @hasPermission('*')
            <!-- Create New Admin Button -->
            <div class="mt-6">
                <a href="{{ route('admin.users.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add New Admin</a>
            </div>
            @endhasPermission('*')



        </div>
    </div>
</x-admin-layout>
