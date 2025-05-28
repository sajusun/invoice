<!-- Navbar -->
<nav class="navbar-light h-16 bg-light shadow-sm px-4 py-1 flex justify-between items-center">
    <div class="flex items-center gap-4">

        <!-- Toggle Sidebar -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

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
