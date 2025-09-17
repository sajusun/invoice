
<x-app-layout>
{{--<div class="form-container">--}}
{{--    <h2 class="color-main">Reset Password</h2>--}}
{{--    <form method="POST" action="{{ route('password.store') }}">--}}
{{--        @csrf--}}
{{--        <!-- Password Reset Token -->--}}
{{--        <input type="hidden" name="token" value="{{ $request->route('token') }}">--}}
{{--        <input type="email" readonly name="email" value="{{old('email', $request->email)}}" required autofocus--}}
{{--               autocomplete="username">--}}
{{--        <x-input-error :messages="$errors->get('email')" class="error-mgs"/>--}}
{{--        <input type="password" name="password" placeholder="New Password" required>--}}
{{--        <x-input-error :messages="$errors->get('password')" class="error-mgs"/>--}}
{{--        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>--}}
{{--        <x-input-error :messages="$errors->get('password_confirmation')" class="error-mgs"/>--}}
{{--        <button type="submit" class="login">Reset Password</button>--}}
{{--    </form>--}}
{{--</div>--}}

    <div class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-primary mb-6">Reset Password</h2>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        readonly
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600"/>
                </div>

                <!-- New Password -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative mt-1">
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm pr-10"
                        >
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-primary">
                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600"/>
                </div>

                <!-- Confirm Password -->
                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="relative mt-1">
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="••••••••"
                            required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm pr-10"
                        >
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-primary">
                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600"/>
                </div>

                <!-- Submit -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-primary text-white py-2.5 px-4 rounded-lg font-medium shadow hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                    >
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>

