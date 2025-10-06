@extends('user_new.app')

@section('content')

<!-- Breadcrumb / Title Section -->
<section class="section-t-space">
    <div class="custom-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ route('user.packages') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $food->name }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold">{{ $food->name }}</h2>
    </div>
</section>

<!-- Product Image -->
<section>
    <div class="custom-container text-center">
        <div class="card shadow-sm border-0 rounded-3">
            <img 
                class="img-fluid rounded-top" 
                src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                alt="{{ $food->name }}" 
                style="max-height: 400px; object-fit: cover; width: 100%;"
            />
        </div>
    </div>
</section>

<!-- Product Details -->
<section class="py-4">
    <div class="custom-container">
        <div class="card border-0 shadow-sm rounded-3 p-4">
            
            <!-- Product Title + Category -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ $food->name }}</h3>
                    @if($food->cat)
                        <span class="badge bg-secondary">{{ $food->cat->name }}</span>
                    @endif
                </div>
                <h3 class="text-success fw-bold">₦{{ number_format($food->amount, 2) }}</h3>
            </div>

            <!-- Short Description -->
            <p class="mt-3 text-muted">{!! $food->short_description !!}</p>

            <!-- Quantity Selector + Add to Cart -->
            <div class="mt-4 d-flex align-items-center gap-2">
                <div class="input-group" style="width: 140px;">
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
                    class="btn btn-success flex-fill rounded-pill">
                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                </button>
            </div>

            <!-- Accordion for Full Details -->
            <div class="accordion details-accordion mt-4" id="accordionPanelsStayOpenExample">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingThree">
                        <button 
                            class="accordion-button collapsed fw-bold" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#panelsStayOpen-p3"
                            aria-expanded="false" 
                            aria-controls="panelsStayOpen-p3">
                            More Details
                        </button>
                    </h2>
                    <div id="panelsStayOpen-p3" class="accordion-collapse collapse" aria-labelledby="headingThree">
                        <div class="accordion-body">
                            <p class="text-muted">{!! nl2br(e($food->full_description)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
        showAlert(result.message, "error");
    }

    // reset to 1 after adding
    document.getElementById(`qty-${id}`).value = 1;
}
</script>

@endsection
