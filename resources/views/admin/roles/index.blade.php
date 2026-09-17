<x-admin-layout>
    <x-slot name="title">Roles & Access Permissions Matrix</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <!-- 1. Header & Summary Banner -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-6 sm:p-8 rounded-3xl text-white shadow-xl shadow-slate-900/10 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-xs font-bold border border-rose-500/30">
                    <i class="fa-solid fa-shield-halved text-[11px]"></i>
                    <span>RBAC Access Control Engine</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">Role & Permission Control</h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl">
                    Create custom role tiers, fine-tune granular access capabilities across modules, and provision platform staff accounts with precision.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 relative z-10">
                @hasPermission('*')
                <button type="button" onclick="openCreateRoleModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 backdrop-blur-xs transition-all shadow-sm cursor-pointer">
                    <i class="fa-solid fa-key text-rose-400"></i>
                    <span>Create New Role</span>
                </button>

                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-rose-600/30 hover:shadow-rose-600/50 transition-all cursor-pointer">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Add Staff / Admin</span>
                </a>
                @endhasPermission
            </div>
        </div>

        <!-- 2. Flash Messages & Alerts -->
        @if (session('role'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-check text-base"></i>
                    </div>
                    <span>{{ session('role') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        @if(session('admin'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-check text-base"></i>
                    </div>
                    <span>{{ session('admin') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-base"></i>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- 3. Metrics Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">System Roles</p>
                    <p class="text-2xl font-black text-slate-900">{{ count($roles) }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Total Permissions</p>
                    <p class="text-2xl font-black text-slate-900">{{ count($permissions) }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Staff & Admins</p>
                    <p class="text-2xl font-black text-slate-900">{{ count($adminUsers) }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500">Root Policy Guard</p>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wide">Super Admin Bypass</p>
                </div>
            </div>
        </div>

        <!-- 4. Granular Permission Matrix Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-pulse"></span>
                        <h2 class="text-base font-bold text-slate-900">Granular Role Permission Matrix</h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Control individual capabilities per role. Check or uncheck matrix cells, then click <strong>Save Matrix Permissions</strong>.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200 text-slate-600 shadow-2xs">
                        {{ count($roles) }} Roles Active
                    </span>
                    @hasPermission('*')
                    <button type="button" onclick="openCreateRoleModal()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-bold transition-colors cursor-pointer">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>New Role</span>
                    </button>
                    @endhasPermission
                </div>
            </div>

            <form action="{{ route('admin.roles.update') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                                <th class="py-4 px-6 min-w-[260px]">Capability / Permission Name</th>
                                @foreach($roles as $role)
                                    <th class="py-4 px-6 text-center min-w-[170px]">
                                        <div class="flex flex-col items-center gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $role->name === 'super_admin' ? 'bg-rose-600 text-white shadow-xs shadow-rose-600/30' : ($role->name === 'admin' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-slate-200/80 text-slate-800') }}">
                                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                </span>
                                                
                                                @if($role->name !== 'super_admin')
                                                    @hasPermission('*')
                                                    <div class="flex items-center gap-1">
                                                        <button type="button"
                                                                onclick="openEditRoleModal({{ $role->id }}, '{{ addslashes($role->name) }}', {{ json_encode($role->permissions->pluck('id')) }})"
                                                                class="p-1 text-slate-400 hover:text-indigo-600 rounded transition-colors"
                                                                title="Edit Role">
                                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                        </button>
                                                        <button type="button"
                                                                onclick="deleteRolePrompt({{ $role->id }}, '{{ addslashes($role->name) }}', {{ $role->admins_count ?? $role->admins->count() }})"
                                                                class="p-1 text-slate-400 hover:text-rose-600 rounded transition-colors"
                                                                title="Delete Role">
                                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                                        </button>
                                                    </div>
                                                    @endhasPermission
                                                @endif
                                            </div>
                                            <span class="text-[10px] font-semibold text-slate-400 font-mono">
                                                {{ $role->admins_count ?? $role->admins->count() }} User{{ ($role->admins_count ?? $role->admins->count()) === 1 ? '' : 's' }}
                                            </span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            @foreach($permissions as $permission)
                                @php
                                    $isWildcard = $permission->name === '*';
                                    $isManage = str_starts_with($permission->name, 'manage_');
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors {{ $isWildcard ? 'bg-rose-50/30 font-bold' : '' }}">
                                    <td class="py-3.5 px-6 font-semibold text-slate-900">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-2 h-2 rounded-full {{ $isWildcard ? 'bg-rose-600 ring-4 ring-rose-200' : ($isManage ? 'bg-indigo-500' : 'bg-slate-400') }}"></div>
                                            <div>
                                                <p class="font-bold {{ $isWildcard ? 'text-rose-700 font-extrabold' : 'text-slate-800' }}">
                                                    {{ $isWildcard ? '⭐ Super Administrator Wildcard (All Permissions)' : ucwords(str_replace(['.', '_', '-'], ' ', $permission->name)) }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 font-mono">{{ $permission->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($roles as $role)
                                        <td class="py-3.5 px-6 text-center">
                                            @if($role->name === 'super_admin')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 text-xs" title="Super Admin automatically inherits all privileges">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                            @else
                                                <label class="inline-flex items-center justify-center cursor-pointer p-1">
                                                    <input type="checkbox"
                                                           name="permissions[{{ $role->id }}][]"
                                                           value="{{ $permission->id }}"
                                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                                           class="w-4 h-4 text-rose-600 bg-white border-slate-300 rounded focus:ring-rose-500 focus:ring-2 cursor-pointer transition-all">
                                                </label>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @hasPermission('*')
                <div class="p-6 bg-slate-50/60 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <i class="fa-solid fa-circle-info text-rose-500"></i>
                        <span>Changes apply immediately across active administrator sessions without required logout.</span>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-md shadow-slate-900/10 hover:shadow-lg transition-all cursor-pointer">
                        <i class="fa-solid fa-floppy-disk text-rose-400"></i>
                        <span>Save Matrix Permissions</span>
                    </button>
                </div>
                @endhasPermission
            </form>
        </div>

        <!-- 5. Platform Staff & Administrators Directory -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                        <h2 class="text-base font-bold text-slate-900">Platform Staff & Administrators Directory</h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Manage administrative accounts, assign role tiers, or update credentials.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                        {{ count($adminUsers) }} Administrators
                    </span>
                    @hasPermission('*')
                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer">
                        <i class="fa-solid fa-user-plus text-[10px]"></i>
                        <span>Add Staff</span>
                    </a>
                    @endhasPermission
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-6">#</th>
                            <th class="py-3.5 px-6">Staff Member</th>
                            <th class="py-3.5 px-6">Email Address</th>
                            <th class="py-3.5 px-6">Role Assignment</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach($adminUsers as $index => $user)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6 font-mono text-slate-400 font-semibold">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-rose-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs overflow-hidden">
                                            @if($user->profile_pic)
                                                <img src="{{ asset('storage/profile_pics/' . $user->profile_pic) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 flex items-center gap-1.5">
                                                <span>{{ $user->name }}</span>
                                                @if($user->id === Auth::guard('admin')->id())
                                                    <span class="px-1.5 py-0.5 rounded-md text-[9px] font-extrabold bg-emerald-100 text-emerald-700">You</span>
                                                @endif
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-mono">UID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-600">
                                    <span class="inline-flex items-center gap-1.5 text-slate-700">
                                        <i class="fa-regular fa-envelope text-slate-400 text-[11px]"></i>
                                        <span>{{ $user->email }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @hasPermission('*')
                                        <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="relative inline-block">
                                                <select name="role_id" onchange="this.form.submit()"
                                                        {{ $user->id === Auth::guard('admin')->id() ? 'disabled' : '' }}
                                                        class="appearance-none pl-3 pr-8 py-1.5 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-xs font-semibold text-slate-800 shadow-2xs focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 cursor-pointer disabled:bg-slate-100 disabled:cursor-not-allowed">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                            {{ ucwords(str_replace('_', ' ', $user->role?->name ?? 'No Role')) }}
                                        </span>
                                    @endhasPermission
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @hasPermission('*')
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors"
                                           title="Edit Staff Credentials">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        @if($user->id !== Auth::guard('admin')->id() && ($user->role?->name !== 'super_admin'))
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                  class="inline-block" onsubmit="return confirm('Are you sure you want to permanently revoke this administrator account?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer"
                                                        title="Delete Staff Account">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endhasPermission
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal 1: Create Role Modal -->
    <div id="create-role-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden transition-opacity">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-shield-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Create New System Role</h3>
                        <p class="text-xs text-slate-500">Define a custom role name and assign its initial capabilities.</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateRoleModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('admin.roles.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <!-- Role Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Role Name / Identifier <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" required placeholder="e.g. billing_manager, auditor, support_lead"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">Special characters will be normalized into lowercase snake_case automatically.</p>
                    </div>

                    <!-- Permissions Assignment -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Assign Initial Capabilities
                            </label>
                            <button type="button" onclick="toggleAllCheckboxes('create-role-permissions', true)"
                                    class="text-[11px] font-bold text-rose-600 hover:text-rose-700">
                                Select All
                            </button>
                        </div>

                        <div id="create-role-permissions" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 p-3 bg-slate-50 rounded-2xl border border-slate-100 max-h-64 overflow-y-auto">
                            @foreach($permissions as $perm)
                                @if($perm->name !== '*')
                                <label class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200 hover:border-rose-300 transition-all cursor-pointer select-none">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                           class="w-4 h-4 text-rose-600 bg-white border-slate-300 rounded focus:ring-rose-500 focus:ring-2 cursor-pointer">
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ ucwords(str_replace(['.', '_', '-'], ' ', $perm->name)) }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono">{{ $perm->name }}</p>
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-5 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeCreateRoleModal()"
                            class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-md shadow-rose-600/20 transition-all cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Create Role</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Role Modal -->
    <div id="edit-role-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden transition-opacity">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-pen-ruler"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Edit System Role</h3>
                        <p class="text-xs text-slate-500">Update role name identifier and assign/unassign permissions.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditRoleModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="edit-role-form" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <!-- Role Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Role Name / Identifier <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="edit-role-name" name="name" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>

                    <!-- Permissions Assignment -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Role Capabilities
                            </label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="toggleAllCheckboxes('edit-role-permissions', true)"
                                        class="text-[11px] font-bold text-indigo-600 hover:text-indigo-700">
                                    Select All
                                </button>
                                <span class="text-slate-300">•</span>
                                <button type="button" onclick="toggleAllCheckboxes('edit-role-permissions', false)"
                                        class="text-[11px] font-bold text-slate-500 hover:text-slate-700">
                                    Deselect All
                                </button>
                            </div>
                        </div>

                        <div id="edit-role-permissions" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 p-3 bg-slate-50 rounded-2xl border border-slate-100 max-h-64 overflow-y-auto">
                            @foreach($permissions as $perm)
                                @if($perm->name !== '*')
                                <label class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200 hover:border-indigo-300 transition-all cursor-pointer select-none">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="edit_perm_{{ $perm->id }}"
                                           class="w-4 h-4 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer edit-perm-checkbox">
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ ucwords(str_replace(['.', '_', '-'], ' ', $perm->name)) }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono">{{ $perm->name }}</p>
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-5 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditRoleModal()"
                            class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-600/20 transition-all cursor-pointer">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Save Role Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Form for Role Deletion -->
    <form id="delete-role-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- JavaScript Interactions for Modals -->
    <script>
        function openCreateRoleModal() {
            document.getElementById('create-role-modal').classList.remove('hidden');
        }

        function closeCreateRoleModal() {
            document.getElementById('create-role-modal').classList.add('hidden');
        }

        function openEditRoleModal(roleId, roleName, permissionIds) {
            const form = document.getElementById('edit-role-form');
            form.action = "{{ url('admin/dashboard/roles') }}/" + roleId;
            document.getElementById('edit-role-name').value = roleName;

            // Uncheck all first
            document.querySelectorAll('.edit-perm-checkbox').forEach(cb => {
                cb.checked = false;
            });

            // Check matching permissions
            if (Array.isArray(permissionIds)) {
                permissionIds.forEach(id => {
                    const cb = document.getElementById('edit_perm_' + id);
                    if (cb) cb.checked = true;
                });
            }

            document.getElementById('edit-role-modal').classList.remove('hidden');
        }

        function closeEditRoleModal() {
            document.getElementById('edit-role-modal').classList.add('hidden');
        }

        function toggleAllCheckboxes(containerId, check) {
            const container = document.getElementById(containerId);
            if (!container) return;
            container.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.checked = check;
            });
        }

        function deleteRolePrompt(roleId, roleName, adminCount) {
            if (adminCount > 0) {
                alert(`Cannot delete role '${roleName}' because it is assigned to ${adminCount} administrator(s). Please reassign them first.`);
                return;
            }

            if (confirm(`Are you sure you want to permanently delete the custom role '${roleName}'?`)) {
                const form = document.getElementById('delete-role-form');
                form.action = "{{ url('admin/dashboard/roles') }}/" + roleId;
                form.submit();
            }
        }
    </script>
</x-admin-layout>
