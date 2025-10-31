@extends('frontend.app')


@section('content')

  <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">About Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-organic-farm.html">Home</a></li>
                    <li>About Us</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
About Area  
==============================-->
    <div class="overflow-hidden overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 mb-30 mb-xl-0">
                    <div class="img-box1">
                        <div class="img1">
                            <img src="assets/img/normal/about_1_1.jpg" alt="About">
                        </div>
                        <div class="img2">
                            <img src="assets/img/normal/about_1_2.jpg" alt="Image">
                        </div>
                        <div class="shape1 movingX">
                            <img src="assets/img/normal/about_1_3.png" alt="Image">
                        </div>
                        <div class="year-counter">
                            <div class="year-counter_number"><span class="counter-number">23</span>+</div>
                            <p class="year-counter_text">Years Experience</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xxl-5 ps-xl-2 ms-xl-1 text-center text-xl-start">
                        <div class="title-area mb-32">
                            <span class="sub-title"><img src="assets/img/theme-img/title_icon.svg" alt="shape">About Our Company</span>
                            <h2 class="sec-title">Eating Right Start With Organic Food</h2>
                            <p class="sec-text">Organic foods are produced through a farming system that avoids the use of synthetic pesticides, herbicides, genetically modified organism (GMOs), and artificial fertilizers. Instead, organic farmers rely on natural methods like crop rotation. composting, and biological pest control.</p>
                        </div>
                        <div class="about-feature-wrap">
                            <div class="about-feature">
                                <div class="box-icon">
                                    <img src="assets/img/icon/about_feature_1.svg" alt="Icon">
                                </div>
                                <h3 class="box-title">The Agriculture Leader</h3>
                            </div>
                            <div class="about-feature">
                                <div class="box-icon">
                                    <img src="assets/img/icon/about_feature_2.svg" alt="Icon">
                                </div>
                                <h3 class="box-title">Smart Organic Solutions</h3>
                            </div>
                        </div>
                        <div>
                            <a href="about.html" class="th-btn">Discover More<i class="fas fa-chevrons-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
Process Area  
==============================-->
    <section class="space bg-smoke2" id="process-sec">
        <div class="shape-mockup" data-top="0" data-left="0"><img src="assets/img/shape/vector_shape_7.png" alt="shape"></div>
        <div class="shape-mockup" data-bottom="0" data-right="0"><img src="assets/img/shape/vector_shape_6.png" alt="shape"></div>
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img src="assets/img/theme-img/title_icon.svg" alt="Icon">How We Make Quality Foods</span>
                <h2 class="sec-title">How We Work It?</h2>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3 col-md-6 process-box-wrap">
                    <div class="process-box">
                        <div class="box-icon">
                            <img src="assets/img/icon/process_box_1.svg" alt="icon">
                        </div>
                        <div class="box-img" data-mask-src="assets/img/bg/process_bg_shape.png">
                            <img src="assets/img/normal/process_box_1.jpg" alt="image">
                        </div>
                        <p class="box-number">Step - 01</p>
                        <h3 class="box-title">Work Planning</h3>
                        <p class="box-text">Begin by conducting thorough soil tests to understand its composition, pH levels, and nutrient.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 process-box-wrap">
                    <div class="process-box">
                        <div class="box-icon">
                            <img src="assets/img/icon/process_box_2.svg" alt="icon">
                        </div>
                        <div class="box-img" data-mask-src="assets/img/bg/process_bg_shape.png">
                            <img src="assets/img/normal/process_box_2.jpg" alt="image">
                        </div>
                        <p class="box-number">Step - 02</p>
                        <h3 class="box-title">Farm Growing</h3>
                        <p class="box-text">Begin by conducting thorough soil tests to understand its composition, pH levels, and nutrient.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 process-box-wrap">
                    <div class="process-box">
                        <div class="box-icon">
                            <img src="assets/img/icon/process_box_3.svg" alt="icon">
                        </div>
                        <div class="box-img" data-mask-src="assets/img/bg/process_bg_shape.png">
                            <img src="assets/img/normal/process_box_3.jpg" alt="image">
                        </div>
                        <p class="box-number">Step - 03</p>
                        <h3 class="box-title">Crop Harvesting</h3>
                        <p class="box-text">Begin by conducting thorough soil tests to understand its composition, pH levels, and nutrient.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 process-box-wrap">
                    <div class="process-box">
                        <div class="box-icon">
                            <img src="assets/img/icon/process_box_4.svg" alt="icon">
                        </div>
                        <div class="box-img" data-mask-src="assets/img/bg/process_bg_shape.png">
                            <img src="assets/img/normal/process_box_4.jpg" alt="image">
                        </div>
                        <p class="box-number">Step - 04</p>
                        <h3 class="box-title">Food Processing</h3>
                        <p class="box-text">Begin by conducting thorough soil tests to understand its composition, pH levels, and nutrient.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
Counter Area  
==============================-->
    <div class="counter-sec11" data-bg-src="assets/img/bg/counter_bg_1_1.jpg">
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
    </div><!--==============================
    <section class="overflow-hidden bg-smoke2" id="testi-sec">
        <div class="shape-mockup testi-shape1" data-top="0" data-left="0"><img src="assets/img/normal/testi_shape.png" alt="shape"></div>
        <div class="shape-mockup" data-bottom="0" data-right="0"><img src="assets/img/shape/vector_shape_5.png" alt="shape"></div>
        <div class="container">
            <div class="testi-card-area">
                <div class="title-area">
                    <span class="sub-title"><img src="assets/img/theme-img/title_icon.svg" alt="Icon">Testimonials</span>
                    <h2 class="sec-title">Our Customer Feedback</h2>
                </div>
                <div class="testi-card-slide">
                    <div class="swiper th-slider" id="testiSlide1" data-slider-options='{"effect":"slide"}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testi-card">
                                    <p class="testi-card_text">“Our organic farming practices work in harmony with nature. By avoiding synthetic chemicals, we help protect beneficial insects, birds, and other wildlife that are vital to a balanced ecosystem.
                                        Organic foods often have a richer”</p>
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="Avater">
                                        </div>
                                        <div class="testi-card_content">
                                            <h3 class="testi-card_name">Angelina Margret</h3>
                                            <span class="testi-card_desig">Customer of Our Shop</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testi-card">
                                    <p class="testi-card_text">“Fresh Food farming practices work in harmony with nature. By avoiding synthetic chemicals, we help protect beneficial insects, birds, and other wildlife that are vital to a balanced ecosystem.
                                        Organic foods help to be fit.”</p>
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_2.jpg" alt="Avater">
                                        </div>
                                        <div class="testi-card_content">
                                            <h3 class="testi-card_name">Alexan Micelito</h3>
                                            <span class="testi-card_desig">Customer of Our Shop</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="icon-box">
                        <button data-slider-prev="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                        <button data-slider-next="#testiSlide1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================


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
                                <h3 class="box-title">Top-Grade Quality</h3>
                                <p class="box-text">All our products are sourced with strict quality assurance to ensure top nutrition.</p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_2.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Freshly Delivered</h3>
                                <p class="box-text">We deliver fresh chicken, beef, eggs, and more right to your doorstep—fast and safe.</p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_3.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Trusted by Families</h3>
                                <p class="box-text">Thousands of households rely on us for their daily protein and grocery needs.</p>
                            </div>
                            <div class="choose-feature">
                                <div class="box-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/choose_feature_4.svg') }}" alt="Icon">
                                </div>
                                <h3 class="box-title">Secure Payment</h3>
                                <p class="box-text">Shop safely on our platform with secure payment gateways and data protection.</p>
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

<section class="overflow-hidden bg-smoke2" id="testi-sec">
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
</section>

    <!--==============================

@endsection
   