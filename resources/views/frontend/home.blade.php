@extends('frontend.app')


@section('content')

<style>
.hero-img {
  position: relative;
  width: 100%;
  max-width: 637px;
  aspect-ratio: 637 / 620; /* maintains shape across breakpoints */
  overflow: hidden;
  border-radius: 50px;
}

.hero-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 50px;
}

</style>
<!--==============================
Product Lightbox
==============================-->
    <div id="QuickView" class="white-popup mfp-hide">
        <div class="container bg-white rounded-10">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-big-img">
                        <div class="img"><img src="assets/img/product/product_details_1_1.jpg" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="product-about">
                        <p class="price">$120.85<del>$150.99</del></p>
                        <h2 class="product-title">Bosco Apple Fruit</h2>
                        <div class="product-rating">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span></div>
                            <a href="shop-details.html" class="woocommerce-review-link">(<span class="count">4</span> customer reviews)</a>
                        </div>
                        <p class="text">Prepare to embark on a sensory journey with the Bosco Apple, a fruit that transcends the ordinary and promises an unparalleled taste experience. These apples are nothing short of nature’s masterpiece, celebrated for their distinctive blend of flavors and their captivating visual allure.</p>
                        <div class="mt-2 link-inherit">
                            <p>
                                <strong class="text-title me-3">Availability:</strong>
                                <span class="stock in-stock"><i class="far fa-check-square me-2 ms-1"></i>In Stock</span>
                            </p>
                        </div>
                        <div class="actions">
                            <div class="quantity">
                                <input type="number" class="qty-input" step="1" min="1" max="100" name="quantity" value="1" title="Qty">
                                <button class="quantity-plus qty-btn"><i class="far fa-chevron-up"></i></button>
                                <button class="quantity-minus qty-btn"><i class="far fa-chevron-down"></i></button>
                            </div>
                            <button class="th-btn">Add to Cart</button>
                            <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a>
                        </div>
                        <div class="product_meta">
                            <span class="sku_wrapper">SKU: <span class="sku">Bosco-Apple-Fruit</span></span>
                            <span class="posted_in">Category: <a href="shop.html">Fresh Fruits</a></span>
                            <span>Tags: <a href="shop.html">Fruits</a><a href="shop.html">Organic</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        </div>
    </div>
    
    
    <!--==============================
Hero Area
==============================-->
   <div class="th-hero-wrapper hero-1" id="hero" data-bg-src="{{ asset('frontend/assets/img/hero/hero_bg_1_2.jpg') }}">
    <div class="swiper th-slider" id="heroSlide1" data-slider-options='{"effect":"fade"}'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="container">
                        <div class="hero-style1">
                            <span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s">
                            Fresh From the Farm,
                            </span>
                            <h1 class="hero-title">
                                <span class="title1" data-ani="slideinup" data-ani-delay="0.4s">
                                    Delivered     <span class="text-theme">to</span>
                                </span>
                                <span class="title2" data-ani="slideinup" data-ani-delay="0.5s">Your Table</span>
                            </h1>
                            <a href="{{ route('shop') }}" class="th-btn" data-ani="slideinup" data-ani-delay="0.7s">Shop Now<i class="fas fa-chevrons-right ms-2"></i></a>
                        </div>
                    </div>
                    <div style=" padding:20px;" class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">
    <img 
        src="{{ asset('bg_farm.png') }}" 
        alt="Image"
        style="object-fit:cover; border-radius:30px;"
    >
                    </div>
                    <div class="hero-shape1" data-ani="slideinup" data-ani-delay="0.5s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_1.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape2" data-ani="slideindown" data-ani-delay="0.6s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_2.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape3" data-ani="slideinleft" data-ani-delay="0.7s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_3.png') }}" alt="shape">
                    </div>
                </div>
            </div>
            
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="container">
                        <div class="hero-style1">
                            <span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s">
                                <img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="shape">
                            </span>
                            <span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s">
                            Premium Chicken, Beef, Snails,
                            </span>
                            <h1 class="hero-title">
                                <span class="title1" data-ani="slideinup" data-ani-delay="0.4s">
                                    <img class="title-img" src="{{ asset('frontend/assets/img/hero/hero_title_shape.svg') }}" alt="icon">
                                    Crayfish &  <span class="text-theme">Fresh </span>
                                </span>
                                <span class="title2" data-ani="slideinup" data-ani-delay="0.5s">Foods for Every Household</span>
                            </h1>
                            <a href="about.html" class="th-btn" data-ani="slideinup" data-ani-delay="0.7s">Contact Us<i class="fas fa-chevrons-right ms-2"></i></a>
                        </div>
                    </div>
                    <div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">
                        <img src="https://chillax.com.ua/wp-content/uploads/2024/12/ravlykova-ferma-5.jpg" alt="Image" >
                    </div>
                    <div class="hero-shape1" data-ani="slideinup" data-ani-delay="0.5s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_1.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape2" data-ani="slideindown" data-ani-delay="0.6s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_2.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape3" data-ani="slideinleft" data-ani-delay="0.7s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_3.png') }}" alt="shape">
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="container">
                        <div class="hero-style1">
                            <span class="sub-title" data-ani="slideinup" data-ani-delay="0.2s">
                                <img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="shape">100% Fresh Foods
                            </span>
                            <h1 class="hero-title">
                                <span class="title1" data-ani="slideinup" data-ani-delay="0.4s">
                                    Shop Healthy <span class="text-theme">Eat</span>
                                </span>
                                <span class="title2" data-ani="slideinup" data-ani-delay="0.5s">Fresh</span>
                            </h1>
                            <a href="{{ route('shop') }}" class="th-btn" data-ani="slideinup" data-ani-delay="0.7s">Discover More<i class="fas fa-chevrons-right ms-2"></i></a>
                        </div>
                    </div>
                    <div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">

                        <img 
        src="{{ asset('bg_farm.png') }}" 
        alt="Image"
        style="object-fit:cover; border-radius:30px;"
    >
                    </div>
                    <div class="hero-shape1" data-ani="slideinup" data-ani-delay="0.5s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_1.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape2" data-ani="slideindown" data-ani-delay="0.6s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_2.png') }}" alt="shape">
                    </div>
                    <div class="hero-shape3" data-ani="slideinleft" data-ani-delay="0.7s">
                        <img src="{{ asset('frontend/assets/img/hero/hero_shape_1_3.png') }}" alt="shape">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-shape4">
        <img class="svg-img" src="{{ asset('frontend/assets/img/hero/hero_shape_1_4.svg') }}" alt="shape">
    </div>
</div>

{{-- <section class="space-top">
    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title">
                <img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="Icon">Main Categories
            </span>
            <h2 class="sec-title">What We’re Offering</h2>
        </div>

        <div class="swiper th-slider" data-slider-options='{
            "breakpoints": {
                "0": {"slidesPerView": 1},
                "400": {"slidesPerView": 2},
                "768": {"slidesPerView": 3},
                "992": {"slidesPerView": 4},
                "1200": {"slidesPerView": 5}
            }
        }'>
            <div class="swiper-wrapper">
                @php
                    $icons = ['1', '2', '3', '4', '5'];
                    $titles = ['Chicken & Poultry', 'Beef & Red Meat', 'Fish & Crayfish', 'Eggs & Dairy', 'Snails & More'];
                    $counts = ['12', '8', '10', '9', '6'];
                @endphp

                @foreach($icons as $index => $icon)
                <div class="swiper-slide">
                    <div class="category-card">
                        <div class="box-shape" data-bg-src="{{ asset('frontend/assets/img/bg/category_card_bg.png') }}"></div>
                        <div class="box-icon" data-mask-src="{{ asset('frontend/assets/img/bg/category_card_icon_bg.png') }}">
                            <img src="{{ asset('frontend/assets/img/icon/category_card_' . $icon . '.svg') }}" alt="Image">
                        </div>
                        <p class="box-subtitle">Product ({{ $counts[$index] }})</p>
                        <h3 class="box-title">
                            <a href="{{ route('shop') }}">{{ $titles[$index] }}</a>
                        </h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section> --}}

<div class="overflow-hidden space" id="about-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 mb-30 mb-xl-0">
                <div class="img-box1">
                    <div class="img1">
                        <img src="{{ asset('https://www.yummymedley.com/wp-content/uploads/2019/12/Peppered-Snail-13-480x270.jpg') }}" style="height:337px; width:328px;" alt="About">
                    </div>
                    <div class="img2">
                        <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-8HPjOuy4vD6MrsmN4esuDaVkG9q-oKehGw&s') }}" style="height:337px; width:328px;" alt="Image">
                    </div>
                    <div class="shape1 movingX">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5_xu8aYVzr47TJVAIaIBGkktWD2RPnQSNIg&s" style="height:637px; width:630px;" alt="Image">
                    </div>
                    <div class="year-counter">
                        <div class="year-counter_number"><span class="counter-number">10</span>+</div>
                        <p class="year-counter_text">Years Experience</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ps-xxl-5 ps-xl-2 ms-xl-1 text-center text-xl-start">
                    <div class="title-area mb-32">
                        <span class="sub-title">
                            <img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="shape">About Our Company
                        </span>
                        <h2 class="sec-title">Feeding Families With Quality Protein & Fresh Foods</h2>
                        <p class="sec-text">
At Ginella Farms, we are committed to feeding families with clean, nutritious and affordable protein. Whether you need live broilers, frozen chicken, eggs, beef, snails or fresh seafood condiments, our products are handled with the highest hygiene and delivered fresh to your home.
                        </p>
                    </div>
                    <div class="about-feature-wrap">
                        <div class="about-feature">
                            <div class="box-icon">
                                <img src="{{ asset('frontend/assets/img/icon/about_feature_1.svg') }}" alt="Icon">
                            </div>
                            <h3 class="box-title">Reliable Protein Supplier</h3>
                        </div>
                        <div class="about-feature">
                            <div class="box-icon">
                                <img src="{{ asset('frontend/assets/img/icon/about_feature_2.svg') }}" alt="Icon">
                            </div>
                            <h3 class="box-title">Clean & Hygienic Handling</h3>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('about') }}" class="th-btn">Discover More<i class="fas fa-chevrons-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section data-pos-for="#shop-sec" data-sec-pos="bottom-half">
    <div class="container z-index-common">
        <div class="row gy-30">

            <!-- Left offer card with inline background -->
            <div class="col-xl-6">
                <div class="offer-card mega-hover"
                     style="position: relative; overflow: hidden; background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNMErYjFI4Y9k0562PkRxAtzDceJHuhZA_qg&s'); background-size: cover; background-position: center;">
                    <div style="position: absolute; inset: 0; background-color: rgba(0,0,0,0.1); z-index: 1; pointer-events: none;"></div>

                    <div style="position: relative; z-index: 2;">
                        <h3 class="box-title text-white">Fresh Chicken & <br> Protein Packs</h3>
                        <a href="{{ route('shop') }}" class="th-btn">Shop Now<i class="fas fa-chevrons-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right offer card with external background image -->
            <div class="col-xl-6">
                <div class="offer-card mega-hover"
                     style="position: relative; overflow: hidden; background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQb3PSA2jjnomllo1clezmKrb7VaPmjhrPl-A&s'); background-size: cover; background-position: center;">
                    <div style="position: absolute; inset: 0; background-color: rgba(0,0,0,0.1); z-index: 1; pointer-events: none;"></div>

                    <div style="position: relative; z-index: 2;">
                        <h3 class="box-title text-white">Beef, Snails & <br> Seafood Specials</h3>
                        <a href="{{ route('shop') }}" class="th-btn">Shop Now<i class="fas fa-chevrons-right ms-2"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

    <!--==============================
Product Area
==============================-->
  <section class="bg-smoke2 space" id="shop-sec">
    <div class="container text-center">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Products</h2>
        </div>

        {{-- Dynamic Filter Buttons --}}
        <div class="filter-menu indicator-active filter-menu-active">
            <button data-filter="*" class="th-btn tab-btn active" type="button">ALL</button>
            @foreach($categories as $key => $cat)
                <button data-filter=".cat{{ $cat->id }}" class="th-btn tab-btn" type="button">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <div class="row gy-4 filter-active">
            @foreach($products as $product)
                @php
                    // Find the category id (for the filter CSS class)
                    $cat = $categories->firstWhere('id', $product->category);
                    $catClass = $cat ? 'cat' . $cat->id : '';
                @endphp
                <div class="col-xl-3 col-lg-4 col-sm-6 filter-item {{ $catClass }}">
                <a href="{{  route('shop.detail', $product->slug)  }}">
                    <div class="th-product product-grid">
                        <div class="product-img">
                            <img src="{{ $product->image ? asset($product->image) : asset('frontend/assets/img/no-image.png') }}"
                                 alt="{{ $product->name }}">
                            <span class="product-tag">{{ optional($product->cat)->name ?? 'Uncategorized' }}</span>
                            <div class="actions">
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="product-title">
                                {{ $product->name }}
                            </h3>
                            <span class="price">₦{{ number_format($product->amount, 2) }}</span>
                            
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

 <!--==============================
Feature Area  
==============================-->
    <div class="overflow-hidden space">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 text-center text-xl-start">
                <div class="title-area">
                    <span class="sub-title">
                        <img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="shape">
                        Why Choose Us
                    </span>
                    <h2 class="sec-title">Premium Protein Sources for Your Daily Needs</h2>
                    <p class="sec-text">
                        We specialize in delivering clean, high-quality protein like chicken, eggs, beef, snails, crayfish and more. Enjoy fast delivery, trusted service, and unbeatable freshness from a store built with your health in mind.
                    </p>
                </div>
            </div>
        </div>
        <div class="text-center text-xl-start">
            <div class="choose-feature-area">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="choose-feature-wrap">
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_1.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Superior Quality Assurance</h3>
                                <p class="box-text">
All our products undergo rigorous hygiene and safety checks to ensure freshness and high nutritional value.
                                </p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_2.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Farm-Fresh Delivery</h3>
                                <p class="box-text">
We deliver your chicken, beef, snails, eggs and other items swiftly and in perfect condition.
                                </p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_3.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title"> Trusted by Families Nationwide</h3>
                                <p class="box-text">
Households, caterers and food vendors rely on us daily because we provide consistency and honesty in our services.
                                </p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_4.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Secure Payment</h3>
                                <p class="box-text">
Shop with confidence using safe and reliable payment channels on our website.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 d-none d-xl-block">
                        <div class="img-box2-wrap">
                            <div class="img-box2">
                                <div class="img1">
<div style="width: 100%; max-width: 537px; height: auto;">
    <img
        src="https://cdn.vectorstock.com/i/500p/33/79/100-secure-grunge-badge-with-a-check-mark-label-vector-51493379.jpg"
        alt="Why"
        style="width: 100%; height: 609px; object-fit: cover; display: block;"
    >
</div>
                                </div>
                                <div class="img2">
                                    <img src="{{ asset('frontend/assets/img/normal/why_1_2.png') }}" alt="Why">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!--==============================
Counter Area  
==============================-->
    {{-- <div class="counter-sec1" data-bg-src="assets/img/bg/counter_bg_1.png">
        <div class="container">
            <div class="counter-card-wrap">
                <div class="counter-card">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter_card_1.svg" alt="Icon">
                    </div>
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">15663</span>+</h2>
                        <p class="box-text">Our Total Products</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter_card_2.svg" alt="Icon">
                    </div>
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">356</span>+</h2>
                        <p class="box-text">Team Members</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter_card_3.svg" alt="Icon">
                    </div>
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">2365</span>+</h2>
                        <p class="box-text">Satisfied Customers</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter_card_4.svg" alt="Icon">
                    </div>
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">156</span>+</h2>
                        <p class="box-text">Awards Winning</p>
                    </div>
                </div>
                <div class="divider"></div>
            </div>
        </div>
    </div> --}}
    <!--==============================
Deal Area  
==============================-->
    {{-- <section class="bg-top-center space-top" data-bg-src="assets/img/bg/deal_bg_1.jpg">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img src="assets/img/theme-img/title_icon.svg" alt="Icon">Best Deals</span>
                <h2 class="sec-title text-white">Best Deals of The Week!</h2>
            </div>
            <div class="row gy-40 justify-content-center">

                <div class="col-xl-4 col-md-6">
                    <div class="th-product product-deal">
                        <div class="product-img">
                            <img src="assets/img/product/deal_card_1.jpg" alt="Product Image">
                            <div class="actions">
                                <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                <a href="cart.html" class="icon-btn"><i class="far fa-cart-plus"></i></a>
                                <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                <span>Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                            </div>
                            <h3 class="product-title"><a href="shop-details.html">Sweet Dragon Fruit</a></h3>
                            <span class="price">$08.85<del>$07.99</del></span>
                            <ul class="counter-list deal-counter" data-offer-date="01/05/2024">
                                <li>
                                    <div>
                                        <div class="day count-number">00</div>
                                        <span class="count-name">Day</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="hour count-number">00</div>
                                        <span class="count-name">Hour</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="minute count-number">00</div>
                                        <span class="count-name">Mins</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="seconds count-number">00</div>
                                        <span class="count-name">Sec</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="th-product product-deal">
                        <div class="product-img">
                            <img src="assets/img/product/deal_card_2.jpg" alt="Product Image">
                            <div class="actions">
                                <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                <a href="cart.html" class="icon-btn"><i class="far fa-cart-plus"></i></a>
                                <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                <span>Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                            </div>
                            <h3 class="product-title"><a href="shop-details.html">Papaya Vegetable Fruit</a></h3>
                            <span class="price">$18.85<del>$14.99</del></span>
                            <ul class="counter-list deal-counter" data-offer-date="01/05/2024">
                                <li>
                                    <div>
                                        <div class="day count-number">00</div>
                                        <span class="count-name">Day</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="hour count-number">00</div>
                                        <span class="count-name">Hour</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="minute count-number">00</div>
                                        <span class="count-name">Mins</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="seconds count-number">00</div>
                                        <span class="count-name">Sec</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="th-product product-deal">
                        <div class="product-img">
                            <img src="assets/img/product/deal_card_3.jpg" alt="Product Image">
                            <div class="actions">
                                <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                <a href="cart.html" class="icon-btn"><i class="far fa-cart-plus"></i></a>
                                <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                <span>Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                            </div>
                            <h3 class="product-title"><a href="shop-details.html">Six Ripe Bananas</a></h3>
                            <span class="price">$28.85<del>$20.99</del></span>
                            <ul class="counter-list deal-counter" data-offer-date="01/05/2024">
                                <li>
                                    <div>
                                        <div class="day count-number">00</div>
                                        <span class="count-name">Day</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="hour count-number">00</div>
                                        <span class="count-name">Hour</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="minute count-number">00</div>
                                        <span class="count-name">Mins</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div class="seconds count-number">00</div>
                                        <span class="count-name">Sec</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
     --}}
    <!--==============================

Testimonial Area  
==============================-->
   <?php
$testimonials = [
    [
        'text' => 'Fresh, clean, and healthy protein sources delivered right to your door. Their chicken and beef are top-notch.',
        'name' => 'Angelina Margret',
        'designation' => 'Verified Customer',
        'avatar' => 'assets/img/testimonial/testi_1_1.jpg',
    ],
    [
        'text' => 'Reliable service and neat packaging. The snails and crayfish were super fresh and tasty.',
        'name' => 'Alexan Micelito',
        'designation' => 'Frequent Buyer',
        'avatar' => 'assets/img/testimonial/testi_1_2.jpg',
    ],
    [
        'text' => 'Best place to buy eggs and chicken online. Fast delivery and quality service always!',
        'name' => 'Damilola Ade',
        'designation' => 'Returning Customer',
        'avatar' => 'assets/img/testimonial/testi_1_3.jpg',
    ],
];
?>

{{-- <section class="overflow-hidden bg-smoke2" id="testi-sec">
    <div class="shape-mockup testi-shape1" data-top="0" data-left="0">
        <img src="{{ asset('https://www.pihappiness.com/wp-content/uploads/2025/01/customer-feedback.webp') }}" alt="shape">
    </div>
    <div class="shape-mockup" data-bottom="0" data-right="0">
        <img src="{{ asset('frontend/assets/img/shape/vector_shape_5.png') }}" alt="shape">
    </div>
    <div class="container">
        <div class="testi-card-area">
            <div class="title-area">
                <span class="sub-title"><img src="{{ asset('frontend/assets/img/theme-img/title_icon.svg') }}" alt="Icon">Testimonials</span>
                <h2 class="sec-title">Our Customer Feedback</h2>
            </div>
            <div class="testi-card-slide">
                <div class="swiper th-slider" id="testiSlide1" data-slider-options='{"effect":"slide"}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="swiper-slide">
                                <div class="testi-card">
                                    <p class="testi-card_text">“<?= htmlspecialchars($testimonial['text']) ?>”</p>
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('frontend/'.$testimonial['avatar']) }}" alt="Avatar of <?= htmlspecialchars($testimonial['name']) ?>">
                                        </div>
                                        <div class="testi-card_content">
                                            <h3 class="testi-card_name"><?= htmlspecialchars($testimonial['name']) ?></h3>
                                            <span class="testi-card_desig"><?= htmlspecialchars($testimonial['designation']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="icon-box">
                    <button data-slider-prev="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                    <button data-slider-next="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</section> --}}

    <!--==============================

    @endsection
   