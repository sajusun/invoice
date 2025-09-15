<x-guest-layout>
    <x-slot name="head">
        <title>Signup to Invozen - Create Your Free Account</title>
        <meta name="description"
              content="Join Invozen today and streamline your invoicing process. Sign up for free and start creating invoices in seconds.">
        <meta name="keywords" content="sign up, invozen register, create account, free invoicing">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="https://www.invozen.com/register">
    </x-slot>
    <x-slot name="header"></x-slot>

        <div class="auth-container flex items-center justify-center py-12 px-4">
            <div id="registration-form" class="w-full max-w-lg auth-card bg-white px-8 pt-4 pb-8">
                <div class="text-center m-0">
{{--                    <div--}}
{{--                        class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-1">--}}
{{--                        <i class="fa-solid fa-user-plus text-white text-xl"></i>--}}
{{--                    </div>--}}
                    <h1 class="text-3xl font-bold text-primary">{{config('app.name', 'Laravel')}}</h1>
                    <p class="text-gray-600 mt-1">Create your account</p>
                </div>
                <div class="border-b my-4"></div>
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif
                <form id="registration-form-fields" action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input name="name" type="text"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200"
                               placeholder="John Smith" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200"
                               placeholder="john@example.com" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <select name="country" required class="w-full border px-3 py-2 rounded mt-1 cursor-pointer">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option class="cursor-pointer p-2"
                                        value="{{$country['name']}}">{{$country['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200 pr-12"
                                   placeholder="••••••••" required>
                            <button type="button" id="togglePassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="confirmPassword" name="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200 pr-12"
                                   placeholder="••••••••" required>
                            <button type="button" id="toggleConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" class="mt-1 mr-3 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label class="text-sm text-gray-600">
                            I agree to the <span
                                class="text-blue-600 hover:underline cursor-pointer">Terms of Service</span> and <span
                                class="text-blue-600 hover:underline cursor-pointer">Privacy Policy</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                        Create Account
                    </button>

                    <div class="text-center">
                        <span class="text-gray-600">Already have an account? </span>
                        <a href="{{ route('login') }}">
                            <span class="text-blue-600 hover:underline font-medium cursor-pointer">Sign in</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle eye icon
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });

            toggleConfirmPassword.addEventListener('click', function () {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                // Toggle eye icon
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });

            // // Form validation
            // const form = document.getElementById('registration-form-fields');
            // const errorDiv = document.getElementById('error-message');
            //
            // form.addEventListener('submit', function(e) {
            //     e.preventDefault();
            //
            //     // Get form values
            //     const name = form.elements['name'].value;
            //     const email = form.elements['email'].value;
            //     const country = form.elements['country'].value;
            //     const password = form.elements['password'].value;
            //     const confirmPassword = form.elements['password_confirmation'].value;
            //     const terms = document.getElementById('terms').checked;
            //
            //     // Reset error message
            //     errorDiv.classList.add('hidden');
            //
            //     // Validation checks
            //     if (!name || !email || !country || !password || !confirmPassword) {
            //         showError('Please fill in all fields');
            //         return;
            //     }
            //
            //     if (password !== confirmPassword) {
            //         showError('Passwords do not match');
            //         return;
            //     }
            //
            //     if (password.length < 8) {
            //         showError('Password must be at least 8 characters long');
            //         return;
            //     }
            //
            //     if (!terms) {
            //         showError('You must agree to the Terms of Service and Privacy Policy');
            //         return;
            //     }
            //
            //     // If all validations pass
            //     // alert('Registration successful! (This is a demo)');
            //     form.reset();
            // });
            //
            // function showError(message) {
            //     errorDiv.querySelector('p').textContent = message;
            //     errorDiv.classList.remove('hidden');
            //
            //     // Scroll to error message
            //     errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // }
        });
    </script>
</x-guest-layout>

