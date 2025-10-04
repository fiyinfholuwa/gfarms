<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from zoyothemes.com/hando/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 19 Sep 2025 12:01:10 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

        <meta charset="utf-8" />
        <title>Aurelious - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

        <!-- App css -->
<link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons -->
<link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Head JS -->
<script src="{{ asset('admin/assets/js/head.js') }}"></script>

<style>
#sidebar-menu .menuitem-active .active, #sidebar-menu .menuitem-active>a{
        color: darkorange !important;

}

</style>
    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default">

        <!-- Begin page -->
        <div id="app-layout">
            
            <!-- Topbar Start -->
            <div class="topbar-custom">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            <li>
                                <button class="button-toggle-menu nav-link">
                                    <i data-feather="menu" class="noti-icon"></i>
                                </button>
                            </li>
                            <li class="d-none d-lg-block">
@php
    $hour = now()->format('H');
    if ($hour < 12) {
        $greeting = "Good Morning";
    } elseif ($hour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }
@endphp

<h5 class="mb-0">{{ $greeting }}, {{ Auth::user()->first_name }}</h5>
                            </li>
                        </ul>

                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            {{-- <li class="d-none d-lg-block">
                                <form class="app-search d-none d-md-block me-auto">
                                    <div class="position-relative topbar-search">
                                        <input type="text" class="form-control ps-4" placeholder="Search..." />
                                        <i class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                                    </div>
                                </form>
                            </li> --}}

                            <!-- Button Trigger Customizer Offcanvas -->
                            {{-- <li class="d-none d-sm-flex">
                                <button type="button" class="btn nav-link" data-toggle="fullscreen">
                                    <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                                </button>
                            </li> --}}

                            <!-- Light/Dark Mode Button Themes -->
                            {{-- <li class="d-none d-sm-flex">
                                <button type="button" class="btn nav-link" id="light-dark-mode">
                                    <i data-feather="moon" class="align-middle dark-mode"></i>
                                    <i data-feather="sun" class="align-middle light-mode"></i>
                                </button>
                            </li> --}}

                            {{-- <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i data-feather="bell" class="noti-icon"></i>
                                    <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end"><a href="#" class="text-dark"><small>Clear All</small></a></span>Notification
                                        </h5>
                                    </div>

                                    <div class="noti-scroll" data-simplebar>
                                        <!-- item-->
                                        <a href="javascript:void(0);"
                                            class="dropdown-item notify-item text-muted link-primary active">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Carl Steadham</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed <span class="text-reset">Improve workflow in Figma</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Olivia McGuire</p>
                                                    <small class="text-muted">1 min ago</small>
                                                </div>

                                                <div class="d-flex mt-2 align-items-center">
                                                    <div class="notify-sub-icon">
                                                        <i class="mdi mdi-download-box text-dark"></i>
                                                    </div>

                                                    <div>
                                                        <p class="notify-details mb-0">dark-themes.zip</p>
                                                        <small class="text-muted">2.4 MB</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-3.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Travis Williams</p>
                                                    <small class="text-muted">7 min ago</small>
                                                </div>
                                                <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                                    <span class="text-primary">@Patryk</span> Please make sure that you're....
                                                </p>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-8.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Violette Lasky</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed <span class="text-reset">Create new components</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-5.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Ralph Edwards</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed<span class="text-reset">Improve workflow in React</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-6.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Jocab jones</p>
                                                    <small class="text-muted">7 min ago</small>
                                                </div>
                                                <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                                    <span class="text-reset">@Patryk</span> Please make sure that you're....
                                                </p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">View all
                                        <i class="fe-arrow-right"></i>
                                    </a>
                                </div>
                            </li> --}}

                            <!-- User Dropdown -->
                            <li class="dropdown notification-list topbar-dropdown">
                                {{-- <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/user-13.jpg" alt="user-image" class="rounded-circle" />
                                    <span class="pro-user-name ms-1">Alex <i class="mdi mdi-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-dropdown"> --}}
                                    
                                    <!-- item-->
                                    {{-- <a class='dropdown-item notify-item' href='pages-profile.html'>
                                        <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                        <span>My Account</span>
                                    </a> --}}

                                    <!-- item-->
                                    {{-- <a class='dropdown-item notify-item' href='auth-lock-screen.html'>
                                        <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                                        <span>Lock Screen</span>
                                    </a> --}}

                                    <div class="dropdown-divider"></div>

                                    <!-- item-->
                                    <li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
    <a style="color:red;" class="sidenav-item-link" href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="mdi mdi-logout"></i>
        <span class="nav-text">Logout</span>
    </a>
</li>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- Left Sidebar Start -->
            <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>

                    <!--- Sidemenu -->
                    <div style="height:100px !important" id="sidebar-menu">

                        <div class="logo-box">
                            <a class='logo logo-light' href="{{ route('admin.dashboard') }}">
                                <span class="logo-sm">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="100">
                                </span>
                            </a>
                            <a class='logo logo-dark' href="{{ route('admin.dashboard') }}">
                                <span class="logo-sm">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img style="height 200px !important; width:40px;" src="{{ asset('logo.png') }}" alt="" height="24">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu">

                            <!-- Dashboard -->
    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <!-- Manage Foods (Dropdown) -->
    <li>
        <a href="#sidebarFoods" data-bs-toggle="collapse" aria-expanded="false">
            <i class="mdi mdi-basket-outline"></i>
            <span> Manage Foods </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['category.view','admin.product.add','foods.all']) ? 'show' : '' }}" id="sidebarFoods">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('category.view') ? 'active' : '' }}">
                    <a href="{{ route('category.view') }}">Manage Category</a>
                </li>
                <li class="{{ request()->routeIs('admin.product.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.add') }}">Add Food</a>
                </li>
                <li class="{{ request()->routeIs('foods.all') ? 'active' : '' }}">
                    <a href="{{ route('foods.all') }}">All Foods</a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Manage Orders -->
    <li class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
        <a href="{{ route('admin.orders') }}">
            <i class="fas fa-box-open"></i>
            <span> Manage Orders </span>
        </a>
    </li>

    <!-- Manage Payment -->
    <li class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}">
        <a href="{{ route('admin.payment') }}">
            <i class="fas fa-wallet"></i>
            <span> Manage Payment </span>
        </a>
    </li>

    <!-- Manage Support -->
    <li class="{{ request()->routeIs('admin.support') ? 'active' : '' }}">
        <a href="{{ route('admin.support') }}">
            <i class="fas fa-headset"></i>
            <span> Manage Support </span>
        </a>
    </li>

    <!-- Manage Levels -->
    <li class="{{ request()->routeIs('manage.account.level') ? 'active' : '' }}">
        <a href="{{ route('manage.account.level') }}">
            <i class="fas fa-layer-group"></i>
            <span> Manage Levels </span>
        </a>
    </li>

    <!-- Manage Users -->
    <li class="{{ request()->routeIs('manage.user') ? 'active' : '' }}">
        <a href="{{ route('manage.user') }}">
            <i class="fas fa-users-cog"></i>
            <span> Manage Users </span>
        </a>
    </li>

    
    <!-- Logout -->
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout"></i>
            <span> Logout </span>
        </a>
    </li>
                        </ul>
            
                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                            </div>
                        </div>

					@yield('content')
                       
                    </div> <!-- container-fluid -->
                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col fs-13 text-muted text-center">
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor -->
        <script src="{{ asset('admin/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>

<!-- Apexcharts JS -->
<script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Widgets Init Js -->
<script src="{{ asset('admin/assets/js/pages/crm-dashboard.init.js') }}"></script>

<!-- App js-->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>

    </body>


<!-- Mirrored from zoyothemes.com/hando/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 19 Sep 2025 12:03:18 GMT -->
</html>