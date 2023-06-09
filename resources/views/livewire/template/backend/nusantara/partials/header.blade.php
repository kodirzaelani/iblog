<div>
    @auth
        @php
            $currentUser = Auth::user();
        @endphp
    @endauth
    <header class="main-header">
        <div class="d-flex align-items-center logo-box justify-content-start">
            <a href="#"
                class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent"
                data-toggle="push-menu" role="button">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <!-- Logo -->
            <a href="{{ route('backend.dashboard') }}" class="logo">
                <div class="logo-lg">
                    @if ($global_option != '0')
                        @if ($global_option->logo_menu)
                            <span class="light-logo"><img
                                    src="{{ asset('') }}uploads/images/logo/{{ $global_option->logo_menu }}"
                                    alt="{{ config('app.name', 'App Web') }}" style="max-width: 60%" /></span>
                            <span class="dark-logo"><img
                                    src="{{ asset('') }}uploads/images/logo/{{ $global_option->logo_menu }}"
                                    alt="{{ config('app.name', 'App Web') }}" style="max-width: 60%" /></span>
                        @else
                            <span class="light-logo"><img src="{{ asset('') }}uploads/default/logobpic.png"
                                    alt="{{ config('app.name', 'App Web') }}" style="max-width: 70%" /></span>
                            <span class="dark-logo"><img src="{{ asset('') }}uploads/default/logobpic.png"
                                    alt="{{ config('app.name', 'App Web') }}" style="max-width: 70%" /></span>
                        @endif
                    @endif
                    <!-- logo-->
                </div>
            </a>
        </div>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top ">
            <!-- Sidebar toggle button-->
            <div class="app-menu">
                <ul class="header-megamenu nav">
                    <li class="btn-group nav-item d-md-none">
                        <a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu"
                            role="button">
                            <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span
                                    class="path3"></span></span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="navbar-custom-menu r-side">
                <ul class="nav navbar-nav">
                    <li class="btn-group nav-item d-lg-inline-flex d-none">
                        <a href="#" data-provide="fullscreen"
                            class="waves-effect waves-light nav-link full-screen" title="Full Screen">
                            <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                        </a>
                    </li>

                    <!-- User Account-->
                    <li class="dropdown user user-menu">

                        <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown"
                            title="{{ $currentUser->name }}">
                            <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                        </a>
                        <ul class="dropdown-menu animated flipInX">
                            <li class="user-body">
                                <a class="dropdown-item" href="{{ route('backend.userprofile') }}"><i
                                        class="ti-user text-muted me-2"></i> My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="ti-lock text-muted me-2"></i>
                                    {{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>


                </ul>
            </div>
        </nav>
    </header>
</div>
