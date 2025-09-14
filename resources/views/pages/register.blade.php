{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    @include('custom-layouts.headTagContent')--}}
{{--    <title>Sign Up for Invozen - Create Your Free Account</title>--}}
{{--    <meta name="description" content="Join Invozen today and streamline your invoicing process. Sign up for free and start creating invoices in seconds.">--}}
{{--    <meta name="keywords" content="sign up, invozen register, create account, free invoicing">--}}
{{--    <meta name="robots" content="index, follow">--}}
{{--    <link rel="canonical" href="https://www.invozen.com/register">--}}
{{--</head>--}}
{{--<body class="w-screen h-screen">--}}
{{--<div class="h-full bg-gray-100 flex items-center justify-center">--}}
{{--<div class="max-w-lg w-full p-8  bg-white shadow-md rounded-lg">--}}
{{--    <div class="text-xl font-bold text-gray-800 text-center border-b pb-4 ">Create an account</div>--}}
{{--    @if ($errors->any())--}}
{{--        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">--}}
{{--            <p>{{ $errors->first() }}</p>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <form action="{{ route('register') }}" method="POST" class="space-y-2 pt-3">--}}
{{--        @csrf--}}
{{--        <div>--}}
{{--            <label class="block text-gray-700">Full Name</label>--}}
{{--            <input type="text" name="name" required class="w-full border px-3 py-2 rounded mt-1" value="{{old('name')}}">--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <label class="block text-gray-700">Email</label>--}}
{{--            <input type="email" name="email" required class="w-full border px-3 py-2 rounded mt-1" value="{{old('email')}}">--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <label class="block text-gray-700">Country</label>--}}
{{--            <select name="country" required class="w-full border px-3 py-2 rounded mt-1 cursor-pointer">--}}
{{--                <option value="">Select Country</option>--}}
{{--                @foreach($countries as $country)--}}
{{--                    <option class="cursor-pointer p-2" value="{{$country['name']}}">{{$country['name']}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <label class="block text-gray-700">Preferred Currency</label>--}}
{{--            <select name="currency" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--                <option value="">Select Currency</option>--}}
{{--                <option value="USD">USD ($)</option>--}}
{{--                <option value="BDT">BDT (৳)</option>--}}
{{--                <option value="INR">INR (₹)</option>--}}
{{--                <option value="GBP">GBP (£)</option>--}}
{{--                <option value="EUR">EUR (€)</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <label class="block text-gray-700">Password</label>--}}
{{--            <input type="password" name="password" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <label class="block text-gray-700">Confirm Password</label>--}}
{{--            <input type="password" name="password_confirmation" required class="w-full border px-3 py-2 rounded mt-1">--}}
{{--        </div>--}}
{{--        <div class="h-min">--}}
{{--            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 mt-4 rounded">Sign Up</button>--}}

{{--        </div>--}}
{{--    </form>--}}
{{--  <div class="my-2 py-2 w-full text-right">--}}
{{--      <a href="{{ route('login') }}" class="text-blue-500 text-sm">Already have an account? Login</a>--}}
{{--  </div>--}}
{{--    --}}
{{--</body>--}}
{{--</html>--}}
    <!-- Registration Form -->
<x-user-layout>
<div class="p-8 shadow-md rounded-lg">
<div class="bg-gray-100 flex items-center justify-center w-screen">
    <div id="registration-form" class="bg-white rounded-2xl form-shadow p-8 mb-8 w-full max-w-lg">
        <div id="registration-header" class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-user-plus text-white text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Your Account</h2>
            <p class="text-gray-600">Join thousands of businesses using Invozen</p>
        </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif
        <!-- Error message placeholder -->
{{--        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden">--}}
{{--            <p>Error message will appear here</p>--}}
{{--        </div>--}}
        <form id="registration-form-fields" action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input name="name" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200" placeholder="John Smith" required>
                </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200" placeholder="john@example.com" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                <select name="country" required class="w-full border px-3 py-2 rounded mt-1 cursor-pointer">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option class="cursor-pointer p-2" value="{{$country['name']}}">{{$country['name']}}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200 pr-12" placeholder="••••••••" required>
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition-all duration-200 pr-12" placeholder="••••••••" required>
                    <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label class="text-sm text-gray-600">
                    I agree to the <span class="text-blue-600 hover:underline cursor-pointer">Terms of Service</span> and <span class="text-blue-600 hover:underline cursor-pointer">Privacy Policy</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg
                    font-semibold hover:opacity-90 transition-all duration-200 transform hover:scale-105">
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
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            togglePassword.addEventListener('click', function() {
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

            toggleConfirmPassword.addEventListener('click', function() {
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
</x-user-layout>

