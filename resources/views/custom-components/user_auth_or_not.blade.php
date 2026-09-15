@auth()
    <div class="flex items-center gap-3 sm:gap-4">
        <!-- Notifications Popover -->
        <div class="relative" id="notificationBell" v-cloak>
            <button @click="toggleDropdown"
                    type="button"
                    class="relative p-2.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all duration-150 focus:outline-none"
                    aria-label="View notifications">
                <i class="fa-regular fa-bell text-lg"></i>
                <span v-if="unread > 0"
                      class="absolute top-1.5 right-1.5 bg-rose-500 text-white text-[10px] font-extrabold rounded-full h-4 min-w-[1rem] px-1 flex items-center justify-center ring-2 ring-white animate-pulse">
                    @{{ unread }}
                </span>
            </button>

            <!-- Notifications Dropdown -->
            <div v-if="showDropdown"
                 class="absolute right-0 mt-3 w-80 sm:w-96 bg-white border border-slate-200/80 shadow-2xl rounded-2xl p-4 z-50 transition-all">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-slate-900">Notifications</span>
                        <span v-if="unread > 0" class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-50 text-blue-600">
                            @{{ unread }} new
                        </span>
                    </div>
                    <button @click="toggleDropdown" class="text-xs text-slate-400 hover:text-slate-600 font-medium">Close</button>
                </div>

                <div v-if="notifications.length === 0" class="py-8 px-4 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                        <i class="fa-regular fa-bell-slash text-lg"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">No notifications yet</p>
                    <p class="text-xs text-slate-400 mt-0.5">We'll alert you here when activity happens.</p>
                </div>

                <ul v-else class="space-y-1.5 text-sm max-h-72 overflow-y-auto scrollbar-thin pr-1">
                    <template v-for="(notif, index) in notifications" :key="index">
                        <li>
                            <a :href="notif.route || '#'"
                               class="block p-2.5 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-xs font-bold text-slate-800 line-clamp-1">@{{ notif.title }}</p>
                                    <span class="text-[10px] text-slate-400 shrink-0">@{{ formatDate(notif.created_at) }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">@{{ notif.message }}</p>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    type="button"
                    class="flex items-center gap-2.5 p-1.5 sm:px-2.5 sm:py-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none"
                    aria-label="User menu" :aria-expanded="open">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm overflow-hidden shrink-0">
                    @if(Auth::user()->profile_pic)
                        <img src="{{ Auth::user()->social_login ? Auth::user()->profile_pic : asset('storage/profile_pics/' . Auth::user()->profile_pic) }}"
                             alt="{{ Auth::user()->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <span>{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                    @endif
                </div>
                <div class="hidden md:block text-left">
                    <span class="block text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                    <span class="block text-[10px] text-slate-400 font-medium truncate max-w-[110px]">{{ Auth::user()->settings?->company_name ?? 'Personal' }}</span>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 ml-0.5"
                   :class="{'rotate-180': open}"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 @click.away="open = false"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2 z-50"
                 style="display: none;">
                <div class="px-4 py-2.5 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>

                <div class="p-1 space-y-0.5">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-colors">
                        <i class="fa-solid fa-gauge-high w-4 text-slate-400"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-colors">
                        <i class="fa-solid fa-user-gear w-4 text-slate-400"></i>
                        <span>Profile Settings</span>
                    </a>
                    <a href="{{ route('developer.api-keys') }}"
                       class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-colors">
                        <i class="fa-solid fa-code w-4 text-slate-400"></i>
                        <span>API Keys</span>
                    </a>
                    <a href="{{ route('subscription.plan') }}"
                       class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-colors">
                        <i class="fa-solid fa-gem w-4 text-slate-400"></i>
                        <span>Subscription</span>
                    </a>
                </div>

                <div class="p-1 border-t border-slate-100 mt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-xl transition-colors text-left">
                            <i class="fa-solid fa-right-from-bracket w-4"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="flex items-center gap-3">
        <x-sign-in-up/>
    </div>
@endauth

