
<x-admin-layout>

        <div class="p-4">
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
                <form method="post" action="{{ route('users.bulk-delete') }}" id="bulkDeleteForm">
                    @csrf
                    <input type="hidden" name="ids" id="bulkDeleteIds">

                    <button type="submit" class="text-red-600 py-2 px-2 rounded hover:text-red-700 text-sm">Delete Selected
                    </button>
                </form>

            </div>
            <div class="overflow-x-auto h-min">
                <table class="min-w-full table-auto">
                    <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">

                        <th class="px-4 py-2 w-0">
                            <input type="checkbox" name="selectAll" id="selectAll" class="mr-0">
                        </th>
                        <th class="px-4 py-2">User ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2 text-center">Date</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Action</th>

                    </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                    @foreach($users as $user)
                        <tr class="border-b cursor-pointer hover:bg-gray-200">
                            <td class="px-4 py-2">
                                <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox mr-2">
                            </td>
                            <td class="px-4 py-2">#{{$user->id}}</td>
                            <td class="px-4 py-2">{{$user->name}}</td>
                            <td class="px-4 py-2">{{$user->email}}</td>
                            <td class="px-4 py-2 text-center">{{$user->created_at}}</td>
                            <td class="px-4 py-2 text-center">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 font-medium ">Verified</span>
                                @else
                                    <span class="text-gray-600 font-medium">Unverified</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center w-8">
                                <a class="w-32 px-6 py-2 text-blue-500 hover:text-gray-600" href="{{route('admin.dashboard.user.page',$user->id)}}">View</a>
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

{{--</body>--}}
<script>
    document.getElementById('selectAll').onclick = function() {
        let checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    };

    document.getElementById('bulkDeleteForm').onsubmit = function(e) {
        e.preventDefault();
        let selectedIds = Array.from(document.querySelectorAll('.user-checkbox:checked'))
            .map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('No users selected!');
            return;
        }
        document.getElementById('bulkDeleteIds').value = JSON.stringify(selectedIds);
        this.submit();
    };

</script>
</x-admin-layout>
{{--</html>--}}
