<x-admin-layout>
    <div class="p-6 shadow">
        <div class="overflow-y-auto">
            <h1 class="text-2xl max-w-2xl mx-auto font-bold mb-4 px-4 text-center border-b text-dark-light ">Edit Admin User</h1>
            <!-- Validation Errors -->
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Role</label>
                    <select name="role_id" class="w-full border rounded p-2" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @hasPermission('*')
                <button type="submit" class="text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('admin.roles.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
                @endhasPermission
            </form>
        </div>
    </div>

</x-admin-layout>
