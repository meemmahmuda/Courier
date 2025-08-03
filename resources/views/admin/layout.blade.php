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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
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
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/rk_logo.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RK Courier</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin</a>
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
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>


                        <li class="nav-item {{ request()->is('supervisor*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('supervisor*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Supervisor
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('all.supervisor') }}"
                                        class="nav-link {{ request()->routeIs('all.supervisor') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Supervisor</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('add.supervisor') }}"
                                        class="nav-link {{ request()->routeIs('add.supervisor') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Supervisor</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('delivery_man*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('delivery_man*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Delivery Man
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('all.delivery_man') }}"
                                        class="nav-link {{ request()->routeIs('all.delivery_man') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Delivery Man</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('add.delivery_man') }}"
                                        class="nav-link {{ request()->routeIs('add.delivery_man') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Delivery Man</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('print*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('print*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Print Count
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('print_all') }}"
                                    class="nav-link {{ request()->routeIs('print_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('print_with_number') }}"
                                    class="nav-link {{ request()->routeIs('print_with_number') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Print with Number</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('print_without_number') }}"
                                    class="nav-link {{ request()->routeIs('print_without_number') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Print without Number</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('delivery_team*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('delivery_team*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Delivery Team
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('tl_assign_to_sp') }}"
                                    class="nav-link {{ request()->routeIs('tl_assign_to_sp') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TL Assign to SP</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('supervisor_details') }}"
                                    class="nav-link {{ request()->routeIs('supervisor_details') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Supervisor Details</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('delivery_man_details') }}"
                                    class="nav-link {{ request()->routeIs('delivery_man_details') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Delivery Man Details</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('delivery_process*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('delivery_process*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-spinner"></i>
                                <p>
                                    Delivery Process
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('call_verification') }}" class="nav-link {{ request()->routeIs('call_verification') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Call Verification</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('delivery_status') }}" class="nav-link {{ request()->routeIs('delivery_status') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Delivery Status</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('verified_by_sp') }}" class="nav-link {{ request()->routeIs('verified_by_sp') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Verified by SP</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('delivered') }}" class="nav-link {{ request()->routeIs('delivered') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Delivered</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('delivery_report') }}" class="nav-link {{ request()->routeIs('delivery_report') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    Delivery Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.return') }}"
                                class="nav-link {{ request()->routeIs('admin.return') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-share"></i>
                                <p>
                                    Return to DNCC
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.map') }}"
                                class="nav-link {{ request()->routeIs('admin.map') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marked-alt"></i>
                                <p>
                                    Map
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.otp_verification') }}"
                                class="nav-link {{ request()->routeIs('admin.otp_verification') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-mobile"></i>
                                <p>
                                    OTP Verification
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
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
