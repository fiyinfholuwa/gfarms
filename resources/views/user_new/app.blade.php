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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


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
  <a href="{{ route('dashboard') }}" class="pages {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <h4>Dashboard</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('user.packages') }}" class="pages {{ request()->routeIs('user.packages') ? 'active' : '' }}">
    <h4>Food Market</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('user.orders') }}" class="pages {{ request()->routeIs('user.orders') ? 'active' : '' }}">
    <h4>My Orders</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('user.payment') }}" class="pages {{ request()->routeIs('user.payment') ? 'active' : '' }}">
    <h4>Payment History</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('support.index') }}" class="pages {{ request()->routeIs('support.index') ? 'active' : '' }}">
    <h4>Support</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="#" class="pages"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <h4>Logout</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
  </form>
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
          <img class="img-fluid profile-pic" 
               src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" 
               alt="profile" />
          <div>
            <h4 class="light-text">Hello</h4>
            <h2 class="theme-color">{{ Auth::user()->first_name }}</h2>
          </div>
        </div>
      </div>

      <a href="{{ route('cart') }}" class="cart-link">
        <i class="fa fa-shopping-cart"></i>
        <sup class="badge bg-danger" id="cart-count">0</sup>
      </a>
    </div>
  </div>
</header>

<style>

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.head-content {
  display: flex;
  align-items: center;
  gap: 15px;
}

.header-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.profile-pic {
  width: 80px !important;
  height: 60px !important;
  {{-- object-fit: contain; --}}
}

.cart-link {
  position: relative;
  font-size: 20px;
  color: #555;
  text-decoration: none;
}

.cart-link sup {
  position: absolute;
  top: -8px;
  right: -10px;
  font-size: 12px;
}

</style>
    <!-- header end -->

    <!-- search section starts -->
    <section>
      <div class="custom-container">

      

        <form class="theme-form search-head" method="GET" action="{{ route('food.search') }}" >
          <div class="form-group">
            <div class="form-input">
              <input type="text" class="form-control search" name="query" id="inputusername" value="{{ request('query') }}" placeholder="Search here..." />
            </div>

<button  type="submit" class="btn filter-btn mt-0">
  <i class="fa fa-search"></i>
        </button>


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
  <ul style="list-style:none; display:flex; gap:30px; padding:0; margin:0;">
    <li>
      <a href="{{ route('dashboard') }}">
        <i class="fa fa-home" 
           style="font-size:28px; color:{{ request()->routeIs('dashboard') ? 'orange' : '#555' }};">
        </i>
        <span class="b-label">Home</span>
      </a>
    </li>

    <li>
      <a href="{{ route('category') }}">
        <i class="fa fa-tag" 
           style="font-size:28px; color:{{ request()->routeIs('category') ? 'orange' : '#555' }};">
        </i>
                <span class="b-label">Category</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.packages') }}">
        <i class="fa fa-shopping-bag" 
           style="font-size:28px; color:{{ request()->routeIs('user.packages') ? 'orange' : '#555' }};">
        </i>
                        <span class="b-label">Shop</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.payment') }}">
        <i class="fa fa-exchange" 
           style="font-size:28px; color:{{ request()->routeIs('user.payment') ? 'orange' : '#555' }};">
        </i>
                                <span class="b-label">Payment</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.orders') }}">
        <i class="fas fa-shopping-cart" 
           style="font-size:28px; color:{{ request()->routeIs('user.orders') ? 'orange' : '#555' }};">
        </i>
                                <span class="b-label">Orders</span>

      </a>
    </li>
  </ul>
</div>

<style>
.b-label{

  font-size:12px;
}

@media(max-width:375px){
  .b-label{

  font-size:8px !important;
}
}
</style>

    <!-- bottom navbar end -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
                console.error("Error fetching cart count:", err);
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.innerText = 0; // ✅ show 0 if error
                }
            });
    }

    // Run immediately
    updateCartCount();

    // Refresh every 10 seconds
    setInterval(updateCartCount, 10000);
});
</script>




<!-- Include iziToast CSS & JS if not already included -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<!-- Modal CSS -->
<style>
    .action_modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .action_modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .action_modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 32px;
        max-width: 400px;
        width: 90%;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.3);
        transform: scale(0.9) translateY(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-align: center;
        position: relative;
    }

    .action_modal-overlay.active .action_modal {
        transform: scale(1) translateY(0);
    }

    .action_modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .action_modal-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .action_modal-icon.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .action_modal-icon.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .action_modal-icon.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .action_modal-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .action_modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .action_modal-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .action_modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }
</style>

<!-- Modal HTML -->
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

<!-- Modal JS -->
<script>
    function showSessionModal(type, message) {
        const overlay = document.getElementById('clipboardModal');
        const icon = document.getElementById('modalIcon');
        const iconText = document.getElementById('modalIconText');
        const title = document.getElementById('modalTitle');
        const msg = document.getElementById('modalMessage');

        // Reset classes to allow proper icon color
        icon.className = 'action_modal-icon';

        if (type === 'success') {
            icon.classList.add('success');
            iconText.innerHTML = '<i class="fa fa-check-circle text-white"></i>';
            title.textContent = 'Success!';
        } else if (type === 'info') {
            icon.classList.add('info');
            iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
            title.textContent = 'Info';
        } else if (type === 'warning') {
            icon.classList.add('warning');
            iconText.innerHTML = '<i class="fa fa-exclamation-triangle text-white"></i>';
            title.textContent = 'Warning';
        } else if (type === 'error') {
            icon.classList.add('error');
            iconText.innerHTML = '<i class="fa fa-times-circle text-white"></i>';
            title.textContent = 'Error';
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

    // Close modal on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeClipboardModal();
        }
    });

    @if(Session::has('message'))
    // Get Laravel flash message type and message
    const type = "{{ Session::get('alert-type', 'info') }}";
    const message = "{{ Session::get('message') }}";

    // Show modal on page load
    showSessionModal(type, message);

    // Clear session keys so it won't show again
    {{ Session::forget('message') }}
    {{ Session::forget('alert-type') }}
    @endif
</script>

    
  </body>

<!-- Mirrored from themes.pixelstrap.com/fuzzy/landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:35:23 GMT -->
</html>
