@auth()
    <div class="flex items-center space-x-8">
        <div  class="relative" id="notificationBell" v-cloak>
            <button @click="toggleDropdown" class="relative text-gray-600 hover:text-gray-900">
                <i class="fa-solid fa-bell text-lg"></i>
                <span id="notif_count"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">@{{ unread }}</span>
            </button>
            <div v-if="showDropdown"
{{--                 @click.away="open = false"--}}
                 class="absolute top-full mt-2 right-1/2 translate-x-1/2 w-72 bg-white shadow-lg rounded-xl p-4 z-50 ">
                <p class="text-sm font-semibold mb-3">Notifications</p>
                <div v-if="notifications.length === 0" class="p-4 text-gray-500 text-center">
                    No notifications yet.
                </div>
                <ul id="notif_list" v-else
                    class="space-y-2 text-sm text-gray-700 max-h-60 overflow-y-auto scrollbar-thin">
                    <template v-for="(notif, index) in notifications" :key="index">
                        <li class="p-2 hover:bg-gray-50 rounded">
                            <a :href='notif.route'>
                                <p class="text-sm font-semibold text-gray-600">@{{ notif.title }}</p>
                                <p class="text-sm text-gray-500">@{{ notif.message }}</p>
                                <p class="text-xs text-gray-500">@{{ formatDate(notif.created_at) }}</p>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <div class="relative">
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }">
                    <div @click="open = !open"
                         class="flex items-center space-x-2 focus:outline-none cursor-pointer"
                         aria-label="User menu" aria-haspopup="true" :aria-expanded="open">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->social_login)
                                <img src="{{Auth::user()->profile_pic}}" alt="Thumbnail">
                            @else
                                <img
                                    src="{{ Auth::user()->profile_pic ? asset('storage/profile_pics/' . Auth::user()->profile_pic) : asset('storage/' . 'profile_pics/profile.png')}}"
                                    alt="Thumbnail">
                            @endif

                        </div>
                        <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name}}</span>
                        <i class="fas fa-angle-down w-4 mr-2" :class="{'transform rotate-180': open}"> </i>
                    </div>
                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                         style="display: none;">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name}}</p>
                            <p class="text-xs text-gray-500 truncate">{{Auth::user()->email}}</p>
                        </div>
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-dashboard w-4 mr-2"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}"
                           class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-user w-4 mr-2"></i>
                            Profile
                        </a>

                        <a href="{{ route('settings.edit') }}"
                           class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-cog w-4 mr-2"> </i>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-sign-out w-4 mr-2"> </i>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="flex items-center space-x-4">
        <x-sign-in-up/>
    </div>
@endauth
