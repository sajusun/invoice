<!-- Sidebar Component -->
<aside class="w-64 lg:w-72 bg-white border-r border-slate-200/80 flex flex-col shrink-0 h-screen sticky top-0 z-20">
    <!-- Brand Header -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-file-invoice text-lg"></i>
            </div>
            <div>
                <span class="text-lg font-black tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors">Invozen</span>
                <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">SaaS Platform</span>
            </div>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-6 scrollbar-thin">
        <!-- Main Section -->
        <div>
            <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Main Menu</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-base {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('invoices') }}"
                   class="sidebar-link {{ request()->routeIs('invoices*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base {{ request()->routeIs('invoices*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Invoices</span>
                </a>
                <a href="{{ route('customers') }}"
                   class="sidebar-link {{ request()->routeIs('customers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5 text-center text-base {{ request()->routeIs('customers*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Clients</span>
                </a>

                <a href="{{ route('invoice.builder') }}"
                   class="sidebar-link {{ request()->routeIs('invoice.builder*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles w-5 text-center text-base {{ request()->routeIs('invoice.builder*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Invoice Builder</span>
                </a>
            </div>
        </div>

        <!-- Financial Section -->
        <div>
            <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Financial</p>
            <div class="space-y-1">
                <a href="{{ route('subscription.plan') }}"
                   class="sidebar-link {{ request()->routeIs('subscription.plan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gem w-5 text-center text-base {{ request()->routeIs('subscription.plan*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Plans & Billing</span>
                </a>
                <a href="{{ route('reports.index') }}"
                   class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center text-base {{ request()->routeIs('reports.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Financial Reports</span>
                </a>
            </div>
        </div>

        <!-- Developer & Integration -->
        <div>
            <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Developer & API</p>
            <div class="space-y-1">
                <a href="{{ route('developer.api-keys') }}"
                   class="sidebar-link {{ request()->routeIs('developer.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-key w-5 text-center text-base {{ request()->routeIs('developer.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>API Keys & Hooks</span>
                </a>
                <a href="{{ route('api-docs') }}" target="_blank"
                   class="sidebar-link">
                    <i class="fa-solid fa-book-bookmark w-5 text-center text-base text-slate-400"></i>
                    <span>API Documentation</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ml-auto text-xs text-slate-400"></i>
                </a>
            </div>
        </div>

        <!-- Settings Section -->
        <div>
            <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Preferences</p>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-circle w-5 text-center text-base {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('settings.edit') }}"
                   class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders w-5 text-center text-base {{ request()->routeIs('settings.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Account/Plan Box -->
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        <div class="p-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        {{ Auth::user()->plan?->name ?? 'Free Tier' }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

