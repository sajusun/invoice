
<x-dashboard-layout>
    <x-slot name="title">Account & Profile Settings - {{ $user->name }}</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8" x-data="{ openDeleteModal: false }">
        <!-- 1. Profile Hero Card -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-slate-800 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-500/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative group cursor-pointer" onclick="document.getElementById('profilePicInput').click()">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/20 backdrop-blur-md p-1 border-2 border-white/30 shadow-lg overflow-hidden shrink-0">
                        @if($user->profile_pic)
                            <img id="profileHeaderImg"
                                 src="{{ $user->social_login ? $user->profile_pic : asset('storage/profile_pics/' . $user->profile_pic) }}"
                                 alt="{{ $user->name }}"
                                 class="w-full h-full object-cover rounded-xl">
                        @else
                            <div id="profileHeaderFallback" class="w-full h-full rounded-xl bg-blue-500/80 flex items-center justify-center text-white font-extrabold text-2xl sm:text-3xl">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
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
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Active
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-blue-100 border border-white/20">
                            {{ $user->plan?->name ?? 'Free Tier' }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-blue-100/80 flex items-center gap-2">
                        <i class="fa-regular fa-envelope"></i> {{ $user->email }}
                        <span class="text-white/40">•</span>
                        <i class="fa-regular fa-calendar"></i> Member since {{ $user->created_at?->format('M Y') ?? 'Recent' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('subscription.plan') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-blue-700 hover:bg-blue-50 text-xs font-bold rounded-xl shadow-md transition-all">
                    <i class="fa-solid fa-gem text-blue-600"></i> Manage Plan
                </a>
            </div>
        </div>

        <!-- 2. Status Alerts -->
        @if (session('status') === 'profile-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3 animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>Profile information updated successfully!</span>
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3 animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>Password changed successfully!</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 3. Personal Information Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Personal Information</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Update your account photo, name, and email address.</p>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('patch')

                    <!-- Photo Upload Area -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Profile Avatar</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                <img id="previewAvatar"
                                     src="{{ $user->profile_pic ? ($user->social_login ? $user->profile_pic : asset('storage/profile_pics/' . $user->profile_pic)) : asset('storage/profile_pics/profile.png') }}"
                                     alt="Preview"
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" class="hidden" onchange="handleAvatarPreview(event)">
                                <button type="button" onclick="document.getElementById('profilePicInput').click()"
                                        class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors cursor-pointer">
                                    <i class="fa-solid fa-upload mr-1.5 text-slate-500"></i> Upload New Photo
                                </button>
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, or WEBP up to 2MB.</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('profile_pic')" class="mt-1" />
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Full Name</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               placeholder="Enter your full name"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               placeholder="your.email@example.com"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 hover:shadow-md transition-all cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- 4. Security & Password Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Security & Password</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Ensure your account uses a long, random password.</p>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 mb-1.5">Current Password</label>
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">New Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Confirm New Password</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="••••••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                    </div>

                    <div class="pt-3 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-indigo-500/20 hover:shadow-md transition-all cursor-pointer">
                            <i class="fa-solid fa-key"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 5. Danger Zone -->
        <div class="bg-rose-50/60 rounded-2xl p-6 sm:p-8 border border-rose-200/80 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-rose-900 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        Danger Zone: Delete Account
                    </h3>
                    <p class="text-xs text-rose-700/80 max-w-xl">
                        Once your account is deleted, all invoices, clients, webhooks, and data will be permanently wiped. This action cannot be reversed.
                    </p>
                </div>
                <button @click="openDeleteModal = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all shrink-0 cursor-pointer">
                    <i class="fa-solid fa-trash-can"></i> Delete Account
                </button>
            </div>
        </div>

        <!-- 6. Account Deletion Confirmation Modal -->
        <div x-show="openDeleteModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.outside="openDeleteModal = false"
                 x-show="openDeleteModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 space-y-5">
                
                <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center text-xl mx-auto">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="text-center space-y-1">
                    <h3 class="text-lg font-black text-slate-900">Are you absolutely sure?</h3>
                    <p class="text-xs text-slate-500">
                        Please enter your account password to confirm permanent deletion of your Invozen account.
                    </p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="delete_password" class="block text-xs font-bold text-slate-700 mb-1">Confirm Password</label>
                        <input type="password"
                               id="delete_password"
                               name="password"
                               required
                               placeholder="Enter your password to confirm"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button"
                                @click="openDeleteModal = false"
                                class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-500/20 transition-all cursor-pointer">
                            Confirm Deletion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Photo Preview Script -->
    <script>
        function handleAvatarPreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('previewAvatar');
                    const headerImg = document.getElementById('profileHeaderImg');
                    if (preview) preview.src = e.target.result;
                    if (headerImg) headerImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-dashboard-layout>


