<x-app-layout>
    <div id="header" class="p-8">
        <div class="mx-auto max-w-4xl">
            <h2 class="text-4xl text-center font-semibold text-gray-900">Integrations</h2>
            <x-breadcrumbs />
        </div>

    <div class="p-6 bg-white rounded-xl shadow-md space-y-6">
        <p class="text-gray-600">Connect Invozen with your favorite apps and tools to automate workflows, sync data, and improve productivity.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-gray-50 rounded-lg text-center hover:shadow-lg transition-shadow">
                <i class="fa-brands fa-google text-3xl text-blue-500 mb-3"></i>
                <h3 class="font-semibold text-gray-800">Google Workspace</h3>
                <p class="text-sm text-gray-600 mt-2">Sync your invoices and calendar events.</p>
            </div>
            <div class="p-6 bg-gray-50 rounded-lg text-center hover:shadow-lg transition-shadow">
                <i class="fa-brands fa-slack text-3xl text-purple-600 mb-3"></i>
                <h3 class="font-semibold text-gray-800">Slack</h3>
                <p class="text-sm text-gray-600 mt-2">Receive notifications and updates instantly.</p>
            </div>
            <div class="p-6 bg-gray-50 rounded-lg text-center hover:shadow-lg transition-shadow">
                <i class="fa-brands fa-paypal text-3xl text-blue-700 mb-3"></i>
                <h3 class="font-semibold text-gray-800">PayPal</h3>
                <p class="text-sm text-gray-600 mt-2">Automate payment collection securely.</p>
            </div>
        </div>
    </div>
        </div>
</x-app-layout>
