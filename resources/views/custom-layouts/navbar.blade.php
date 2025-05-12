<!-- Navbar -->
<nav class="navbar-light bg-light shadow-sm px-4 py-1 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <!-- Toggle Sidebar -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
{{--        <span class="text-xl font-semibold text-gray-800">Invozen</span>--}}
        <a class="navbar-brand fw-bold" style="font-size: 2rem;padding-top: .1rem; font-family: 'Roboto Thin',math;font-variant: small-caps;" href="/">
            <img
                src="https://thumbs.dreamstime.com/b/invoice-icon-linear-logo-mark-set-collection-black-white-web-invoice-icon-linear-logo-mark-black-white-330206480.jpg"
                alt="logo" width="40" height="40" class="d-inline-block align-text-top">
            InvoZen
        </a>
    </div>

    <div>
        @include('custom-layouts.auth-or-dashboard')
    </div>
</nav>

<!-- Top Nav -->
{{--<nav class="bg-white shadow-md px-4 py-3 flex justify-between items-center">--}}
{{--    <div class="flex items-center gap-4">--}}
{{--        <!-- Toggle Sidebar -->--}}
{{--        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-700 focus:outline-none">--}}
{{--            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>--}}
{{--            </svg>--}}
{{--        </button>--}}
{{--        <span class="text-xl font-semibold text-gray-800">Invozen</span>--}}
{{--    </div>--}}

{{--    <!-- Auth / Account -->--}}
{{--    <div>--}}
{{--        @include('custom-layouts.auth-or-dashboard')--}}
{{--        <template x-if="!isLoggedIn">--}}
{{--            <div class="space-x-4">--}}
{{--                <a href="#" class="text-gray-700 hover:text-blue-500">Login</a>--}}
{{--                <a href="#" class="text-gray-700 hover:text-blue-500">Register</a>--}}
{{--            </div>--}}
{{--        </template>--}}

{{--        <template x-if="isLoggedIn">--}}
{{--            <div class="relative" x-data="{ open: false }">--}}
{{--                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">--}}
{{--                    <img src="https://i.pravatar.cc/30" class="rounded-full w-8 h-8" alt="avatar">--}}
{{--                    <span class="text-gray-800">User</span>--}}
{{--                </button>--}}
{{--                <div x-show="open" @click.away="open = false"--}}
{{--                     class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg z-10">--}}
{{--                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>--}}
{{--                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </template>--}}
{{--    </div>--}}
{{--</nav>--}}
