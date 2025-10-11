<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth('admin')->id() }}">

@isset($meta)
        {{$meta}}
    @endisset
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/dashboard.css','resources/js/admin-dashboard.js'])
</head>
<body class="bg-gray-50 max-w-7xl mx-auto">
<div id="dashboard-container" class="dashboard-grid">
    @include('custom-components.admin-dashboard-aside')
    <x-admin-navbar/>
    {{$slot}}
</div>
<div id="mobile-menu" class="mobile-menu fixed inset-0 z-50 bg-gray-800 bg-opacity-75 hidden">
    <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 p-6">
        <div class="flex justify-between items-center mb-8">
            @auth('admin')
                <h1 class="text-2xl font-bold text-primary">Dashboard</h1>
            @else
            <h1 class="text-2xl font-bold text-primary">{{config('app.name')}} - Admin</h1>
            @endauth
            <button id="close-menu" class="text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="space-y-2">
            <a href="{{ route('dashboard') }}" class="sidebar-item active flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-gauge-high w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('invoices') }} " class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-file-invoice w-5 mr-3"></i>
                <span>Invoices</span>
            </a>
            <a href="{{ route('customers') }} " class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-users w-5 mr-3"></i>
                <span>Clients</span>
            </a>
            <a href="{{ route('invoice.builder') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-receipt w-5 mr-3"></i>
                <span>Invoice Builder</span>
            </a>
            <a href="{{ route('subscription.plan') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-money-bill-transfer w-5 mr-3"></i>
                <span>Plans</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-chart-simple w-5 mr-3"></i>
                <span>Reports</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-user-gear w-5 mr-3"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('settings.edit') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-gear w-5 mr-3"></i>
                <span>Settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="sidebar-item flex items-center p-0 rounded-lg transition-colors">
                @csrf
                <button type="submit"
                        class="w-full text-red-500 sidebar-item text-left p-3 hover:text-red-600 flex items-center transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5 mr-3 text-red-500"> </i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    // Mobile menu functionality
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('mobile-menu').classList.add('active');
        }, 10);
    });

    document.getElementById('close-menu').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.remove('active');
        setTimeout(() => {
            document.getElementById('mobile-menu').classList.add('hidden');
        }, 300);
    });
</script>
</body>
</html>
