<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('deliveryman.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('deliveryman.dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/rk_logo.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RK Courier</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::user()->image)
                                        <img class="img-circle elevation-2"
                                            src="{{ asset('storage/' . Auth::user()->image) }}"
                                            alt="Profile Picture">
                                    @else
                                        <img class="img-circle elevation-2"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                    @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('deliveryman.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('deliveryman.dashboard') }}"
                                class="nav-link {{ request()->routeIs('deliveryman.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deliveryman.profile') }}"
                                class="nav-link {{ request()->routeIs('deliveryman.profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deliveryman.assignedTL') }}"
                                class="nav-link {{ request()->routeIs('deliveryman.assignedTL') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Assigned TL
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('deliveryman/delivery_process*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('deliveryman/delivery_process*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-spinner"></i>
                                <p>
                                    Delivery Process
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.call_verification') }}" class="nav-link {{ request()->routeIs('deliveryman.call_verification') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Call Verification</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.delivery_status') }}" class="nav-link {{ request()->routeIs('deliveryman.delivery_status') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Delivery Status</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.send_otp') }}" class="nav-link {{ request()->routeIs('deliveryman.send_otp') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Send OTP</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.verify_otp') }}" class="nav-link {{ request()->routeIs('deliveryman.verify_otp') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Verify OTP</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.delivered') }}" class="nav-link {{ request()->routeIs('deliveryman.delivered') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Delivered</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deliveryman.return') }}"
                                class="nav-link {{ request()->routeIs('deliveryman.return') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-share"></i>
                                <p>
                                    Return to DNCC
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deliveryman.logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Log out
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
