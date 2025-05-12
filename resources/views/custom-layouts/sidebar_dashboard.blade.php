<aside :class="sidebarOpen ? 'block fixed' : 'hidden lg:block relative'" class="w-64 min-h-screen p-4 border-r shadow-md bg-white">
    <nav class="space-y-2 [a]:no-underline">
<h2><a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-100 text-gray-700">
        <i class="fas fa-home w-4 mr-2"> </i> Dashboard</a></h2>

<a href="/invoice/builder" class="block py-2 px-3 rounded hover:bg-gray-100 text-gray-700">
    <i class="fas fa-file-invoice w-4 mr-2"> </i> Invoice Builder</a>

<a href="{{ route('customers') }} " class="block py-2 px-3 rounded hover:bg-gray-100 text-gray-700">
    <i class="fas fa-users w-4 mr-2"> </i> Customers</a>

<a href="{{ route('profile.edit') }} " class="block py-2 px-3 rounded hover:bg-gray-100 text-gray-700">
    <i class="fas fa-user w-4 mr-2"> </i>Profile</a>
    </nav>
</aside>
