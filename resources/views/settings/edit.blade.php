<x-dashboard-layout>
    <x-slot name="title">Business & Invoicing Settings - {{ $settings->company_name ?? 'Invozen' }}</x-slot>

    <div class="content p-4 sm:p-6 lg:p-8 space-y-8 max-w-6xl mx-auto overflow-y-auto"
         x-data="{
            activeTab: 'company',
            logoPreview: '{{ $settings->company_logo ?? '' }}',
            removeLogo: false,
            companyName: '{{ addslashes($settings->company_name ?? '') }}',
            companyEmail: '{{ addslashes($settings->company_email ?? '') }}',
            companyPhone: '{{ addslashes($settings->company_phone ?? '') }}',
            companyAddress: '{{ addslashes($settings->company_address ?? '') }}',
            invoicePrefix: '{{ addslashes($settings->invoice_prefix ?? 'INV-') }}',
            startNumber: '{{ $settings->start_number ?? 1 }}',
            defaultCurrency: '{{ $settings->default_currency ?? 'USD' }}',
            defaultTaxRate: '{{ $settings->default_tax_rate ?? 0 }}',
            showTaxColumn: {{ $settings->show_tax_column ? 'true' : 'false' }},
            showEmailColumn: {{ $settings->show_email_column ? 'true' : 'false' }},
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    this.logoPreview = URL.createObjectURL(file);
                    this.removeLogo = false;
                }
            },
            clearLogo() {
                this.logoPreview = '';
                this.removeLogo = true;
                const fileInput = document.getElementById('company_logo_input');
                if (fileInput) fileInput.value = '';
            }
         }">

        <!-- 1. Header & Breadcrumbs -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    <span class="text-slate-800">Preferences</span>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    <span class="text-slate-800">Settings</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>Business & Invoicing Settings</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Configure your business identity, logo, default currency, numbering sequences, and invoice layout.
                </p>
            </div>

            <!-- Quick Action -->
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('invoice.builder') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition-all">
                    <i class="fa-solid fa-wand-magic-sparkles text-blue-600"></i>
                    <span>Test in Invoice Builder</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                    <div>
                        <strong class="font-bold block text-emerald-950">Settings Saved</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1">
                <strong class="font-bold block text-rose-950 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> Please fix the following errors:
                </strong>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 2. Tab Navigation Bar -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
            <button type="button" @click="activeTab = 'company'"
                    :class="activeTab === 'company' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                <i class="fa-solid fa-building text-xs"></i>
                <span>Company Profile & Branding</span>
            </button>

            <button type="button" @click="activeTab = 'invoicing'"
                    :class="activeTab === 'invoicing' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar text-xs"></i>
                <span>Invoicing & Defaults</span>
            </button>

            <button type="button" @click="activeTab = 'preview'"
                    :class="activeTab === 'preview' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                <i class="fa-solid fa-eye text-xs"></i>
                <span>Live Invoice Preview</span>
            </button>
        </div>

        <!-- Form Container -->
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <input type="hidden" name="remove_logo" :value="removeLogo ? 1 : 0">

            <!-- TAB 1: Company Profile & Brand Details -->
            <div x-show="activeTab === 'company'" class="space-y-6">
                <!-- Branding / Logo Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-palette text-blue-600"></i>
                            <span>Business Logo & Branding</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">This logo will appear on all digital and PDF invoice headers.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                        <!-- Logo Image Preview Container -->
                        <div class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden shrink-0 group">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" alt="Company Logo" class="w-full h-full object-contain p-2">
                            </template>
                            <template x-if="!logoPreview">
                                <div class="text-center p-3 text-slate-400">
                                    <i class="fa-regular fa-image text-3xl mb-1 block"></i>
                                    <span class="text-[10px] font-semibold">No Logo</span>
                                </div>
                            </template>
                        </div>

                        <!-- Upload & Clear Buttons -->
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <label for="company_logo_input"
                                       class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-xs transition">
                                    <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                    <span>Upload New Logo</span>
                                </label>
                                <input type="file" id="company_logo_input" name="company_logo" accept="image/*" class="hidden" @change="previewImage($event)">

                                <button type="button" x-show="logoPreview" @click="clearLogo()"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl border border-rose-200 transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-400 leading-relaxed">
                                Recommended: Square or transparent PNG, SVG, JPG. Max size 2MB.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Company Details Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-address-card text-blue-600"></i>
                            <span>Company Identity & Contact Info</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Your official business contact information displayed on invoices.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Company Name -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Company / Business Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <input type="text" name="company_name" x-model="companyName" required
                                       value="{{ old('company_name', $settings->company_name ?? '') }}"
                                       placeholder="e.g., Acme Innovations Ltd."
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                        </div>

                        <!-- Company Email -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Billing Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <input type="email" name="company_email" x-model="companyEmail"
                                       value="{{ old('company_email', $settings->company_email ?? '') }}"
                                       placeholder="billing@yourcompany.com"
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                        </div>

                        <!-- Company Phone -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Contact Phone Number
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <input type="text" name="company_phone" x-model="companyPhone"
                                       value="{{ old('company_phone', $settings->company_phone ?? '') }}"
                                       placeholder="+1 (555) 000-1234"
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                        </div>

                        <!-- Company Address -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Physical Address / Tax Jurisdiction
                            </label>
                            <div class="relative">
                                <textarea name="company_address" x-model="companyAddress" rows="3"
                                          placeholder="123 Business Avenue, Suite 400, New York, NY 10001, USA"
                                          class="w-full text-xs sm:text-sm p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ old('company_address', $settings->company_address ?? '') }}</textarea>
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Printed under company name on invoice exports.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Invoicing & Defaults -->
            <div x-show="activeTab === 'invoicing'" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-blue-600"></i>
                            <span>Invoice Defaults & Sequences</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Control how new invoices are numbered, formatted, and calculated.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Default Currency -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Default Currency <span class="text-rose-500">*</span>
                            </label>
                            <select name="default_currency" x-model="defaultCurrency" required
                                    class="w-full text-xs sm:text-sm py-3 px-4 rounded-xl border border-slate-200 bg-slate-50/50 font-bold text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                @foreach($currencies as $code => $curr)
                                    <option value="{{ $code }}" {{ ($settings->default_currency ?? 'USD') === $code ? 'selected' : '' }}>
                                        {{ $code }} - {{ $curr['name'] }} ({{ $curr['symbol'] }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-[11px] text-slate-400 mt-1 block">Applied to newly created invoices and summary dashboards.</span>
                        </div>

                        <!-- Default Tax Rate -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Default Tax Rate (%)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-percent"></i>
                                </div>
                                <input type="number" step="0.01" min="0" max="100" name="default_tax_rate" x-model="defaultTaxRate"
                                       value="{{ old('default_tax_rate', $settings->default_tax_rate ?? 0) }}"
                                       placeholder="e.g. 10.00"
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Automatically prefilled in the invoice editor.</span>
                        </div>

                        <!-- Invoice Prefix -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Invoice Number Prefix
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-hashtag"></i>
                                </div>
                                <input type="text" name="invoice_prefix" x-model="invoicePrefix"
                                       value="{{ old('invoice_prefix', $settings->invoice_prefix ?? 'INV-') }}"
                                       placeholder="INV-"
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-mono font-bold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Example result: <span class="font-mono font-bold text-slate-700" x-text="invoicePrefix + '{{ date('Y') }}-00001'"></span></span>
                        </div>

                        <!-- Start Number -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Sequence Starting Number
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-arrow-down-1-9"></i>
                                </div>
                                <input type="number" min="1" name="start_number" x-model="startNumber"
                                       value="{{ old('start_number', $settings->start_number ?? 1) }}"
                                       placeholder="1"
                                       class="w-full text-xs sm:text-sm pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Starting index for invoice auto-generation.</span>
                        </div>
                    </div>
                </div>

                <!-- Display Preferences Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-table-columns text-blue-600"></i>
                            <span>Invoice Table Columns & Display</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Toggle optional item columns on the PDF and builder view.</p>
                    </div>

                    <div class="divide-y divide-slate-100">
                        <!-- Show Tax Column Toggle -->
                        <div class="py-3.5 flex items-center justify-between">
                            <div>
                                <label for="show_tax_column" class="text-xs sm:text-sm font-bold text-slate-900 block cursor-pointer">
                                    Show Tax Column in Line Items Table
                                </label>
                                <span class="text-[11px] text-slate-400">Display item-level tax column alongside rate and quantity.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="show_tax_column" name="show_tax_column" value="1" x-model="showTaxColumn" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <!-- Show Email Column Toggle -->
                        <div class="py-3.5 flex items-center justify-between">
                            <div>
                                <label for="show_email_column" class="text-xs sm:text-sm font-bold text-slate-900 block cursor-pointer">
                                    Show Client Email on Invoice Header
                                </label>
                                <span class="text-[11px] text-slate-400">Print customer email underneath customer name.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="show_email_column" name="show_email_column" value="1" x-model="showEmailColumn" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Live Invoice Mockup Preview -->
            <div x-show="activeTab === 'preview'" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-3xl p-6 sm:p-9 border border-slate-200/80 shadow-md">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Live Visual Feedback
                            </span>
                            <h2 class="text-xl font-black text-slate-900 mt-1.5">How your invoices will appear to clients</h2>
                        </div>
                        <span class="text-xs font-semibold text-slate-400">Interactive Mockup</span>
                    </div>

                    <!-- Mockup Paper Container -->
                    <div class="p-6 sm:p-8 bg-slate-50/80 rounded-2xl border border-slate-200/80 shadow-inner max-w-3xl mx-auto space-y-6">
                        <!-- Mockup Header -->
                        <div class="flex items-start justify-between">
                            <div class="space-y-2">
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" alt="Logo Preview" class="h-12 w-auto object-contain mb-2">
                                </template>
                                <h3 class="text-xl font-extrabold text-slate-900" x-text="companyName || 'Your Business Name'"></h3>
                                <p class="text-xs text-slate-500 whitespace-pre-line" x-text="companyAddress || '123 Business Street, Suite 100\nCity, State, Country'"></p>
                                <p class="text-xs text-slate-500">
                                    <span x-text="companyEmail || 'billing@company.com'"></span> • <span x-text="companyPhone || '+1 (555) 000-0000'"></span>
                                </p>
                            </div>

                            <div class="text-right space-y-1">
                                <span class="text-2xl font-black text-blue-600 tracking-tight uppercase">INVOICE</span>
                                <div class="font-mono text-xs font-bold text-slate-700" x-text="invoicePrefix + '{{ date('Y') }}-00001'"></div>
                                <div class="text-[11px] text-slate-400">Issue Date: {{ date('M d, Y') }}</div>
                                <div class="text-[11px] text-slate-400">Due Date: {{ date('M d, Y', strtotime('+14 days')) }}</div>
                            </div>
                        </div>

                        <!-- Mockup Item Table -->
                        <div class="border-t border-b border-slate-200/80 py-3">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-slate-400 uppercase font-bold text-[10px]">
                                        <th class="py-1">Description</th>
                                        <th class="py-1 text-center">Qty</th>
                                        <th class="py-1 text-right">Price</th>
                                        <template x-if="showTaxColumn">
                                            <th class="py-1 text-right">Tax</th>
                                        </template>
                                        <th class="py-1 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                                    <tr>
                                        <td class="py-2.5">Website Design & Development Services</td>
                                        <td class="py-2.5 text-center">1</td>
                                        <td class="py-2.5 text-right font-mono">$1,500.00</td>
                                        <template x-if="showTaxColumn">
                                            <td class="py-2.5 text-right font-mono" x-text="defaultTaxRate + '%'"></td>
                                        </template>
                                        <td class="py-2.5 text-right font-mono font-bold">$1,500.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mockup Subtotals -->
                        <div class="flex justify-end text-xs">
                            <div class="w-64 space-y-1.5 font-medium text-slate-600">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span class="font-mono text-slate-900">$1,500.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tax (<span x-text="defaultTaxRate + '%'"></span>):</span>
                                    <span class="font-mono text-slate-900" x-text="'$' + ((1500 * defaultTaxRate) / 100).toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between font-bold text-sm text-slate-900 pt-2 border-t border-slate-200">
                                    <span>Total Due (<span x-text="defaultCurrency"></span>):</span>
                                    <span class="font-mono text-blue-600" x-text="'$' + (1500 + ((1500 * defaultTaxRate) / 100)).toFixed(2)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-md flex items-center justify-between gap-4">
                <div class="text-xs text-slate-500 hidden sm:block">
                    Changes apply immediately across all invoice generators.
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('settings.edit') }}"
                       class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Reset
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 hover:shadow-lg transition-all flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                        <span>Save Preferences</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-dashboard-layout>
