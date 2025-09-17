<x-app-layout>
    <div id="header">
        <h2 class="text-2xl font-semibold text-gray-900">Integrations</h2>
        <x-breadcrumbs />
        <nav class="flex text-sm mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="/" class="px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-primary hover:text-white transition">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/payments" class="px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-primary hover:text-white transition">
                        Payments
                    </a>
                </li>
                <li>
                    <span class="px-2 py-1 rounded-md bg-primary text-white">Invoice #1234</span>
                </li>
            </ol>
        </nav>
        <nav class="flex text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-gray-600 hover:text-primary">
                        <i class="fa fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 111.414-1.414l5
          5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="/payments" class="text-gray-600 hover:text-primary">Payments</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 111.414-1.414l5
          5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-400">Invoice #1234</span>
                    </div>
                </li>
            </ol>
        </nav>

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
