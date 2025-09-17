<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden text-gray-600 mr-4">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <span class="text-2xl font-bold text-primary">Invozen</span>
                </a>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 p-6">
            <div class="flex justify-between items-center mb-8">
                <span class="text-2xl font-bold text-primary">Invozen</span>
                <button id="close-menu" class="text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <nav class="flex flex-col space-y-6">
                @if (request()->routeIs('home'))
                    <a href="#features" class="text-gray-600 hover:text-primary ">Features</a>
                    <a href="#pricing" class="text-gray-600 hover:text-primary ">Pricing</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-primary ">Reviews</a>
                    <a href="#faq" class="text-gray-600 hover:text-primary">Support</a>
                @endif
                @guest()
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary ">Sign In</a>
                    <a href="{{ route('register') }}"
                       class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark w-full">Register</a>
                @endguest
            </nav>

        </div>

        <!-- Desktop Navigation -->
        @if (request()->routeIs('home'))
            <nav class="hidden md:flex space-x-8">
                <a href="#features"
                   class="text-gray-600 hover:text-primary transition-colors cursor-pointer">Features</a>
                <a href="#pricing" class="text-gray-600 hover:text-primary transition-colors cursor-pointer">Pricing</a>
                <a href="#testimonials" class="text-gray-600 hover:text-primary transition-colors cursor-pointer">Reviews</a>
                <a href="#faq" class="text-gray-600 hover:text-primary transition-colors cursor-pointer">Support</a>
            </nav>
        @endif

        <div class="flex items-center space-x-4">
            @guest()
                <a href="{{ route('login') }}"
                   class="hidden md:block text-gray-600 hover:text-primary transition-colors">Sign In</a>
                <a href="{{ route('register') }}"
                   class="hidden md:block bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">Sign Up</a>
            @endguest

            @include('custom-components.dashboard_auth')
        </div>

    </div>
</div>


