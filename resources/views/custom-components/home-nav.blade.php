<header id="header" x-data="{ mobileOpen: false }" class="backdrop-blur-md bg-white/90 sticky top-0 z-50 border-b border-slate-100/80 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-18 py-3">
            <!-- Left Side: Hamburger & Brand -->
            <div class="flex items-center gap-4 lg:gap-8">
                <!-- Mobile Hamburger Button -->
                <button @click="mobileOpen = !mobileOpen" type="button" class="md:hidden text-slate-600 hover:text-slate-900 p-2 rounded-xl hover:bg-slate-100 transition focus:outline-none" aria-label="Toggle Navigation Menu">
                    <i :class="mobileOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'" class="text-xl"></i>
                </button>

                <!-- Brand Logo Mark -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform">
                        ⚡
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 leading-none">Invozen</span>
                        <span class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mt-0.5">SaaS & Microservice</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-5 lg:space-x-6 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}#features" class="hover:text-indigo-600 transition-colors">Features</a>
                    <a href="{{ route('invoice.builder') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('invoice.builder') ? 'text-indigo-600 font-bold' : '' }}">Invoice Builder</a>
                    <a href="{{ route('api-docs') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1.5 {{ request()->routeIs('api-docs') ? 'text-indigo-600 font-bold' : '' }}">
                        <span>Developer API</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-indigo-50 text-indigo-600 border border-indigo-100">V1</span>
                    </a>
                    <a href="{{ route('guides') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('guides') ? 'text-indigo-600 font-bold' : '' }}">User Guides</a>
                    <a href="{{ route('choose-plan') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('choose-plan') ? 'text-indigo-600 font-bold' : '' }}">Pricing</a>
                    <a href="{{ route('home') }}#faq" class="hover:text-indigo-600 transition-colors">FAQ</a>
                </nav>
            </div>

            <!-- Right Side Auth / Dashboard Profile -->
            <div class="flex items-center gap-3">
                @include('custom-components.user_auth_or_not')
            </div>
        </div>
    </div>

    <!-- Mobile Slide-Down Navigation Menu -->
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-xl px-4 pt-3 pb-6 space-y-2 shadow-2xl">
        <a @click="mobileOpen = false" href="{{ route('home') }}#features" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-layer-group w-5 text-slate-400 mr-2"></i> Features
        </a>
        <a @click="mobileOpen = false" href="{{ route('invoice.builder') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-file-invoice w-5 text-slate-400 mr-2"></i> Invoice Builder
        </a>
        <a @click="mobileOpen = false" href="{{ route('api-docs') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-code w-5 text-slate-400 mr-2"></i> Developer API (V1)
        </a>
        <a @click="mobileOpen = false" href="{{ route('guides') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-book-open w-5 text-slate-400 mr-2"></i> User Guides
        </a>
        <a @click="mobileOpen = false" href="{{ route('choose-plan') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-tags w-5 text-slate-400 mr-2"></i> Pricing
        </a>
        <a @click="mobileOpen = false" href="{{ route('home') }}#faq" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
            <i class="fa-solid fa-circle-question w-5 text-slate-400 mr-2"></i> FAQ
        </a>
    </div>
</header>
