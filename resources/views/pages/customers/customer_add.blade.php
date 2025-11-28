<x-dashboard-layout>
    <x-slot name="meta">
        <title>Invozen Dashboard - add client</title>
    </x-slot>
    <div class=" bg-gray-50 flex items-start justify-start pt-8">
        <div class="container mx-auto px-4 max-w-lg">
            <!-- Header -->
            <div class="mb-4 text-center bg-gray-400 w-full p-2 br-2">
                <h1 class="text-2xl font-bold text-white">Add New Client</h1>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mb-2"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <i class="fas fa-check-circle text-red-500 text-xl mb-2"></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-green-50 border border-red-200 rounded-lg p-4 text-center">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="fa-solid fa-x text-red-500 text-xl mb-2"></li>
                            <p class="text-red-800 font-medium">{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form method='post' action="{{ route('customers.add') }}" class="space-y-4">
                    @csrf
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input name="name" type="text" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Customer Name">
                    </div>
                     <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input name="phone" type="tel" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Phone number">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="email@example.com">
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Address"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <a type="button" href="{{ route('customers') }}"
                            class="flex-1 px-4 py-2 text-center border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                            Back
                    </a>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">
                            save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
