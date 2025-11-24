<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script> window.FontAwesomeConfig = { autoReplaceSvg: 'nest'};</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        ::-webkit-scrollbar { display: none;}
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .print-break { page-break-after: always; }
            body { background: white !important; }
            .shadow-lg { box-shadow: none !important; }
            .border { border: 1px solid #e5e7eb !important; }
        }
    </style>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"><style>
  .highlighted-section {
    outline: 2px solid #3F20FB;
    background-color: rgba(63, 32, 251, 0.1);
  }

  .edit-button {
    position: absolute;
    z-index: 1000;
  }

  ::-webkit-scrollbar {
    display: none;
  }

  html, body {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  </style></head>
<body class="bg-gray-50 font-sans">

    <!-- Header -->
    <header id="header" class="bg-white shadow-sm border-b no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl font-bold text-blue-600">Invozen</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-gray-900">
                        <i class="fa-solid fa-download"></i>
                        <span class="ml-2">Download PDF</span>
                    </button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fa-solid fa-envelope"></i>
                        <span class="ml-2">Send Invoice</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Invoice Preview Container -->
    <main id="invoice-preview" class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">

            <!-- Invoice Header -->
            <div id="invoice-header" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">INVOICE</h1>
                        <p class="text-blue-100">Invoice #INV-2024-001</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                            <p class="text-sm text-blue-100">Amount Due</p>
                            <p class="text-2xl font-bold">$2,450.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company & Client Info -->
            <div id="company-client-info" class="p-8 border-b">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- From Company -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">From:</h3>
                        <div class="space-y-2">
                            <p class="font-semibold text-gray-900">TechSolutions Inc.</p>
                            <p class="text-gray-600">123 Business Street</p>
                            <p class="text-gray-600">San Francisco, CA 94105</p>
                            <p class="text-gray-600">contact@techsolutions.com</p>
                            <p class="text-gray-600">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <!-- To Client -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To:</h3>
                        <div class="space-y-2">
                            <p class="font-semibold text-gray-900">Acme Corporation</p>
                            <p class="text-gray-600">456 Client Avenue</p>
                            <p class="text-gray-600">New York, NY 10001</p>
                            <p class="text-gray-600">billing@acmecorp.com</p>
                            <p class="text-gray-600">+1 (555) 987-6543</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div id="invoice-details" class="p-8 border-b">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Invoice Date</p>
                        <p class="font-semibold text-gray-900">January 15, 2024</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Due Date</p>
                        <p class="font-semibold text-red-600">February 14, 2024</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Payment Terms</p>
                        <p class="font-semibold text-gray-900">Net 30</p>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div id="invoice-items" class="p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Items &amp; Services</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">Description</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700 w-20">Qty</th>
                                <th class="text-right py-3 px-2 font-semibold text-gray-700 w-24">Rate</th>
                                <th class="text-right py-3 px-2 font-semibold text-gray-700 w-28">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-4 px-2">
                                    <div>
                                        <p class="font-medium text-gray-900">Website Development</p>
                                        <p class="text-sm text-gray-600">Custom responsive website with CMS integration</p>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center">1</td>
                                <td class="py-4 px-2 text-right">$1,500.00</td>
                                <td class="py-4 px-2 text-right font-medium">$1,500.00</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2">
                                    <div>
                                        <p class="font-medium text-gray-900">SEO Optimization</p>
                                        <p class="text-sm text-gray-600">On-page SEO and performance optimization</p>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center">1</td>
                                <td class="py-4 px-2 text-right">$500.00</td>
                                <td class="py-4 px-2 text-right font-medium">$500.00</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2">
                                    <div>
                                        <p class="font-medium text-gray-900">Maintenance Package</p>
                                        <p class="text-sm text-gray-600">3 months of website maintenance and updates</p>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center">3</td>
                                <td class="py-4 px-2 text-right">$150.00</td>
                                <td class="py-4 px-2 text-right font-medium">$450.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals -->
            <div id="invoice-totals" class="px-8 pb-8">
                <div class="flex justify-end">
                    <div class="w-80">
                        <div class="space-y-2">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">$2,450.00</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Tax (0%):</span>
                                <span class="font-medium">$0.00</span>
                            </div>
                            <div class="flex justify-between py-3 border-t-2 border-gray-300">
                                <span class="text-lg font-semibold text-gray-900">Total:</span>
                                <span class="text-xl font-bold text-blue-600">$2,450.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div id="payment-info" class="bg-gray-50 p-8 border-t">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Payment Information</h4>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-medium">Bank:</span> Chase Bank</p>
                            <p><span class="font-medium">Account:</span> 1234567890</p>
                            <p><span class="font-medium">Routing:</span> 021000021</p>
                            <p><span class="font-medium">Swift:</span> CHASUS33</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Payment Methods</h4>
                        <div class="flex space-x-4">
                            <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded border">
                                <i class="fa-brands fa-cc-visa text-blue-600"></i>
                                <span class="text-sm">Card</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded border">
                                <i class="fa-brands fa-paypal text-blue-600"></i>
                                <span class="text-sm">PayPal</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded border">
                                <i class="fa-solid fa-university text-blue-600"></i>
                                <span class="text-sm">Bank</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div id="invoice-notes" class="p-8 border-t">
                <h4 class="font-semibold text-gray-900 mb-3">Notes</h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Thank you for your business! Payment is due within 30 days of invoice date.
                    Please include the invoice number on your payment. For any questions regarding
                    this invoice, please contact us at billing@techsolutions.com or call (555) 123-4567.
                </p>
            </div>

            <!-- Footer -->
            <div id="invoice-footer" class="bg-gray-100 p-6 text-center">
                <p class="text-sm text-gray-600">
                    This invoice was generated by Invozen - Smart Invoicing Made Simple
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    www.invozen.com | support@invozen.com
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div id="action-buttons" class="mt-6 flex justify-center space-x-4 no-print">
            <button onclick="window.print()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 flex items-center">
                <i class="fa-solid fa-print mr-2"></i>
                Print Invoice
            </button>
            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fa-solid fa-download mr-2"></i>
                Download PDF
            </button>
            <button class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 flex items-center">
                <i class="fa-solid fa-edit mr-2"></i>
                Edit Invoice
            </button>
        </div>
    </main>


</body></html>
