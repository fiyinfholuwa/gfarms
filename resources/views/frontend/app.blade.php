<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GFarms</title>
    <meta name="author" content="Frutin">
    <meta name="description" content="Frutin - Organic and Healthy Food HTML Template">
    <meta name="keywords" content="Frutin - Organic and Healthy Food HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Lexend:wght@300;400;500;600;700;800;900&family=Lobster&display=swap" rel="stylesheet"> --}}

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css') }}">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }} ">

</head>


<style>

.action_modal-overlay {
    position: fixed;
    inset: 0;
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
}

.action_modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.action_modal {
    background: #ffffff;
    border-radius: 18px;
    padding: 32px;
    max-width: 420px;
    width: 90%;
    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.4);
    transform: translateY(20px) scale(0.95);
    transition: all 0.4s ease;
    text-align: center;
    position: relative;
}

.action_modal-overlay.active .action_modal {
    transform: translateY(0) scale(1);
}

/* ===============================
   ICON STYLES
================================ */
.action_modal-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #fff;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Themed Icons */
.action_modal-icon.success {
    background: linear-gradient(135deg, #22c55e, #15803d); /* Green */
}

.action_modal-icon.info {
    background: linear-gradient(135deg, #34d399, #059669); /* Minty Green */
}

.action_modal-icon.warning {
    background: linear-gradient(135deg, #f59e0b, #d97706); /* Orange */
}

.action_modal-icon.error {
    background: linear-gradient(135deg, #ef4444, #b91c1c); /* Red */
}

/* ===============================
   TEXT STYLES
================================ */
.action_modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 10px;
}

.action_modal-message {
    font-size: 16px;
    color: #4b5563;
    margin-bottom: 24px;
    line-height: 1.6;
}

/* ===============================
   BUTTON STYLES
================================ */
.action_modal-btn {
    padding: 12px 30px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    background: linear-gradient(135deg, #f97316, #16a34a); /* Orange → Green */
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    transition: all 0.3s ease;
}

.action_modal-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.4);
}
</style>

<!-- ===============================
     MODAL HTML
================================ -->
<div class="action_modal-overlay" id="clipboardModal" onclick="closeClipboardModal(event)">
    <div class="action_modal" onclick="event.stopPropagation()">
        <div class="action_modal-icon" id="modalIcon">
            <span id="modalIconText"><i class="fa fa-info-circle text-white"></i></span>
        </div>
        <h3 class="action_modal-title" id="modalTitle">Notice</h3>
        <p class="action_modal-message" id="modalMessage">This is a message.</p>
        <button class="action_modal-btn" onclick="closeClipboardModal()">Ok</button>
    </div>
</div>

<!-- ===============================
     MODAL SCRIPT
================================ -->
<script>
function showSessionModal(type, message) {
    const overlay = document.getElementById('clipboardModal');
    const icon = document.getElementById('modalIcon');
    const iconText = document.getElementById('modalIconText');
    const title = document.getElementById('modalTitle');
    const msg = document.getElementById('modalMessage');

    icon.className = 'action_modal-icon';

    if (type === 'success') {
        icon.classList.add('success');
        iconText.innerHTML = '<i class="fa fa-check-circle text-white"></i>';
        title.textContent = 'Success!';
    } else if (type === 'info') {
        icon.classList.add('info');
        iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
        title.textContent = 'Information';
    } else if (type === 'warning') {
        icon.classList.add('warning');
        iconText.innerHTML = '<i class="fa fa-exclamation-triangle text-white"></i>';
        title.textContent = 'Warning!';
    } else if (type === 'error') {
        icon.classList.add('error');
        iconText.innerHTML = '<i class="fa fa-times-circle text-white"></i>';
        title.textContent = 'Error!';
    } else {
        icon.classList.add('info');
        iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
        title.textContent = 'Notice';
    }

    msg.textContent = message;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeClipboardModal(event) {
    if (event && event.target !== event.currentTarget) return;
    const overlay = document.getElementById('clipboardModal');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// Support Laravel session-based modals
@if(Session::has('message'))
    const type = "{{ Session::get('alert-type', 'info') }}";
    const message = "{{ Session::get('message') }}";
    showSessionModal(type, message);
    {{ Session::forget('message') }}
    {{ Session::forget('alert-type') }}
@endif
</script>

<style>
.cart-mobile {
    display: none;
}

/* Show only on screens smaller than 576px (Bootstrap “sm” breakpoint) */
@media (max-width: 575.98px) {
    .cart-mobile {
        display: inline-block; /* or flex, depending on your layout */
    }
}


</style>
<body>

    <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  	<![endif]-->


    <!--********************************
   		Code Start From Here 
	******************************** -->

    <!--==============================
     Preloader
  ==============================-->
    {{-- <div class="preloader ">
        <button class="th-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <div class="loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div> --}}



    


    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form method="get"  action="{{ route('food.search') }}">
            <input name="query" type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div><!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
        
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            
            <div class="mobile-logo">
                <a href="{{ route('home') }}"><img style="width:100px;" src="{{ asset('logo.png') }}" ></a>

                

            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li>
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('about') }}">About</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('shop') }}">Shop</a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>

                                    @auth
                                       @if (Auth::user()->user_role === 'admin')
 <li>
                                        <a href="{{ route('check_login') }}">Admin Dashboard</a>
                                    </li>
 
                            @else

                            <li class="menu-item-has-children">
                                        <a href="#">My Dashboard</a>
                                        <ul class="sub-menu">

                                        <li>
                                        <a href="{{ route('user.orders') }}">My Order</a>
                                    </li>
                                       <li>
                                        <a href="{{ route('profile') }}">My Profile</a>
                                    </li>
                                     <li>
                                        <a href="{{ route('user.payment') }}">Payment History</a>
                                    </li>

                                        </ul>
                                    </li>

                                
                            @endif
                           

                                    <li>
                                        <a href="{{ route('logout') }}">Logout</a>
                                    </li>
 

                                    @else

                                    <li>
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">Register</a>
                                    </li>
 
                                    @endauth

                </ul>
            </div>
        </div>
    </div><!--==============================
	Header Area
==============================-->
    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <p class="header-notice">Orders of #5000000 or more qualify for free shipping!</p>
                    </div>
                    <div class="col-auto">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-sm-inline-block"><i class="fal fa-location-dot"></i><a href="https://www.google.com/maps">
        Oyo State, Nigeria
                                </a></li>
                                <li>
                                    <div class="social-links">
                                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                                        <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 100px; width: 250px !important; object-fit: contain;">
                            </a>


                                <a href="{{ route('cart') }}" class="cart-mobile simple-icon">
    <span class="badge" id="cart-count">0</span>
    <i class="fa-regular fa-cart-shopping"></i>
</a>                                    
                            </div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul>
                                    
                                    <li>
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('about') }}">About</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('shop') }}">Shop</a>
                                    </li>
                                     <li>
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>


 @auth

                            @if (Auth::user()->user_role === 'admin')
 <li>
                                        <a href="{{ route('check_login') }}">Admin Dashboard</a>
                                    </li>
 
                            @else

                            <li class="menu-item-has-children">
                                        <a href="#">My Dashboard</a>
                                        <ul class="sub-menu">

                                        <li>
                                        <a href="{{ route('user.orders') }}">My Order</a>
                                    </li>
                                       <li>
                                        <a href="{{ route('profile') }}">My Profile</a>
                                    </li>
                                     <li>
                                        <a href="{{ route('user.payment') }}">Payment History</a>
                                    </li>

                                        </ul>
                                    </li>

                                
                            @endif
                                       

                                    <li>
                                        <a href="{{ route('logout') }}">Logout</a>
                                    </li>
 

                                    @else

                                    <li>
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">Register</a>
                                    </li>
 
                                    @endauth
                                    
                                   
                                    
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <button type="button" class="simple-icon searchBoxToggler"><i class="far fa-search"></i></button>
                                <a href="{{ route('cart') }}" class="simple-icon">
                                    <span class="badge" id="cart-count">0</span>
                                    <i class="fa-regular fa-cart-shopping"></i>
                                </a>
                                <a href="{{ route('shop') }}" class="th-btn style4">Shop Now<i class="fas fa-chevrons-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

@yield('content')

 <!--==============================
	Footer Area
==============================-->
    <div class="">
    <div class="container z-index-common">
        <div class="newsletter-wrap text-center">
            <div class="newsletter-content mb-3">
<h4 class="newsletter-title">We’d love to hear from you! Reach out today.</h4>
            </div>
            <form class="newsletter-form d-inline-block">
                <a href="{{ route('contact') }}" class="th-btn style6">
                    Contact Us
                </a>
            </form>
        </div>
    </div>
</div>

    <footer class="footer-wrapper footer-layout1" >
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a  href="{{ route('home') }}"><img style="height:100px;" src="{{ asset('logo.png') }}" alt="Frutin"></a>
                                </div>
                                <p class="about-text">
                                We specialize in providing fresh, high-quality protein sources — including chicken and chicken products, eggs, beef, snails, crayfish, and more. With over 23 years of experience, our mission is to deliver clean, nutritious, and trustworthy food items to homes and businesses.


                                </p>
                                <div class="th-social">
                                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title"><img src="{{ asset('/frontend/assets/img/theme-img/title_icon.svg') }}" alt="Icon">Quick Links</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    {{-- <li><a href="{{ route('about') }}">About</a></li> --}}
                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                    <li><a href="{{ route('contact') }}">Faq</a></li>
                                    <li><a href="{{ route('contact') }}">Term &   Conditions</a></li>
                                    <li><a href="{{ route('contact') }}">Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title"><img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="Icon">Contact Us</h3>
                            <div class="th-widget-contact">
                                <div class="info-box">
                                    <div class="info-box_icon">
                                        <i class="fas fa-location-dot"></i>
                                    </div>
                                    <p class="info-box_text">Oyo State, Ibadan</p>
                                </div>
                                <div class="info-box">
                                    <div class="info-box_icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <p class="info-box_text">
                                        <a href="tel:+16326543564" class="info-box_link">+(163)-2654-3564</a>
                                    </p>
                                </div>
                                <div class="info-box">
                                    <div class="info-box_icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <p class="info-box_text">
                                        <a href="mailto:help24/7@frutin.com" class="info-box_link">gfarm@gmail.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-md-6">
                        {{-- <p class="copyright-text">Copyright <i class="fal fa-copyright"></i> 2023 <a href="">Frutin</a>. All Rights Reserved.</p> --}}
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }} "></script>
    <!-- Bootstrap -->
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}  "></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }} "></script>
    <!-- Counter Up -->
    <script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }} "></script>
    <!-- Range Slider -->
    <script src="{{ asset('frontend/assets/js/jquery-ui.min.js') }} "></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }} "></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }} "></script>

    <!-- Main Js File -->
    <script src="{{ asset('frontend/assets/js/main.js') }} "></script>




<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateCartCount() {
        fetch("/cart/count")
            .then(response => response.json())
            .then(data => {
                console.log("Cart count response:", data); // 🔥 debug
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.innerText = data.count ?? 0; // fallback to 0
                }
            })
            .catch(err => {
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.innerText = 0; // ✅ show 0 if error
                }
            });
    }

    // Run immediately
    updateCartCount();

    // Refresh every 10 seconds
    setInterval(updateCartCount, 1000);
});
</script>

</body>

</html>