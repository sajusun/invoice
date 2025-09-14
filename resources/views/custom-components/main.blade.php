<div class="main bg-gray-50 p-6 overflow-y-auto">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                    <i class="fa-solid fa-receipt text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Invoices</p>
                    <h3 class="text-2xl font-bold text-gray-900">142</h3>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 12% from last month
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-secondary mr-4">
                    <i class="fa-solid fa-money-bill-wave text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900">$12,845</h3>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 8% from last month
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-amber-100 text-accent mr-4">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pending Invoices</p>
                    <h3 class="text-2xl font-bold text-gray-900">8</h3>
                </div>
            </div>
            <p class="text-xs text-red-600 mt-2"><i class="fa-solid fa-arrow-down mr-1"></i> 2% from last month
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Active Clients</p>
                    <h3 class="text-2xl font-bold text-gray-900">42</h3>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up mr-1"></i> 5% from last month
            </p>
        </div>
    </div>

    <!-- Charts and Recent Invoices -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Overview</h3>
                <select
                    class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:border-primary">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Recent Invoices</h3>
                <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium">View all</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">INV-0032</p>
                        <p class="text-sm text-gray-600">Web Design</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">$1,200</p>
                        <p class="text-xs text-green-600">Paid</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">INV-0031</p>
                        <p class="text-sm text-gray-600">SEO Service</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">$2,500</p>
                        <p class="text-xs text-amber-600">Pending</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">INV-0030</p>
                        <p class="text-sm text-gray-600">App Development</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">$4,800</p>
                        <p class="text-xs text-green-600">Paid</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">INV-0029</p>
                        <p class="text-sm text-gray-600">Consulting</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">$1,800</p>
                        <p class="text-xs text-red-600">Overdue</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Overview and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Client Overview -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Client Overview</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-indigo-100 text-primary flex items-center justify-center font-semibold mr-3">
                            AC
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Acme Corp</p>
                            <p class="text-sm text-gray-600">3 invoices</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-semibold mr-3">
                            GS
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Globex Solutions</p>
                            <p class="text-sm text-gray-600">5 invoices</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold mr-3">
                            WI
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Wayne Industries</p>
                            <p class="text-sm text-gray-600">2 invoices</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Inactive</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="#"
                   class="flex flex-col items-center justify-center p-4 bg-indigo-50 rounded-lg text-primary hover:bg-indigo-100 transition-colors">
                    <i class="fa-solid fa-plus text-2xl mb-2"></i>
                    <span class="text-sm font-medium">New Invoice</span>
                </a>
                <a href="#"
                   class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg text-secondary hover:bg-green-100 transition-colors">
                    <i class="fa-solid fa-user-plus text-2xl mb-2"></i>
                    <span class="text-sm font-medium">Add Client</span>
                </a>
                <a href="#"
                   class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg text-accent hover:bg-amber-100 transition-colors">
                    <i class="fa-solid fa-file-export text-2xl mb-2"></i>
                    <span class="text-sm font-medium">Export Data</span>
                </a>
                <a href="#"
                   class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg text-purple-600 hover:bg-purple-100 transition-colors">
                    <i class="fa-solid fa-chart-pie text-2xl mb-2"></i>
                    <span class="text-sm font-medium">Reports</span>
                </a>
            </div>
        </div>
    </div>
</div>
