
   <head>
       <title>App Setting</title>
       @include('custom-layouts.headTagContent')
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   </head>
   <body>
   @include('custom-layouts.navbar')

   <div class="max-w-2xl mx-auto px-4 py-6">
       <h1 class="text-2xl font-bold text-gray-800 mb-6"></h1>

       @if (session('success'))
           <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
               {{ session('success') }}
           </div>
       @endif

       <form method="POST" action="{{ route('settings.update') }}" class="space-y-5">
           @csrf

           <div>
               <label class="block font-semibold text-sm text-gray-700">Company Name</label>
               <input type="text" name="company_name" value="{{$settings->company_name ?? ''}}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400"
                      required>
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Company Email</label>
               <input type="email" name="company_email"
                      value="{{ old('company_email', $settings->company_email ?? '') }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md">
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Company Phone</label>
               <input type="text" name="company_phone"
                      value="{{ old('company_phone', $settings->company_phone ?? '') }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md">
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Company Address</label>
               <textarea name="company_address"
                         class="w-full mt-1 p-2 border border-gray-300 rounded-md">{{ old('company_address', $settings->company_address ?? '') }}</textarea>
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Default Currency</label>
               <input type="text" name="default_currency"
                      value="{{ old('default_currency', $settings->default_currency ?? 'USD') }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Default Tax Rate (%)</label>
               <input type="number" step="0.01" name="default_tax_rate"
                      value="{{ old('default_tax_rate', $settings->default_tax_rate ?? '') }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md">
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Invoice Prefix</label>
               <input type="text" name="invoice_prefix"
                      value="{{ old('invoice_prefix', $settings->invoice_prefix ?? '') }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md">
           </div>

           <div>
               <label class="block font-semibold text-sm text-gray-700">Start Number</label>
               <input type="number" name="start_number" value="{{ old('start_number', $settings->start_number ?? 1) }}"
                      class="w-full mt-1 p-2 border border-gray-300 rounded-md">
           </div>

           <div class="flex items-center space-x-2">
               <input type="hidden" name="show_tax_column" value="0">

               <input type="checkbox" id="show_tax_column" name="show_tax_column"
                      value="{{$settings->show_tax_column}}"
                      {{ old('show_tax_column', $settings->show_tax_column ?? true) ? 'checked' : '' }}
                      class="h-4 w-4 text-blue-600 border-gray-300 rounded">
               <label class="text-sm text-gray-700" for="show_tax_column">Show Tax Column Default in Invoice</label>
           </div>
           <div class="flex items-center space-x-2">
               <input type="hidden" name="show_email_column" value="0">

               <input type="checkbox" id="show_email_column" name="show_email_column"
                      value="{{$settings->show_email_column}}"
                      {{ old('show_tax_column', $settings->show_email_column ?? true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label class="text-sm text-gray-700" for="show_email_column">Show Email Column Default in Invoice</label>
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
   @include('custom-layouts.footer')
   </body>

   <script>
       document.getElementById('show_tax_column').addEventListener('change', function () {
           this.value = this.checked ? 1 : 0;
       });
       document.getElementById('show_email_column').addEventListener('change', function () {
           this.value = this.checked ? 1 : 0;
       });
   </script>
