<header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-10 flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <!-- Left: Mobile Toggle & Quick Search -->
    <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-lg">
        <button id="mobile-menu-button"
                type="button"
                class="md:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl focus:outline-none transition-colors"
                aria-label="Open sidebar">
            <i class="fa-solid fa-bars-staggered text-lg"></i>
        </button>

        <!-- Search Bar -->
        <div class="relative w-full max-w-xs sm:max-w-sm hidden sm:block">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text"
                   placeholder="Search invoices, clients..."
                   class="w-full pl-9 pr-12 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-white border border-slate-200 rounded shadow-2xs">⌘K</kbd>
            </span>
        </div>
    </div>

    <!-- Right: Quick Actions & Profile -->
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Quick Create Dropdown -->
        <div class="relative" x-data="{ openCreate: false }">
            <button @click="openCreate = !openCreate"
                    type="button"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 hover:shadow-md transition-all focus:outline-none">
                <i class="fa-solid fa-plus text-xs"></i>
                <span class="hidden sm:inline">New</span>
                <i class="fa-solid fa-chevron-down text-[9px] opacity-70 ml-0.5"></i>
            </button>

            <!-- Dropdown -->
            <div x-show="openCreate"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 @click.away="openCreate = false"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-200/80 p-1.5 z-50"
                 style="display: none;">
                <a href="{{ route('invoice.builder') }}"
                   class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                    <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-[11px]">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <span>New Invoice</span>
                </a>
                <a href="{{ route('customers.add') }}"
                   class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-xl transition-colors">
                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-[11px]">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span>New Client</span>
                </a>
            </div>
        </div>

        <div class="h-5 w-px bg-slate-200/80 mx-1 hidden sm:block"></div>

        @include('custom-components.user_auth_or_not')
    </div>
</header>

