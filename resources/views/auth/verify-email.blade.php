{{--<x-guest-layout>--}}
{{--    <div class="mb-4 text-sm text-gray-600">--}}
{{--        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}--}}
{{--    </div>--}}

{{--    @if (session('status') == 'verification-link-sent')--}}
{{--        <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--            {{ __('A new verification link has been sent to the email address you provided during registration.') }}--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="mt-4 flex items-center justify-between">--}}
{{--        <form method="POST" action="{{ route('verification.send') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-primary-button>--}}
{{--                    {{ __('Resend Verification Email') }}--}}
{{--                </x-primary-button>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        <form method="POST" action="{{ route('logout') }}">--}}
{{--            @csrf--}}

{{--            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                {{ __('Log Out') }}--}}
{{--            </button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</x-guest-layout>--}}

    <!DOCTYPE html>
<html>
<head>
    <title>Email Verification Required</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; text-align: center; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; }
        .btn:hover{
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Verify Your Email Address</h2>
{{--    <p>Hello, {{ $name }}!</p>--}}
    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
        If you didn't receive the email, we will gladly send you another..</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <div>
            <button class="btn login-link">
                {{ __('Resend Verification Email') }}
            </button>
        </div>
    </form>
    <p>If you didn't create an account, you can ignore this email.</p>
    <p class="footer">This email was sent automatically. Please do not reply.</p>
</div>
</body>
</html>

