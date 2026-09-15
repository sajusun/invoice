<x-admin-layout>
    <x-slot name="title">Roles & Access Permissions Matrix</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <!-- 1. Header & Summary Banner -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Access Control & Role Permissions</h1>
                <p class="text-xs text-slate-500 mt-1">Configure role capabilities, granular feature permissions, and administrator access levels.</p>
            </div>
            <div class="flex items-center gap-3">
                @hasPermission('*')
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-rose-600/20 hover:shadow-md transition-all">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Add New Admin User</span>
                </a>
                @endhasPermission
            </div>
        </div>

        <!-- 2. Flash Messages -->
        @if (session('role'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('role') }}</span>
            </div>
        @endif
        @if(session('admin'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('admin') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- 3. Permission Matrix Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-rose-600"></i>
                        <span>Granular Role Permission Matrix</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Toggle permission checkboxes for specific roles to grant or restrict capabilities.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                    {{ count($roles) }} Roles • {{ count($permissions) }} Permissions
                </span>
            </div>

            <form action="{{ route('admin.roles.update') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-6">Permission / Capability</th>
                                @foreach($roles as $role)
                                    <th class="py-3.5 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $role->name === 'super_admin' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-700' }}">
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            @foreach($permissions as $permission)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-6 font-semibold text-slate-900 flex items-center gap-2.5">
                                        <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                        <span>{{ ucwords(str_replace(['.', '_', '-'], ' ', $permission->name)) }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">({{ $permission->name }})</span>
                                    </td>
                                    @foreach($roles as $role)
                                        <td class="py-3.5 px-6 text-center">
                                            @if($role->name === 'super_admin')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 text-xs" title="Super Admin has all permissions">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            @else
                                                <input type="checkbox"
                                                       name="permissions[{{ $role->id }}][]"
                                                       value="{{ $permission->id }}"
                                                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-rose-600 bg-white border-slate-300 rounded focus:ring-rose-500 focus:ring-2 cursor-pointer transition-all">
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @hasPermission('*')
                <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs text-slate-500">Changes will take effect immediately for all active administrative sessions.</p>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer">
                        <i class="fa-solid fa-floppy-disk text-rose-400"></i> Save Matrix Permissions
                    </button>
                </div>
                @endhasPermission
            </form>
        </div>

        <!-- 4. Admin Users Management Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-users-gear text-rose-600"></i>
                        <span>Platform Administrator Directory</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Manage administrative accounts, assign role tiers, or revoke privileges.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    {{ count($adminUsers) }} Total Admins
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-6">#</th>
                            <th class="py-3.5 px-6">Administrator</th>
                            <th class="py-3.5 px-6">Email Address</th>
                            <th class="py-3.5 px-6">Assigned Role</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach($adminUsers as $index => $user)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-6 font-mono text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-rose-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden">
                                            @if($user->profile_pic)
                                                <img src="{{ asset('storage/profile_pics/' . $user->profile_pic) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                            <p class="text-[10px] text-slate-400">ID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6 font-medium text-slate-600">
                                    {{ $user->email }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                                        @csrf
                                        <select name="role_id" onchange="this.form.submit()"
                                                class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 cursor-pointer">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                           title="Edit Admin">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        @if($user->id !== Auth::guard('admin')->id())
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                  class="inline-block" onsubmit="return confirm('Are you sure you want to permanently remove this admin user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                                        title="Delete Admin">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
