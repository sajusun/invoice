<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold text-primary mb-4">Invozen</h3>
                <p class="text-gray-400 mb-4">Smart invoicing made simple for businesses of all sizes.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fa-brands fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fa-brands fa-facebook text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fa-brands fa-linkedin text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Product</h4>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                    <li><a href="#pricing" class="text-gray-400 hover:text-white transition-colors">Pricing</a></li>
                    <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-colors">Templates</a></li>
                    <li><a href="{{route('integrations')}}" class="text-gray-400 hover:text-white transition-colors">Integrations</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Resources</h4>
                <ul class="space-y-2">
                    <li><a href="{{route('blog')}}" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{route('guides')}}" class="text-gray-400 hover:text-white transition-colors">Guides</a></li>
                    <li><a href="{{route('support')}}" class="text-gray-400 hover:text-white transition-colors">Support</a></li>
                    <li><a href="{{route('api-docs')}}" class="text-gray-400 hover:text-white transition-colors">API Docs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Company</h4>
                <ul class="space-y-2">
                    <li><a href="{{route('about')}}" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{route('careers')}}" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                    <li><a href="{{route('contact.form')}}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="{{route('pp')}}" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="{{route('t&c')}}" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 Invozen. All rights reserved.</p>
            <div class="flex items-center space-x-6">
                <span class="text-gray-400 text-sm">Accepted payment methods:</span>
                <div class="flex space-x-2">
                    <i class="fa-brands fa-cc-visa text-gray-400"></i>
                    <i class="fa-brands fa-cc-mastercard text-gray-400"></i>
                    <i class="fa-brands fa-cc-amex text-gray-400"></i>
                    <i class="fa-brands fa-cc-paypal text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
