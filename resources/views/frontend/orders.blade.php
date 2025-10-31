@extends('frontend.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold fs-4 text-success mb-2">My Orders</h2>
        <a href="{{ route('shop') }}" class="text-decoration-none small fw-semibold text-orange">
            <i class="fas fa-arrow-left me-1"></i> Back to Shop
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="orders-grid">
            @foreach($orders as $order)
                <div class="order-card rounded shadow-sm bg-white">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <h6 class="mb-0 fw-bold text-dark">#{{ $order->order_number }}</h6>
                        <span class="badge status-badge 
                            @switch($order->status)
                                @case('pending') bg-warning text-dark @break
                                @case('Approved') bg-success text-white @break
                                @case('preparing') bg-orange text-white @break
                                @case('ready') bg-info text-white @break
                                @case('delivered') bg-success text-white @break
                                @case('cancelled') bg-secondary text-white @break
                                @default bg-light text-dark
                            @endswitch">
                            @switch($order->status)
                                @case('paid') <i class="fas fa-clock me-1"></i> Payment Confirmed @break
                                @case('pending') <i class="fas fa-hourglass-half me-1"></i> Pending @break
                                @case('Approved') <i class="fas fa-check-circle me-1"></i> Approved @break
                                @case('preparing') <i class="fas fa-fire me-1"></i> Preparing @break
                                @case('ready') <i class="fas fa-truck me-1"></i> Out for Delivery @break
                                @case('delivered') <i class="fas fa-box-open me-1"></i> Delivered @break
                                @case('cancelled') <i class="fas fa-times-circle me-1"></i> Cancelled @break
                                @default Unknown
                            @endswitch
                        </span>
                    </div>

                    <!-- Meta Info -->
                    <div class="small text-muted mb-3">
                        <div class="mb-1">
                            <i class="fas fa-calendar me-1 text-orange"></i> 
                            {{ $order->created_at->format('M j, Y g:i A') }}
                        </div>
                        <div>
                            <i class="fas fa-naira-sign me-1 text-success"></i> 
                            ₦{{ number_format($order->total_amount, 2) }}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.orders.show', $order->order_number) }}" 
                           class="btn btn-sm btn-outline-success flex-fill">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>

                        @if($order->status === 'pending')
                            <button class="btn btn-sm btn-outline-orange flex-fill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteOrderModal_{{ $order->id }}">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteOrderModal_{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-orange text-white">
                                <h5 class="modal-title">Delete Order</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center py-4">
                                <i class="fas fa-exclamation-triangle text-orange fs-3 mb-3"></i>
                                <p>Are you sure you want to delete order 
                                    <strong>#{{ $order->order_number }}</strong>?
                                </p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('user.orders.delete', $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-orange">
                                        <i class="fas fa-trash"></i> Confirm Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state text-center p-5">
            <h5 class="fw-bold text-success mb-2">No Orders Yet</h5>
            <p class="text-muted small mb-3">Your journey starts with your first order. Browse and shop now.</p>
            <a href="{{ route('shop') }}" 
               class="btn btn-orange px-3 py-2 rounded-pill shadow-sm btn-sm">
                <i class="fas fa-shopping-cart me-1"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
    :root {
        --orange: #f79c42;
        --orange-hover: #e7892d;
        --light-orange: #fff5ec;
        --green: #2e8b57;
    }

    .text-orange { color: var(--orange) !important; }
    .bg-orange { background-color: var(--orange) !important; }

    .btn-orange {
        background: var(--orange);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-orange:hover { background: var(--orange-hover); }

    .btn-outline-orange {
        border: 1px solid var(--orange);
        color: var(--orange);
        transition: all 0.3s ease;
    }
    .btn-outline-orange:hover {
        background: var(--orange);
        color: #fff;
    }

    .orders-grid {
        display: grid;
        gap: 1.2rem;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }

    .order-card {
        padding: 1.25rem;
        border: 1px solid #f1f1f1;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        border-color: var(--light-orange);
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.7rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .empty-state {
        background: #fff;
        border-radius: 1rem;
        border: 1px solid #eee;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        max-width: 420px;
        margin: 4rem auto;
    }

    .pagination .page-link {
        color: var(--green);
        border-radius: 6px;
    }
    .pagination .active .page-link {
        background-color: var(--green);
        border-color: var(--green);
    }

    @media (max-width: 576px) {
        .order-card h6 { font-size: 1rem; }
        .order-card .small { font-size: 0.85rem; }
        .btn-sm { font-size: 0.9rem; }
    }
</style>
@endsection
