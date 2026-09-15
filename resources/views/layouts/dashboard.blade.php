<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <title>{{ $title ?? config('app.name', 'Invozen') }}</title>
    
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
<body class="h-full bg-slate-50/60 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <div class="min-h-screen flex">
        <!-- Desktop Sidebar -->
        <div class="hidden md:block">
            @include('custom-components.dashboard-aside')
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-x-hidden">
            @include('custom-components.dashboard-header')
            
            <main class="flex-1 pb-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Slide-over Drawer -->
    <div id="mobile-menu" class="fixed inset-0 z-50 pointer-events-none transition-all duration-300">
        <!-- Backdrop -->
        <div id="mobile-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs opacity-0 transition-opacity duration-300 pointer-events-none"></div>

        <!-- Drawer Content -->
        <div id="mobile-panel" class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-white shadow-2xl z-50 flex flex-col -translate-x-full transition-transform duration-300 ease-in-out pointer-events-auto">
            <!-- Mobile Brand & Close -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-file-invoice text-base"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black tracking-tight text-slate-900">Invozen</span>
                    </div>
                </a>
                <button id="close-menu" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Mobile Nav -->
            <div class="flex-1 overflow-y-auto px-4 py-5 space-y-5 scrollbar-thin">
                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Main Menu</p>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-gauge-high w-5 text-center text-base {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('invoices') }}" class="sidebar-link {{ request()->routeIs('invoices*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base {{ request()->routeIs('invoices*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Invoices</span>
                        </a>
                        <a href="{{ route('customers') }}" class="sidebar-link {{ request()->routeIs('customers*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users w-5 text-center text-base {{ request()->routeIs('customers*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Clients</span>
                        </a>

                        <a href="{{ route('invoice.builder') }}" class="sidebar-link {{ request()->routeIs('invoice.builder*') ? 'active' : '' }}">
                            <i class="fa-solid fa-wand-magic-sparkles w-5 text-center text-base {{ request()->routeIs('invoice.builder*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Invoice Builder</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Financial</p>
                    <div class="space-y-1">
                        <a href="{{ route('subscription.plan') }}" class="sidebar-link {{ request()->routeIs('subscription.plan*') ? 'active' : '' }}">
                            <i class="fa-solid fa-gem w-5 text-center text-base {{ request()->routeIs('subscription.plan*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Plans & Billing</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Developer</p>
                    <div class="space-y-1">
                        <a href="{{ route('developer.api-keys') }}" class="sidebar-link {{ request()->routeIs('developer.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-key w-5 text-center text-base {{ request()->routeIs('developer.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>API Keys & Hooks</span>
                        </a>
                        <a href="{{ route('api-docs') }}" target="_blank" class="sidebar-link">
                            <i class="fa-solid fa-book-bookmark w-5 text-center text-base text-slate-400"></i>
                            <span>API Documentation</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Preferences</p>
                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-circle w-5 text-center text-base {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('settings.edit') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-sliders w-5 text-center text-base {{ request()->routeIs('settings.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer Bottom -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Dropdown & Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu
            const mobileMenu = document.getElementById('mobile-menu');
            const mobilePanel = document.getElementById('mobile-panel');
            const mobileBackdrop = document.getElementById('mobile-backdrop');
            const openBtn = document.getElementById('mobile-menu-button');
            const closeBtn = document.getElementById('close-menu');

            function openMobileNav() {
                if (!mobileMenu) return;
                mobileMenu.classList.remove('pointer-events-none');
                mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                mobileBackdrop.classList.add('opacity-100', 'pointer-events-auto');
                mobilePanel.classList.remove('-translate-x-full');
                mobilePanel.classList.add('translate-x-0');
            }

            function closeMobileNav() {
                if (!mobileMenu) return;
                mobileBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
                mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
                mobilePanel.classList.remove('translate-x-0');
                mobilePanel.classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('pointer-events-none');
                }, 300);
            }

            if (openBtn) openBtn.addEventListener('click', openMobileNav);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileNav);
            if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileNav);

            // Universal Dropdown Handler (Vanilla JS fail-safe)
            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('[data-dropdown-trigger]');
                if (trigger) {
                    const targetId = trigger.getAttribute('data-dropdown-trigger');
                    const menu = document.getElementById(targetId);
                    if (menu) {
                        const isHidden = menu.classList.contains('hidden') && !menu.classList.contains('!block');
                        // Close all other dropdowns
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

                // If click is outside any dropdown wrapper, close all
                if (!e.target.closest('[data-dropdown-wrapper]')) {
                    document.querySelectorAll('[data-dropdown-wrapper] [id]').forEach(m => {
                        m.classList.add('hidden');
                        m.classList.remove('!block');
                    });
                }
            });

            // Escape key closes menus
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMobileNav();
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


