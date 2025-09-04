<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themes.pixelstrap.com/fuzzy/landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:34:41 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="fuzzy" />
    <meta name="keywords" content="fuzzy" />
    <meta name="author" content="fuzzy" />
    <link rel="manifest" href="manifest.json" />
    {{-- <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" /> --}}
    <title>Aurelius Dashboard</title>
    {{-- <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" /> --}}
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="fuzzy" />
    {{-- <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" /> --}}

    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- iconsax css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/iconsax.css') }}" />

    <!-- swiper css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/swiper-bundle.min.css') }}" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.min.css') }}" />
    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ asset('assets/css/style.css') }}" />
  </head>

  <body>
    <!-- side bar start -->
    <div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft">
      <div class="offcanvas-header">
        <img class=" profile-pic" style="width:100px; height:70px" src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="profile" />
        <h4>Hello, {{ Auth::user()->first_name }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="sidebar-content">
          <ul class="link-section">
            
            <li>
              <a href="{{ route('dashboard') }}" class="pages">
                <h4>Dashboard</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>

            <li>
              <a href="" class="pages">
                <h4>Food Market</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>
            <li>
              <a href="" class="pages">
                <h4>My Orders</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>
            <li>
              <a href="" class="pages">
                <h4>Payment History</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>
            <li>
              <a href="" class="pages">
                <h4>Support</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>

            <li>
              <a href="{{ route('logout') }}" class="pages">
                <h4>Logout</h4>
                <i class="ri-arrow-drop-right-line"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- side bar end -->

    <!-- header start -->
    <header class="section-t-space">
      <div class="custom-container">
        <div class="header">
          <div class="head-content">
            <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
              <i class="iconsax menu-icon" data-icon="menu-hamburger"></i>
            </button>
            <div class="header-info">
              <img class="img-fluid profile-pic" style="width:100px; height:70px;" src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="profile" />
              <div>
                <h4 class="light-text">Hello</h4>
                <h2 class="theme-color">{{ Auth::user()->first_name }}</h2>
              </div>
            </div>
          </div>
          <a href="" class="notification">
            <i class="iconsax notification-icon" data-icon="bell-2"></i>
          </a>
        </div>
      </div>
    </header>
    <!-- header end -->

    <!-- search section starts -->
    <section>
      <div class="custom-container">
        <form class="theme-form search-head" target="_blank">
          <div class="form-group">
            <div class="form-input">
              <input type="text" class="form-control search" id="inputusername" placeholder="Search here..." />
              {{-- <i class="iconsax search-icon" data-icon="search-normal-2"></i> --}}
            </div>

            <a href="#search-filter" class="btn filter-btn mt-0" data-bs-toggle="modal">
  <i class="fa fa-search"></i>
</a>

          </div>
        </form>
      </div>
    </section>
    <!-- search section end -->

    @yield('content')
    
    <!-- panel-space start -->
    <section class="panel-space"></section>
    <!-- panel-space end -->

    <!-- bottom navbar start -->
    <div class="navbar-menu">
      <ul>
        <li class="active">
          <a href="{{ route('dashboard') }}">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/home.svg" alt="home" />
              <img class="active" src="assets/images/svg/home-fill.svg" alt="home" />
            </div>
          </a>
        </li>
        <li>
          <a href="{{ route('category') }}">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/categories.svg" alt="categories" />
              <img class="active" src="assets/images/svg/categories-fill.svg" alt="categories" />
            </div>
          </a>
        </li>
        <li>
          <a href="{{ route('user.packages') }}">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/bag.svg" alt="bag" />
              <img class="active" src="assets/images/svg/bag-fill.svg" alt="bag" />
            </div>
          </a>
        </li>
        <li>
          <a href="">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/bag.svg" alt="bag" />
              <img class="active" src="assets/images/svg/bag-fill.svg" alt="bag" />
            </div>
          </a>
        </li>
        <li>
          <a href="">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/heart.svg" alt="heart" />
              <img class="active" src="assets/images/svg/heart-fill.svg" alt="heart" />
            </div>
          </a>
        </li>
        <li>
          <a href="">
            <div class="icon">
              <img class="unactive" src="assets/images/svg/profile.svg" alt="profile" />
              <img class="active" src="assets/images/svg/profile-fill.svg" alt="profile" />
            </div>
          </a>
        </li>
      </ul>
    </div>
    <!-- bottom navbar end -->

    <!-- swiper js -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-swiper.js') }}"></script>

    <!-- range-slider js -->
    <script src="{{ asset('assets/js/range-slider.js') }}"></script>

    <!-- iconsax js -->
    <script src="{{ asset('assets/js/iconsax.js') }}"></script>

    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- script js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>

<!-- Mirrored from themes.pixelstrap.com/fuzzy/landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:35:23 GMT -->
</html>
