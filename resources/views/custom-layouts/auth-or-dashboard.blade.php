<section class="auth justify-items-end">
    <div>
        @auth()

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown">
                            <img src="https://cdn-icons-png.flaticon.com/256/5828/5828115.png" alt="User" width="30"
                                 height="30" class="rounded-circle"> Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="/invoices">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{route('logout')}}"
                                       onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form></li>
                        </ul>
                    </li>
                </ul>

        @else


                <li><a href="/login" class="login-link">Sigh In</a></li>
                <li><a href="/register" class="register-link">Sigh Up</a></li>
    </div>
    @endauth
</section>
