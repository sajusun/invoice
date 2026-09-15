<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth('admin')->id() }}">

    <title>{{ $title ?? config('app.name', 'Invozen Admin') }} - Admin Control</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>

    @isset($meta)
        {{ $meta }}
    @endisset

    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-100 text-slate-800 antialiased selection:bg-rose-600 selection:text-white">
    <div class="min-h-screen flex">
        <!-- Desktop Admin Sidebar -->
        <div class="hidden md:block">
            @include('custom-components.admin-dashboard-aside')
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-x-hidden">
            <x-admin-navbar/>

            <main class="flex-1 pb-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Admin Mobile Slide-over Drawer -->
    <div id="admin-mobile-menu" class="fixed inset-0 z-50 pointer-events-none transition-all duration-300">
        <!-- Backdrop -->
        <div id="admin-mobile-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs opacity-0 transition-opacity duration-300 pointer-events-none"></div>

        <!-- Drawer Content -->
        <div id="admin-mobile-panel" class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-[#0B1120] text-slate-300 shadow-2xl z-50 flex flex-col -translate-x-full transition-transform duration-300 ease-in-out pointer-events-auto border-r border-slate-800">
            <!-- Mobile Brand & Close -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 bg-[#0F172A]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-rose-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-rose-500/20">
                        <i class="fa-solid fa-shield-halved text-base"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black tracking-tight text-white">Invozen</span>
                        <span class="block text-[9px] uppercase font-bold tracking-widest text-rose-400">Admin</span>
                    </div>
                </a>
                <button id="admin-close-menu" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="flex-1 overflow-y-auto px-4 py-5 space-y-5 scrollbar-thin">
                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Platform Control</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white border-l-4 border-rose-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                            <i class="fa-solid fa-chart-pie w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                            <span>Admin Dashboard</span>
                        </a>
                        <a href="{{ route('admin.dashboard.users-list') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard.users-list*') ? 'bg-slate-800 text-white border-l-4 border-rose-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                            <i class="fa-solid fa-users-gear w-5 text-center text-base {{ request()->routeIs('admin.dashboard.users-list*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                            <span>Users Management</span>
                        </a>
                        <a href="{{ route('admin.dashboard.payments') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard.payments*') ? 'bg-slate-800 text-white border-l-4 border-rose-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                            <i class="fa-solid fa-receipt w-5 text-center text-base {{ request()->routeIs('admin.dashboard.payments*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                            <span>Payment Audit</span>
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.roles.*') ? 'bg-slate-800 text-white border-l-4 border-rose-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                            <i class="fa-solid fa-user-shield w-5 text-center text-base {{ request()->routeIs('admin.roles.*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                            <span>Staff & Roles</span>
                        </a>
                        <a href="{{ route('admin.profile.edit') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.profile.*') ? 'bg-slate-800 text-white border-l-4 border-rose-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                            <i class="fa-solid fa-sliders w-5 text-center text-base {{ request()->routeIs('admin.profile.*') ? 'text-rose-400' : 'text-slate-500' }}"></i>
                            <span>Admin Profile</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Drawer Bottom -->
            <div class="p-4 border-t border-slate-800 bg-[#0F172A]">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 transition-colors cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Sign Out Admin</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin Mobile & Dropdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Admin Mobile Nav
            const adminMenu = document.getElementById('admin-mobile-menu');
            const adminPanel = document.getElementById('admin-mobile-panel');
            const adminBackdrop = document.getElementById('admin-mobile-backdrop');
            const adminOpenBtn = document.getElementById('admin-mobile-menu-button');
            const adminCloseBtn = document.getElementById('admin-close-menu');

            function openAdminNav() {
                if (!adminMenu) return;
                adminMenu.classList.remove('pointer-events-none');
                adminBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                adminBackdrop.classList.add('opacity-100', 'pointer-events-auto');
                adminPanel.classList.remove('-translate-x-full');
                adminPanel.classList.add('translate-x-0');
            }

            function closeAdminNav() {
                if (!adminMenu) return;
                adminBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
                adminBackdrop.classList.add('opacity-0', 'pointer-events-none');
                adminPanel.classList.remove('translate-x-0');
                adminPanel.classList.add('-translate-x-full');
                setTimeout(() => {
                    adminMenu.classList.add('pointer-events-none');
                }, 300);
            }

            if (adminOpenBtn) adminOpenBtn.addEventListener('click', openAdminNav);
            if (adminCloseBtn) adminCloseBtn.addEventListener('click', closeAdminNav);
            if (adminBackdrop) adminBackdrop.addEventListener('click', closeAdminNav);

            // Universal Dropdown fail-safe handler
            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('[data-dropdown-trigger]');
                if (trigger) {
                    const targetId = trigger.getAttribute('data-dropdown-trigger');
                    const menu = document.getElementById(targetId);
                    if (menu) {
                        const isHidden = menu.classList.contains('hidden') && !menu.classList.contains('!block');
                        document.querySelectorAll('[data-dropdown-wrapper] [id]').forEach(m => {
                            if (m.id !== targetId) {
                                m.classList.add('hidden');
                                m.classList.remove('!block');
                            }
                        });
                        if (isHidden) {
                            menu.classList.remove('hidden');
                            menu.classList.add('!block');
                        } else {
                            menu.classList.add('hidden');
                            menu.classList.remove('!block');
                        }
                    }
                    return;
                }

                if (!e.target.closest('[data-dropdown-wrapper]')) {
                    document.querySelectorAll('[data-dropdown-wrapper] [id]').forEach(m => {
                        m.classList.add('hidden');
                        m.classList.remove('!block');
                    });
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAdminNav();
                    document.querySelectorAll('[data-dropdown-wrapper] [id]').forEach(m => {
                        m.classList.add('hidden');
                        m.classList.remove('!block');
                    });
                }
            });
        });
    </script>
</body>
</html>

