<!-- Sidebar -->
<div class="sidebar bg-white shadow-md z-10">
    <a href="/">
    <div class="p-5 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-primary">{{config('app.name')}}</h1>
        <p class="text-sm text-gray-600">Admin Dashboard Panel</p>
    </div>
    </a>
    <div class="p-4">
        <p class="text-xs uppercase text-gray-500 font-semibold mb-3">Main</p>
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item active flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-gauge-high w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.dashboard.users-list') }} " class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-users w-5 mr-3"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('invoice.builder') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-receipt w-5 mr-3"></i>
                <span>Invoice Builder</span>
            </a>
        </div>

        <p class="text-xs uppercase text-gray-500 font-semibold mb-3 mt-6">Financial</p>
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard.payments') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-money-bill-transfer w-5 mr-3"></i>
                <span>Payments</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-chart-simple w-5 mr-3"></i>
                <span>Reports</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-money-bill-trend-up w-5 mr-3"></i>
                <span>Taxes</span>
            </a>
        </div>

        <p class="text-xs uppercase text-gray-500 font-semibold mb-3 mt-6">User</p>
        <div class="space-y-1">
            <a href="{{ route('profile.edit') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-user-gear w-5 mr-3"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('settings.edit') }}" class="sidebar-item flex items-center p-3 rounded-lg transition-colors">
                <i class="fa-solid fa-gear w-5 mr-3"></i>
                <span>Settings</span>
            </a>
            <form method="POST" action="{{route('admin.logout')}}" class="sidebar-item flex items-center p-0 rounded-lg transition-colors">
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
