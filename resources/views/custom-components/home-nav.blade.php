<header id="header" class="backdrop-blur-md bg-white/90 sticky top-0 z-50 border-b border-slate-100/80 transition-all">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-18 py-3">
        <div class="flex items-center gap-8">
            <button id="mobile-menu-button" class="md:hidden text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform">
                        ⚡
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 leading-none">Invozen</span>
                        <span class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mt-0.5">SaaS & Microservice</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                <a href="#features" class="hover:text-indigo-600 transition-colors">Features</a>
                <a href="#developers" class="hover:text-indigo-600 transition-colors flex items-center gap-1.5">
                    <span>Developer API</span>
                    <span class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-indigo-50 text-indigo-600 border border-indigo-100">V1</span>
                </a>
                <a href="#pricing" class="hover:text-indigo-600 transition-colors">Pricing</a>
                <a href="#faq" class="hover:text-indigo-600 transition-colors">FAQ</a>
                <a href="{{ route('api-docs') }}" class="hover:text-indigo-600 transition-colors">Documentation</a>
            </nav>
        </div>

        <!-- Right Side Auth / Dashboard -->
        <div class="flex items-center gap-3">
            @include('custom-components.user_auth_or_not')
        </div>
    </div>
</div>
</header>
