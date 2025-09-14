

<!-- Right side -->
<div class="flex items-center space-x-4">
    @auth()
        <!-- User dropdown container -->
        <div class="relative" x-data="{ open: false }">
            <!-- Dropdown trigger button -->
            <div @click="open = !open"
                 class="flex items-center space-x-2 focus:outline-none cursor-pointer"
                 aria-label="User menu"
                 aria-haspopup="true"
                 :aria-expanded="open">
                <!-- User avatar -->
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                    @if(Auth::user()->social_login)
                        <img src="{{Auth::user()->profile_pic}}" alt="Thumbnail">

                    @else
                    <img src="{{ Auth::user()->profile_pic ? asset('storage/profile_pics/' . Auth::user()->profile_pic) : asset('storage/' . 'profile_pics/profile.png')}}" alt="Thumbnail">
                    @endif

                </div>
                <!-- User name (hidden on mobile) -->
                <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name}}</span>
                <!-- Chevron icon -->
                <i class="fas fa-angle-down w-4 mr-2" :class="{'transform rotate-180': open}"> </i>
            </div>

            <!-- Dropdown menu -->
            <div
                x-show="open"
                @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                style="display: none;"
            >
                <!-- User info -->
                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name}}</p>
                    <p class="text-xs text-gray-500 truncate">{{Auth::user()->email}}</p>
                </div>
                <!-- Dropdown items -->
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <i class="fas fa-dashboard w-4 mr-2"> </i>
                    Dashboard
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <i class="fas fa-user w-4 mr-2"> </i>
                    Profile
                </a>

                <a href="{{ route('settings.edit') }}"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <i class="fas fa-cog w-4 mr-2"> </i>
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm
                text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="fas fa-sign-out w-4 mr-2"> </i>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    @else
        <div>
            <a href="/login"
               class="px-3 py-2 text-xs mx-1.5 md:px-4 md:py-2 md:text-sm font-bold
               color-main rounded-md md:mx-2">Sigh In</a>

            <a href="/register"
               class="px-3 py-2 mx-1.5 text-xs md:px-4 md:py-2
               md:text-sm bg-color-main font-semibold text-white rounded-md md:mx-2 ">Sigh Up</a>
        </div>
    @endauth
</div>
