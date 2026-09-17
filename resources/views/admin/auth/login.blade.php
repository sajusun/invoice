<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Control Portal - Invozen</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-100 antialiased bg-slate-950 min-h-full flex flex-col justify-center selection:bg-indigo-500 selection:text-white py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Glow Elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-600 border border-indigo-400/30 flex items-center justify-center text-white text-2xl shadow-2xl shadow-indigo-500/30 mx-auto mb-4">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Control Portal</h1>
            <p class="text-xs text-slate-400 mt-1">Authorized personnel only &bull; Invozen Core Infrastructure</p>
        </div>

        <div class="bg-slate-900/90 border border-slate-800 backdrop-blur-xl py-8 px-6 sm:px-10 shadow-2xl shadow-black/50 rounded-3xl">
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-950/60 border border-rose-800/80 text-rose-300 text-xs font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                @csrf

                <!-- Admin Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Admin Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-xs">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-9 pr-4 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-xs sm:text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-slate-950 transition outline-none"
                               placeholder="admin@invozen.com">
                    </div>
                </div>

                <!-- Admin Password -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Secret Key / Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-xs">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                               class="w-full pl-9 pr-10 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-xs sm:text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-slate-950 transition outline-none"
                               placeholder="••••••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-300">
                            <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 rounded bg-slate-950 border-slate-700 focus:ring-indigo-500 focus:ring-offset-slate-900 cursor-pointer">
                        <span class="ml-2 text-xs text-slate-400">Keep session active</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-600 hover:from-indigo-500 hover:to-violet-500 shadow-lg shadow-indigo-600/30 transition-all cursor-pointer">
                        <i class="fa-solid fa-lock mr-2 text-xs"></i>
                        Authenticate Session
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-medium text-slate-500 hover:text-slate-300 transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Return to Main Platform
            </a>
        </div>
    </div>
</body>
</html>
