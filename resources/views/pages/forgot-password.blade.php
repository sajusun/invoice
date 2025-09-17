<x-app-layout>
    <x-slot name="meta">
        <title>Forgot password - {{config('app.name')}}</title>
        <meta name="description"
              content="invozen app forgot password , password stolen">
        <meta name="keywords" content="forgot password, password stolen">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ route('password.request') }}">
    </x-slot>
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-primary mb-2">Forgot Password</h2>

            <x-auth-session-status class="mb-4 text-green-600 text-sm text-center" :status="session('status')" />

            <p class="text-gray-600 text-sm text-center mb-6">
                Enter your registered email to reset your password.
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600"/>
                </div>

                <!-- Submit -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-primary text-white py-2.5 px-4 rounded-lg font-medium shadow hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                    >
                        Send Reset Link
                    </button>
                </div>
            </form>

            <!-- Back to login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">
                    ← Back to Login
                </a>
            </div>
        </div>
    </div>
</x-app-layout>


