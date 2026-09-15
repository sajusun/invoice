<x-dashboard-layout>
    <x-slot name="title">Developer API & Webhooks - Invozen</x-slot>

    <div class="content p-6 space-y-8 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-code text-blue-600"></i>
                    Developer API Keys & Webhooks
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Generate secure Secret Keys to integrate Invozen Invoicing API into your apps, eCommerce stores, and SaaS backends.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('api-docs') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition shadow-sm">
                    <i class="fa-solid fa-book-open"></i>
                    API Documentation
                </a>
                <button onclick="document.getElementById('createKeyModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    Generate New Key
                </button>
            </div>
        </div>

        <!-- Session Notifications -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- One-Time Secret Key Reveal Card -->
        @if(session('new_api_key'))
            <div class="p-6 bg-amber-50 border-2 border-amber-300 rounded-2xl shadow-sm space-y-3">
                <div class="flex items-center gap-2 text-amber-900 font-semibold text-lg">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-xl"></i>
                    Save Your API Secret Key Now!
                </div>
                <p class="text-sm text-amber-800">
                    This is the <strong>only time</strong> your full Secret Key will be displayed. Copy and store it securely in your <code>.env</code> or credentials vault.
                </p>
                <div class="bg-white p-4 rounded-xl border border-amber-200 space-y-3">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Key Name:</span>
                        <span class="text-sm font-medium text-gray-900 ml-2">{{ session('new_api_key')['name'] }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Secret Key (Bearer Token):</span>
                        <div class="flex items-center gap-2">
                            <input type="text" id="secretKeyField" readonly
                                   value="{{ session('new_api_key')['secret_key'] }}"
                                   class="flex-1 font-mono text-sm bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-900 select-all focus:outline-none">
                            <button onclick="copySecretKey()"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg flex items-center gap-1.5 transition">
                                <i class="fa-regular fa-copy"></i>
                                <span id="copyBtnText">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Active API Keys Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Your API Secret Keys</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Use these keys to authenticate REST API requests via <code>Authorization: Bearer &lt;SECRET_KEY&gt;</code></p>
                </div>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                    {{ $apiKeys->count() }} {{ Str::plural('Key', $apiKeys->count()) }}
                </span>
            </div>

            @if($apiKeys->isEmpty())
                <div class="p-12 text-center space-y-3">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">No API Keys Generated Yet</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto">
                        Generate your first API Key to connect Invozen with your apps, websites, WooCommerce, or external platforms.
                    </p>
                    <button onclick="document.getElementById('createKeyModal').classList.remove('hidden')"
                            class="mt-2 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        <i class="fa-solid fa-plus"></i>
                        Generate API Key
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="py-3.5 px-5">Name / Identifier</th>
                                <th class="py-3.5 px-5">Secret Key</th>
                                <th class="py-3.5 px-5">Scopes</th>
                                <th class="py-3.5 px-5">Last Used</th>
                                <th class="py-3.5 px-5">Status</th>
                                <th class="py-3.5 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($apiKeys as $key)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="py-4 px-5">
                                        <div class="font-semibold text-gray-900">{{ $key->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">Created {{ $key->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="py-4 px-5 font-mono text-xs text-gray-600">
                                        inv_live_sk_{{ $key->secret_preview ?? '••••' }}
                                    </td>
                                    <td class="py-4 px-5">
                                        @if(empty($key->scopes) || in_array('*', $key->scopes))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                Full Access (*)
                                            </span>
                                        @else
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($key->scopes as $scope)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                                        {{ $scope }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-xs text-gray-500">
                                        {{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}
                                    </td>
                                    <td class="py-4 px-5">
                                        @if($key->is_active)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Revoked
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('developer.api-keys.toggle', $key->id) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="px-2.5 py-1 text-xs font-medium rounded-lg border {{ $key->is_active ? 'border-amber-300 text-amber-700 hover:bg-amber-50' : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }} transition">
                                                    {{ $key->is_active ? 'Revoke' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('developer.api-keys.destroy', $key->id) }}" onsubmit="return confirm('Are you sure you want to delete this API Key? Any application using it will lose access.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Webhook Endpoints Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-satellite-dish text-purple-600"></i>
                        Webhook Endpoints
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Receive real-time HTTP POST notifications when invoices are created, paid, or overdue.</p>
                </div>
                <button onclick="document.getElementById('createWebhookModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                    <i class="fa-solid fa-plus"></i>
                    Add Webhook URL
                </button>
            </div>

            @if($webhooks->isEmpty())
                <div class="p-8 text-center text-sm text-gray-500">
                    No webhooks configured. Add an endpoint to receive automated event payloads.
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($webhooks as $wh)
                        <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 hover:bg-gray-50/60 transition">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-sm font-semibold text-gray-900">{{ $wh->url }}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-purple-50 text-purple-700 border border-purple-100">Active</span>
                                </div>
                                <div class="text-xs text-gray-400 flex items-center gap-3">
                                    <span>Secret: <code>{{ substr($wh->secret, 0, 10) }}••••••••</code></span>
                                    <span>Events: {{ implode(', ', $wh->events ?? ['*']) }}</span>
                                </div>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('developer.webhooks.destroy', $wh->id) }}" onsubmit="return confirm('Delete this webhook endpoint?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-xs text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal: Generate API Key -->
    <div id="createKeyModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-xl border border-gray-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-key text-blue-600"></i>
                    Generate New API Key
                </h3>
                <button onclick="document.getElementById('createKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('developer.api-keys.store') }}" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Key Name / Description</label>
                    <input type="text" name="name" required placeholder="e.g. WooCommerce Store, LMS Backend, Mobile App"
                           class="w-full text-sm border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Permissions & Scopes</label>
                    <div class="space-y-2 bg-gray-50 p-3 rounded-xl border border-gray-200 text-xs">
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-900">
                            <input type="checkbox" name="scopes[]" value="*" checked class="rounded text-blue-600 focus:ring-blue-500">
                            Full Access (*)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                            <input type="checkbox" name="scopes[]" value="invoices:create" class="rounded text-blue-600 focus:ring-blue-500">
                            Create Invoices (<code>invoices:create</code>)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                            <input type="checkbox" name="scopes[]" value="invoices:read" class="rounded text-blue-600 focus:ring-blue-500">
                            Read Invoices & Download PDF (<code>invoices:read</code>)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                            <input type="checkbox" name="scopes[]" value="customers:manage" class="rounded text-blue-600 focus:ring-blue-500">
                            Manage Customers (<code>customers:manage</code>)
                        </label>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('createKeyModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">
                        Generate Key
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Add Webhook -->
    <div id="createWebhookModal" class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-satellite-dish text-purple-600"></i>
                    Register Webhook Endpoint
                </h3>
                <button onclick="document.getElementById('createWebhookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('developer.webhooks.store') }}" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Webhook Destination URL</label>
                    <input type="url" name="url" required placeholder="https://yourapp.com/api/webhooks/invozen"
                           class="w-full text-sm border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Subscribe to Events</label>
                    <div class="space-y-2 bg-gray-50 p-3 rounded-xl border border-gray-200 text-xs">
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-900">
                            <input type="checkbox" name="events[]" value="invoice.created" checked class="rounded text-purple-600">
                            Invoice Created (<code>invoice.created</code>)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-900">
                            <input type="checkbox" name="events[]" value="invoice.paid" checked class="rounded text-purple-600">
                            Invoice Paid (<code>invoice.paid</code>)
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-900">
                            <input type="checkbox" name="events[]" value="invoice.overdue" checked class="rounded text-purple-600">
                            Invoice Overdue (<code>invoice.overdue</code>)
                        </label>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('createWebhookModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition shadow-sm">
                        Save Webhook
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function copySecretKey() {
            const field = document.getElementById('secretKeyField');
            field.select();
            navigator.clipboard.writeText(field.value);
            const btnText = document.getElementById('copyBtnText');
            btnText.innerText = 'Copied!';
            setTimeout(() => { btnText.innerText = 'Copy'; }, 2500);
        }
    </script>
</x-dashboard-layout>
