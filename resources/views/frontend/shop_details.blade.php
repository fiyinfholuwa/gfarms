@extends('frontend.app')


@section('content')

      <section class="product-details space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-big-img">
                        <div class="img"><img src="{{ asset($food->image) }}" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="product-about">
                        <p class="price">#{{ number_format($food->amount,2) }}</p>
                        <h2 class="product-title">{{ $food->name }}</h2>
                        <div class="product-rating">
                            {{-- <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span></div> --}}
                            {{-- <a href="shop-details.html" class="woocommerce-review-link">(<span class="count">4</span> customer reviews)</a> --}}
                        </div>
                        <p class="text">
                        {!! $food->short_description !!}
                        </p>
                        <div class="mt-2 link-inherit">
                            <p>
                                <strong class="text-title me-3">Availability:</strong>
                                <span class="stock in-stock"><i class="far fa-check-square me-2 ms-1"></i>In Stock</span>
                            </p>
                        </div>
                        <div class="actions">
                            <div class="quantity">

                             <button class="btn btn-outline-secondary" type="button" onclick="updateQty({{ $food->id }}, -1)">-</button>
                    <input 
                        type="number" 
                        id="qty-{{ $food->id }}" 
                        class="form-control text-center" 
                        value="1" 
                        min="1"
                    >
                    <button class="btn btn-outline-secondary" type="button" onclick="updateQty({{ $food->id }}, 1)">+</button>
                    
                            </div>
                            <button 
                    onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})"
                    class="th-btn btn btn-success flex-fill rounded-pill">
                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                </button>

                            {{-- <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a> --}}
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div >
            <h3>Full Description</h3>
                    {!! $food->full_description !!}
                </div>
                
            <!--==============================
		Related Product  
		==============================-->
        @if (count($foods) > 0)
          <div class="space-extra-top mb-30">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-auto">
                        <h2 class="sec-title text-center">Related Products</h2>
                    </div>
                    <div class="col-md d-none d-sm-block">
                        <hr class="title-line">
                    </div>
                    <div class="col-md-auto d-none d-md-block">
                        <div class="sec-btn">
                            <div class="icon-box">
                                <button data-slider-prev="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                                <button data-slider-next="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper th-slider has-shadow" id="productSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">

@foreach($foods as $product)
                        <div class="swiper-slide">
                    <a href="{{ route('shop.detail', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm product-card h-100" 
                             style="transition:all 0.3s ease; border-radius:16px; overflow:hidden;">
                            <div class="position-relative">
                                <img src="{{ $product->image ? asset($product->image) : asset('frontend/assets/img/no-image.png') }}" 
                                     alt="{{ $product->name }}" 
                                     class="card-img-top" 
                                     style="height:250px; object-fit:cover;">
                                <span class="badge position-absolute top-0 start-0 m-2 px-3 py-2"
                                      style="background:linear-gradient(90deg,#28a745,#ff8c00); color:#fff; border-radius:30px;">
                                    {{ optional($product->cat)->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <div class="card-body text-center">
                                <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
                                <p class="text-success fw-semibold mb-2" style="color:#28a745;">
                                    ₦{{ number_format($product->amount, 2) }}
                                </p>
                                <button class="btn text-white w-100" 
                                        style="background:linear-gradient(90deg, #28a745, #ff8c00); border:none; border-radius:30px;">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
                            
                        </div>


                   

                <div class="d-block d-md-none mt-40 text-center">
                    <div class="icon-box">
                        <button data-slider-prev="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                        <button data-slider-next="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>  
        @endif
            
        </div>
    </section>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
function updateQty(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    let current = parseInt(input.value) || 1;
    current += delta;
    if (current < 1) current = 1;
    input.value = current;
}

function showAlert(message, type = "danger") {
    const wrapper = document.createElement("div");
    wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index:1055;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    document.body.appendChild(wrapper);

    setTimeout(() => {
        wrapper.querySelector(".alert").classList.remove("show");
        setTimeout(() => wrapper.remove(), 300);
    }, 3000);
}

async function addToCart(id, name, price) {
    const qty = parseInt(document.getElementById(`qty-${id}`).value) || 1;

    const response = await fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id, name, price, qty })
    });

    const result = await response.json();

    if (result.success) {
        showAlert(result.message, "success");
    } else {
        showAlert(result.message, "danger");
         // Redirect to the login page after 5 seconds
    setTimeout(function() {
        window.location.href = "{{ route('login') }}"; // Replace with the correct login route/URL
    }, 5000); // 5000 milliseconds = 5 seconds
    }

    // reset to 1 after adding
    document.getElementById(`qty-${id}`).value = 1;
}
</script>
@endsection
   