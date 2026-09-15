<header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-10 flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <!-- Left: Mobile Toggle & Page Context -->
    <div class="flex items-center gap-3 sm:gap-4">
        <button id="admin-mobile-menu-button"
                type="button"
                class="md:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl focus:outline-none transition-colors cursor-pointer"
                aria-label="Open sidebar">
            <i class="fa-solid fa-bars-staggered text-lg"></i>
        </button>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-rose-50 text-rose-700 border border-rose-200">
                Admin Panel
            </span>
            <span class="hidden sm:inline text-xs font-semibold text-slate-500">|</span>
            <span class="hidden sm:inline text-xs font-bold text-slate-700">Platform Control System</span>
        </div>
    </div>

    <!-- Right: Quick Actions & Admin Profile -->
    <div class="flex items-center gap-3 sm:gap-4">
        <a href="{{ route('admin.dashboard.payments.create') }}"
           class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Manual Payment</span>
        </a>

        <div class="h-5 w-px bg-slate-200 mx-1 hidden sm:block"></div>

        <!-- Admin Profile Dropdown -->
        @auth('admin')
            <div class="relative" x-data="{ openAdmin: false }" @click.outside="openAdmin = false">
                <button @click="openAdmin = !openAdmin"
                        type="button"
                        id="admin-profile-button"
                        class="flex items-center gap-2.5 p-1.5 sm:px-2.5 sm:py-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none cursor-pointer select-none"
                        aria-label="Admin menu" :aria-expanded="openAdmin">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-rose-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm overflow-hidden shrink-0 pointer-events-none">
                        @if(Auth::guard('admin')->user()->profile_pic)
                            <img src="{{ asset('storage/profile_pics/' . Auth::guard('admin')->user()->profile_pic) }}"
                                 alt="{{ Auth::guard('admin')->user()->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span>{{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="hidden md:block text-left pointer-events-none">
                        <span class="block text-xs font-bold text-slate-900 leading-tight">{{ Auth::guard('admin')->user()->name }}</span>
                        <span class="block text-[10px] text-rose-600 font-bold uppercase tracking-wider">Super Administrator</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 ml-0.5 pointer-events-none"
                       :class="{'rotate-180': openAdmin}"></i>
                </button>

                <!-- Admin Dropdown Menu -->
                <div id="admin-profile-menu"
                     x-show="openAdmin"
                     x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2 z-50">
                    <div class="px-4 py-2.5 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::guard('admin')->user()->name }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                    </div>

                    <div class="p-1 space-y-0.5">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-colors">
                            <i class="fa-solid fa-chart-pie w-4 text-slate-400"></i>
                            <span>Admin Dashboard</span>
                        </a>
                        <a href="{{ route('admin.dashboard.users-list') }}"
                           class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-colors">
                            <i class="fa-solid fa-users w-4 text-slate-400"></i>
                            <span>Manage Users</span>
                        </a>
                        <a href="{{ route('admin.profile.edit') }}"
                           class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-colors">
                            <i class="fa-solid fa-user-shield w-4 text-slate-400"></i>
                            <span>Security Profile</span>
                        </a>
                    </div>

                    <div class="p-1 border-t border-slate-100 mt-1">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-xl transition-colors text-left cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket w-4"></i>
                                <span>Sign Out Admin</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('admin.login') }}" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold">Admin Login</a>
        @endauth
    </div>
</header>
