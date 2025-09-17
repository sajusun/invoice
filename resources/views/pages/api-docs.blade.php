<x-app-layout>
    <x-slot name="title">API Docs - Invozen</x-slot>

    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-gray-900 text-center mb-10">API Documentation</h1>

            <div class="bg-white p-8 rounded-lg shadow-sm">
                <h2 class="text-2xl font-semibold mb-6">Authentication</h2>
                <pre class="bg-gray-900 text-green-400 p-4 rounded-lg mb-6">
POST /api/auth/login
{
    "email": "user@example.com",
    "password": "password"
}
                </pre>

                <h2 class="text-2xl font-semibold mb-6">Invoices</h2>
                <pre class="bg-gray-900 text-green-400 p-4 rounded-lg">
GET /api/invoices
Authorization: Bearer {token}
                </pre>
            </div>
        </div>
    </div>
</x-app-layout>
