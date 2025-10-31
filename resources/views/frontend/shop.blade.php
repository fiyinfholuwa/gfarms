@extends('frontend.app')

@section('content')

<section class="space-top space-extra-bottom" style="background-color:#f9fafb;">
    <div class="container">

        <!-- Filter & Search Bar -->
        <div class="th-sort-bar mb-4 p-3 rounded shadow-sm" style="background:#fff;">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-auto mb-2 mb-md-0">
                    <p class="woocommerce-result-count mb-0 text-muted">
                        Showing <strong>{{ $products->firstItem() }}</strong>–<strong>{{ $products->lastItem() }}</strong> 
                        of <strong>{{ $products->total() }}</strong> results
                    </p>
                </div>

                <div class="col-md d-flex justify-content-md-end">
                    <form method="GET" action="{{ route('shop') }}" class="d-flex align-items-center gap-2">
                        <input type="text" name="search" 
                               class="form-control shadow-sm" 
                               placeholder="🔍 Search products..."
                               style="border-radius:30px; padding:8px 15px;"
                               value="{{ request('search') }}">

                        <select name="orderby" 
                                class="form-select shadow-sm" 
                                style="border-radius:30px; padding:8px 15px;">
                            <option value="">Default Sorting</option>
                            <option value="date" {{ request('orderby') == 'date' ? 'selected' : '' }}>Sort by latest</option>
                            <option value="price" {{ request('orderby') == 'price' ? 'selected' : '' }}>Price: low to high</option>
                            <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>Price: high to low</option>
                        </select>

                        <button type="submit" 
                                class="btn text-white shadow-sm" 
                                style="background:linear-gradient(90deg, #28a745, #ff8c00); border:none; border-radius:30px; padding:8px 20px;">
                            Apply
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row gy-4">
            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6">
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
            @empty
                <div class="text-center mt-5">
                    <h5 class="text-muted">No products found.</h5>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="th-pagination text-center pt-50 mt-5">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</section>

<style>
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .product-card .card-body h5:hover {
        color: #ff8c00;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(90deg, #28a745, #ff8c00);
        border: none;
    }
    .pagination .page-link {
        border-radius: 30px;
    }
</style>

@endsection
