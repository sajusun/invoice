<x-admin-layout>
    <x-slot name="title">Add New Platform Staff / Admin</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[11px] font-bold border border-rose-100 mb-1">
                    <i class="fa-solid fa-user-shield text-[10px]"></i>
                    <span>Identity & Access Provisioning</span>
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Provision Administrator Account</h1>
                <p class="text-xs text-slate-500 mt-0.5">Create a new platform administrator and assign role-based capabilities.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition-all shadow-2xs">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Matrix</span>
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Full Name <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Sarah Connor"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. sarah@invozen.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Initial Password <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        <input type="password" name="password" required minlength="8" placeholder="Minimum 8 characters"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Assigned Platform Role <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="role_id" id="role-selector" required onchange="updateRoleCapabilitiesPreview()"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all cursor-pointer">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                        data-permissions="{{ json_encode($role->permissions->pluck('name')) }}"
                                        data-is-super="{{ $role->name === 'super_admin' ? 'true' : 'false' }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Live Capabilities Preview Box -->
                    <div class="mt-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-sparkles text-amber-500 text-xs"></i>
                            <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Granted Role Capabilities Preview:</span>
                        </div>
                        <div id="role-capabilities-badges" class="flex flex-wrap gap-1.5">
                            <!-- Populated via JS -->
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.roles.index') }}"
                       class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-md shadow-rose-600/30 transition-all cursor-pointer">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span>Create Administrator</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateRoleCapabilitiesPreview() {
            const selector = document.getElementById('role-selector');
            const selectedOption = selector.options[selector.selectedIndex];
            const badgesContainer = document.getElementById('role-capabilities-badges');
            
            badgesContainer.innerHTML = '';

            if (!selectedOption) return;

            const isSuper = selectedOption.getAttribute('data-is-super') === 'true';
            
            if (isSuper) {
                badgesContainer.innerHTML = `
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-rose-100 text-rose-700 border border-rose-200">
                        <i class="fa-solid fa-crown text-[10px]"></i> Unrestricted Super Admin Access (Wildcard *)
                    </span>
                `;
                return;
            }

            try {
                const perms = JSON.parse(selectedOption.getAttribute('data-permissions') || '[]');
                if (perms.length === 0) {
                    badgesContainer.innerHTML = '<span class="text-xs text-slate-400 italic">No capabilities currently assigned to this role tier.</span>';
                    return;
                }

                perms.forEach(p => {
                    const badge = document.createElement('span');
                    badge.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100';
                    badge.innerHTML = `<i class="fa-solid fa-check text-[9px] text-emerald-500"></i> ${p.replace(/_/g, ' ')}`;
                    badgesContainer.appendChild(badge);
                });
            } catch(e) {
                badgesContainer.innerHTML = '<span class="text-xs text-slate-400">Custom capabilities</span>';
            }
        }

        document.addEventListener('DOMContentLoaded', updateRoleCapabilitiesPreview);
    </script>
</x-admin-layout>
