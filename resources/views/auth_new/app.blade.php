<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themes.pixelstrap.com/fuzzy/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:34:33 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="fuzzy" />
    <meta name="keywords" content="fuzzy" />
    <meta name="author" content="fuzzy" />
    <link rel="manifest" href="manifest.json" />
    <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" />
    <title>Aurelious</title>
    <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" />
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="fuzzy" />
    <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--Google font-->
    
    <!-- iconsax css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/iconsax.css') }}" />
    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.min.css') }}" />
    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ asset('assets/css/style.css') }}" />
  </head>

  <body class="auth-body">
  <style>
  .auth-form .form-control {
  color: rgb(0, 0, 0) !important;          /* Black text inside input */
  background-color: rgb(255, 255, 255) !important; /* White background */
  border: 1px solid rgba(0, 0, 0, 0.2) !important; /* Light border */
}

.auth-form .form-control::placeholder {
  color: rgba(0, 0, 0, 0.5) !important; /* Slightly faded placeholder */
}

</style>
    <!-- login section start -->
    @yield('content')

    <!-- login section end-->

    <!-- iconsax js -->
    <script src="{{ asset('assets/js/iconsax.js') }}"></script>

    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- script js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>

</html>
