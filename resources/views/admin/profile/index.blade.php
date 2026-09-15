<x-admin-layout>
    <x-slot name="title">Admin Profile & Security Settings</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-8">
        <!-- 1. Admin Profile Hero Card -->
        <div class="bg-gradient-to-r from-rose-600 via-rose-700 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-rose-900/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative group cursor-pointer" onclick="document.getElementById('adminProfilePicInput').click()">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/20 backdrop-blur-md p-1 border-2 border-white/30 shadow-lg overflow-hidden shrink-0">
                        @if($user->profile_pic)
                            <img id="adminProfileHeaderImg"
                                 src="{{ asset('storage/profile_pics/' . $user->profile_pic) }}"
                                 alt="{{ $user->name }}"
                                 class="w-full h-full object-cover rounded-xl">
                        @else
                            <div id="adminProfileHeaderFallback" class="w-full h-full rounded-xl bg-rose-500 flex items-center justify-center text-white font-extrabold text-2xl sm:text-3xl">
                                {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-bold gap-1">
                        <i class="fa-solid fa-camera"></i> Change
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $user->name }}</h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-400/20 text-rose-200 border border-rose-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-pulse"></span> Super Admin
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-slate-100 border border-white/20">
                            ID: #{{ $user->id }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-rose-100/80 flex items-center gap-2">
                        <i class="fa-regular fa-envelope"></i> {{ $user->email }}
                        <span class="text-white/40">•</span>
                        <i class="fa-solid fa-shield-halved"></i> Platform Administrator
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 shadow-sm transition-all">
                    <i class="fa-solid fa-chart-pie"></i> View Overview
                </a>
            </div>
        </div>

        <!-- 2. Status Alerts -->
        @if (session('status') === 'profile-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>Admin profile details updated successfully!</span>
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>Admin security password updated successfully!</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 3. Personal Information Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Administrator Credentials</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Update administrator name, email and avatar photo.</p>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                </div>

                <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('patch')

                    <!-- Photo Upload Area -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Avatar Picture</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                <img id="adminPreviewAvatar"
                                     src="{{ $user->profile_pic ? asset('storage/profile_pics/' . $user->profile_pic) : asset('storage/profile_pics/profile.png') }}"
                                     alt="Preview"
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <input type="file" name="profile_pic" id="adminProfilePicInput" accept="image/*" class="hidden" onchange="handleAdminAvatarPreview(event)">
                                <button type="button" onclick="document.getElementById('adminProfilePicInput').click()"
                                        class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors cursor-pointer">
                                    <i class="fa-solid fa-upload mr-1.5 text-slate-500"></i> Select New Avatar
                                </button>
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG or WEBP up to 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Admin Full Name</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               placeholder="Administrator Name"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Admin Email Address</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               placeholder="admin@invozen.com"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-rose-500/20 hover:shadow-md transition-all cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i> Save Admin Details
                        </button>
                    </div>
                </form>
            </div>

            <!-- 4. Security & Password Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Admin Security & Password</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Protect admin panel access with a strong master password.</p>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <form method="post" action="{{ route('admin.password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 mb-1.5">Current Password</label>
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               required
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">New Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Confirm New Password</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                    </div>

                    <div class="pt-3 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer">
                            <i class="fa-solid fa-key text-rose-400"></i> Update Security Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Photo Preview Script -->
    <script>
        function handleAdminAvatarPreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('adminPreviewAvatar');
                    const headerImg = document.getElementById('adminProfileHeaderImg');
                    if (preview) preview.src = e.target.result;
                    if (headerImg) headerImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin-layout>
