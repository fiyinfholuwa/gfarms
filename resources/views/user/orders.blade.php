<?php
// Orders Index View - CORRECTED
// Create: resources/views/user/orders/index.blade.php
?>

@extends('user.app')

@section('content')
<style>
    .orders-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .orders-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .back-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .back-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .orders-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .order-card {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .order-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-info h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .order-meta {
        font-size: 0.875rem;
        color: var(--text-secondary);
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: capitalize;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-preparing { background: #e0e7ff; color: #3730a3; }
    .status-ready { background: #dcfce7; color: #166534; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .order-content {
        padding: 1.5rem;
    }

    .order-items {
        margin-bottom: 1rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--bg-tertiary);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .item-details {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .item-total {
        font-weight: 600;
        color: var(--primary-color);
    }

    .order-total {
        text-align: right;
        padding-top: 1rem;
        border-top: 2px solid var(--border-color);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: var(--danger-color);
        color: white;
    }

    .btn-cancel:hover {
        background: var(--danger-dark);
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-actions {
            justify-content: flex-start;
        }

        .orders-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container">
    <div class="orders-header">
        <h1 class="orders-title">My Orders</h1>
        <a href="{{ route('user.packages') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Market
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="orders-grid">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>{{ $order->order_number }}</h3>
                            <div class="order-meta">
                                <span><i class="fas fa-calendar"></i> {{ $order->created_at->format('M j, Y \a\t g:i A') }}</span>
                                <span><i class="fas fa-utensils"></i> {{ count($order->items) }} item(s)</span>
                            </div>
                        </div>
                        <span class="order-status status-{{ $order->status }}">
                            @switch($order->status)
                                @case('pending')
                                    <i class="fas fa-clock"></i> Pending
                                    @break
                                @case('confirmed')
                                    <i class="fas fa-check-circle"></i> Confirmed
                                    @break
                                @case('preparing')
                                    <i class="fas fa-fire"></i> Preparing
                                    @break
                                @case('ready')
                                    <i class="fas fa-check-double"></i> Ready
                                    @break
                                @case('delivered')
                                    <i class="fas fa-shipping-fast"></i> Delivered
                                    @break
                                @case('cancelled')
                                    <i class="fas fa-times-circle"></i> Cancelled
                                    @break
                            @endswitch
                        </span>
                    </div>

                    <div class="order-content">
                        <div class="order-items">
                            @foreach($order->items as $item)
                                <div class="order-item">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item['name'] }}</div>
                                        <div class="item-details">
                                            ₦{{ number_format($item['price'], 2) }} × {{ $item['qty'] }}
                                        </div>
                                    </div>
                                    <div class="item-total">
                                        ₦{{ number_format($item['total'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-total">
                            Total: ₦{{ number_format($order->total_amount, 2) }}
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('user.orders.show', $order) }}" class="action-btn btn-view">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            
                            @if(in_array($order->status, ['pending', 'confirmed']))
                                <form action="{{ route('user.orders.cancel', $order) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn btn-cancel">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🍽️</div>
            <h3>No orders yet</h3>
            <p>When you place your first order, it will appear here.</p>
            <a href="{{ route('user.food-market') }}" class="back-btn" style="margin-top: 1.5rem;">
                <i class="fas fa-shopping-cart"></i>
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection

