<?php
// Orders Index View - Mobile-Inclined Layout
// Create: resources/views/user/orders/index.blade.php
?>

@extends('user_new.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold fs-4">My Orders</h2>
        <a href="{{ route('user.packages') }}" class="text-decoration-none small fw-semibold text-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card mb-3 p-3 rounded shadow-sm bg-white">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold text-dark">{{ $order->order_number }}</h6>
                        <span class="badge bg-light text-dark small">
                            @switch($order->status)
                                @case('pending') <i class="fas fa-clock text-warning"></i> Pending @break
                                @case('confirmed') <i class="fas fa-check-circle text-success"></i> Confirmed @break
                                @case('preparing') <i class="fas fa-fire text-danger"></i> Preparing @break
                                @case('ready') <i class="fas fa-check-double text-info"></i> Ready @break
                                @case('delivered') <i class="fas fa-shipping-fast text-success"></i> Delivered @break
                                @case('cancelled') <i class="fas fa-times-circle text-danger"></i> Cancelled @break
                            @endswitch
                        </span>
                    </div>

                    <!-- Meta Info -->
                    <div class="small text-muted mb-2">
                        <div><i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('M j, Y g:i A') }}</div>
                        <div><i class="fas fa-naira-sign me-1"></i>₦{{ number_format($order->total_amount, 2) }}</div>
                    </div>

                    <!-- Action -->
                    <a href="{{ route('user.orders.show', $order->order_number) }}" 
                       class="btn btn-sm btn-warning w-100">
                        <i class="fas fa-eye me-1"></i> View Detail
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state text-center p-5">
            <h5 class="fw-bold text-secondary mb-2">No Orders Yet</h5>
            <p class="text-muted small mb-3">Your delicious journey starts here. Place your first order and it will show up below.</p>
            <a href="{{ route('user.packages') }}" 
               class="btn btn-primary px-3 py-2 rounded-pill shadow-sm btn-sm">
                <i class="fas fa-shopping-cart me-1"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
    .order-card {
        border: 1px solid #f0f0f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .empty-state {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        max-width: 400px;
        margin: 2rem auto;
    }
    @media (max-width: 576px) {
        .order-card h6 {
            font-size: 0.95rem;
        }
        .order-card .small {
            font-size: 0.8rem;
        }
        .btn-sm {
            font-size: 0.85rem;
        }
    }
</style>
@endsection
