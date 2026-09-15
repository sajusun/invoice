<!-- Admin Sidebar Component -->
<aside class="w-64 lg:w-72 bg-[#0B1120] border-r border-slate-800 text-slate-300 flex flex-col shrink-0 h-screen sticky top-0 z-20">
    <!-- Admin Brand Header -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800/80 bg-[#0F172A]">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-rose-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-rose-500/20 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-shield-halved text-lg"></i>
            </div>
            <div>
                <span class="text-lg font-black tracking-tight text-white group-hover:text-rose-400 transition-colors">Invozen</span>
                <span class="block text-[9px] uppercase font-extrabold tracking-widest text-rose-400">SuperAdmin</span>
            </div>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-6 scrollbar-thin">
        <!-- Overview -->
        <div>
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Platform Overview</p>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/90 text-white border-l-4 border-rose-500 pl-2.5 shadow-xs' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                    <span>Admin Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Management -->
        <div>
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">User & Billing Control</p>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard.users-list') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard.users-list*') ? 'bg-slate-800/90 text-white border-l-4 border-rose-500 pl-2.5 shadow-xs' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center text-base {{ request()->routeIs('admin.dashboard.users-list*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                    <span>Users Management</span>
                </a>
                <a href="{{ route('admin.dashboard.payments') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard.payments*') ? 'bg-slate-800/90 text-white border-l-4 border-rose-500 pl-2.5 shadow-xs' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-receipt w-5 text-center text-base {{ request()->routeIs('admin.dashboard.payments*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                    <span>Payment Audit Ledger</span>
                </a>
            </div>
        </div>

        <!-- Administration -->
        <div>
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Staff & Security</p>
            <div class="space-y-1">
                <a href="{{ route('admin.roles.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.roles.*') ? 'bg-slate-800/90 text-white border-l-4 border-rose-500 pl-2.5 shadow-xs' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-user-shield w-5 text-center text-base {{ request()->routeIs('admin.roles.*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                    <span>Staff & Roles</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.profile.*') ? 'bg-slate-800/90 text-white border-l-4 border-rose-500 pl-2.5 shadow-xs' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-sliders w-5 text-center text-base {{ request()->routeIs('admin.profile.*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                    <span>Admin Profile</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Admin Status Widget -->
    <div class="p-4 border-t border-slate-800 bg-[#0F172A]">
        <div class="p-3 bg-slate-800/80 rounded-2xl border border-slate-700/80 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400 shrink-0 font-bold text-xs">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</p>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                        Admin Guard
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" title="Admin Logout"
                        class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition-colors cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

