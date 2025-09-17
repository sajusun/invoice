<x-app-layout>
    <x-slot name="title">Guides - Invozen</x-slot>

    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-gray-900 text-center mb-10">User Guides</h1>
            <x-breadcrumbs></x-breadcrumbs>

            <ul class="space-y-4 max-w-2xl mx-auto">
                <li class="bg-white p-6 rounded-lg shadow-sm flex justify-between items-center">
                    <span>📘 Getting Started with Invozen</span>
                    <a href="#" class="text-primary hover:underline">Read →</a>
                </li>
                <li class="bg-white p-6 rounded-lg shadow-sm flex justify-between items-center">
                    <span>💳 How to Manage Subscriptions</span>
                    <a href="#" class="text-primary hover:underline">Read →</a>
                </li>
                <li class="bg-white p-6 rounded-lg shadow-sm flex justify-between items-center">
                    <span>📊 Tracking Payments</span>
                    <a href="#" class="text-primary hover:underline">Read →</a>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
