@extends('admin.app')

@section('content')
<style>
    :root {
        --primary: #ff9800; /* light orange */
        --primary-dark: #e68900;
        --accent: #16a34a; /* green */
        --accent-dark: #15803d;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg: #fffaf5;
        --bg-light: #fff;
        --border: #f3f4f6;
        --radius: 0.75rem;
        --shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    

    .order-container {
        margin: 2rem auto;
        background: var(--bg-light);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    /* Header */
    .order-header {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .order-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        padding: 0.6rem 1rem;
        border-radius: var(--radius);
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.3s;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Status badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-paid { background: #cfe2ff; color: #084298; }
    .status-confirmed { background: #e0f7fa; color: #006064; }
    .status-preparing { background: #ffe0b2; color: #e65100; }
    .status-ready, .status-delivered { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Body Sections */
    .order-body {
        padding: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        border-left: 4px solid var(--accent);
        padding-left: 0.75rem;
    }

    .info-card {
        background: #fafafa;
        padding: 1.25rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        margin-bottom: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px dashed var(--border);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-light);
        font-weight: 500;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Items */
    .order-item {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: var(--shadow);
        transition: transform 0.2s;
    }

    .order-item:hover {
        transform: translateY(-2px);
    }

    .order-item img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: var(--radius);
    }

    .item-details {
        flex: 1;
        margin-left: 1rem;
    }

    .item-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .item-meta {
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .item-total {
        font-weight: 700;
        color: var(--accent-dark);
        font-size: 1rem;
    }

    .order-total {
        text-align: right;
        margin-top: 1rem;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .notes-section {
        background: #fffaf0;
        border: 1px solid var(--border);
        border-left: 4px solid var(--primary);
        padding: 1rem;
        border-radius: var(--radius);
        margin-top: 2rem;
        font-style: italic;
        color: var(--text-light);
    }

    /* Modal override */
    .modal-header {
        background: var(--primary-dark);
        color: #fff;
    }

    .btn-orange {
        background: var(--primary);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: var(--radius);
        padding: 0.8rem;
        width: 100%;
        transition: background 0.2s;
    }

    .btn-orange:hover {
        background: var(--primary-dark);
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .info-row {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="order-container">
    <!-- Header -->
    <div class="order-header">
        <h2>Order #{{ $order->order_number }}</h2>
        <a href="{{ route('admin.orders') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Orders</a>
    </div>

    <div class="order-body">
        <!-- Status -->
        <div class="status-badge status-{{ $order->status }}">
            <i class="fas fa-circle"></i> {{ ucfirst($order->status) }}
        </div>

        <!-- Order Info -->
        <h3 class="section-title">Order Information</h3>
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Order Date</span>
                <span class="info-value">{{ $order->created_at->format('M d, Y - h:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method</span>
                <span class="info-value">{{ ucfirst($order->payment_method ?? 'Not Set') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Delivery Address</span>
                <span class="info-value">{{ $order->delivery_address ?? 'Not Set' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Delivered On</span>
                <span class="info-value">
                    {{ $order->delivered_at ? $order->delivered_at->format('M d, Y - h:i A') : 'Not Delivered' }}
                </span>
            </div>
        </div>

        <!-- Items -->
        <h3 class="section-title">Items Ordered</h3>
        @foreach($order->items as $item)
            <div class="order-item">
                <img src="{{ get_product_image($item['id']) }}" alt="{{ $item['name'] }}">
                <div class="item-details">
                    <div class="item-name">{{ $item['name'] }}</div>
                    <div class="item-meta">Qty: {{ $item['qty'] }} | ₦{{ number_format($item['price']) }}</div>
                </div>
                <div class="item-total">₦{{ number_format($item['total']) }}</div>
            </div>
        @endforeach

        <div class="order-total">Total: ₦{{ number_format($order->total_amount) }}</div>

        <!-- Notes -->
        @if($order->notes)
            <div class="notes-section">
                <strong>Note:</strong> {{ $order->notes }}
            </div>
        @endif
    </div>
</div>

<!-- Processing Fee Modal -->
<div class="modal fade" id="processingFeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title">Processing Fee</h5>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">You must pay a <strong>₦1,000 processing fee</strong> to continue.</p>
        <div class="form-check text-start mb-2">
          <input class="form-check-input" type="radio" name="gateway" id="paystack" value="paystack" checked>
          <label for="paystack" class="form-check-label">Pay with Paystack</label>
        </div>
        <div class="form-check text-start mb-2">
          <input class="form-check-input" type="radio" name="gateway" id="fincra" value="fincra">
          <label for="fincra" class="form-check-label">Pay with Fincra</label>
        </div>
        <div class="form-check text-start">
          <input class="form-check-input" type="radio" name="gateway" id="wallet" value="wallet">
          <label for="wallet" class="form-check-label">Pay with Wallet</label>
        </div>
      </div>
      <div class="modal-footer">
        <button id="proceedPaymentBtn" class="btn-orange">Proceed to Payment</button>
      </div>
    </div>
  </div>
</div>
@endsection
