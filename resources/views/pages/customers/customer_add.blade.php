<x-dashboard-layout>
    {{-- <x-slot name="meta">
        <title>Invozen Dashboard - Manage Your Invoices</title>
    </x-slot> --}}
    <div class=" bg-gray-50 flex items-center justify-center py-4">
        <div class="container mx-auto px-4 max-w-md">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-800">Add New Client</h1>
            </div>

            <!-- Success Message -->
            {{-- <div 
                 class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <i class="fas fa-check-circle text-green-500 text-xl mb-2"></i>
                <p class="text-green-800 font-medium">Client added successfully!</p>
            </div> --}}

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form method='post' action="#" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Full name"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="email@example.com"
                        >
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input
                            type="tel"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Phone number"
                        >
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Full address"
                        ></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button
                            type="button"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50"
                        >
                            Back
                        </button>
                        <button
                            type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                        >
                    save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
