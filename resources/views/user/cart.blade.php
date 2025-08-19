@extends('user.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
    /* 🔥 Primary Theme - Dark Orange */
    --primary-color: #d97706;   /* Dark Orange */
    --primary-dark: #92400e;    /* Even darker shade of orange */

    /* ✅ Success */
    --success-color: #000000;   /* Black (for success buttons) */
    --success-dark: #1f2937;    /* Dark gray-black */

    /* ❌ Danger (Red tones) */
    --danger-color: #ef4444;  
    --danger-dark: #b91c1c;

    /* ⚠️ Warning (Still orange-ish, lighter than primary) */
    --warning-color: #f59e0b;  
    --warning-dark: #b45309;

    /* 📝 Text Colors */
    --text-primary: #1f2937;    /* Dark gray (almost black) */
    --text-secondary: #6b7280;  /* Medium gray */

    /* 🎨 Backgrounds */
    --bg-primary: #ffffff;
    --bg-secondary: #f9fafb;
    --bg-tertiary: #f3f4f6;

    /* 🪟 Borders & Shadows */
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);

    /* 🔲 Border Radius */
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
}

    /* Main Content */
    .main-content {
        padding: 2rem 0;
        min-height: 70vh;
    }

    .section-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cart-count {
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .clear-cart-btn {
        background: var(--danger-color);
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
    }

    .clear-cart-btn:hover {
        background: var(--danger-dark);
        transform: translateY(-1px);
    }

    /* Cart Items */
    .cart-container {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
        align-items: start;
    }

    .cart-items {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        margin-bottom: 1rem;
        background: var(--bg-primary);
        transition: all 0.2s ease;
    }

    .cart-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    .cart-item:last-child {
        margin-bottom: 0;
    }

    .item-image {
        width: 80px;
        height: 80px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 2rem;
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .item-price {
        font-size: 1rem;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .item-subtotal {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .item-controls {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--bg-primary);
    }

    .qty-btn {
        background: var(--bg-tertiary);
        border: none;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        color: var(--text-primary);
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--border-color);
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .qty-input {
        border: none;
        width: 3.5rem;
        text-align: center;
        padding: 0.5rem;
        font-weight: 600;
        height: 2.5rem;
        background: var(--bg-primary);
    }

    .qty-input:focus {
        outline: none;
        background: var(--bg-secondary);
    }

    .remove-btn {
        background: var(--danger-color);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
    }

    .remove-btn:hover {
        background: var(--danger-dark);
        transform: scale(1.05);
    }

    /* Cart Summary */
    .cart-summary {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .summary-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: 600;
        font-size: 1.125rem;
        color: var(--text-primary);
    }

    .summary-label {
        color: var(--text-secondary);
    }

    .summary-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    .limit-info {
        background: var(--warning-color);
        color: white;
        padding: 0.75rem;
        border-radius: var(--radius-md);
        margin: 1rem 0;
        font-size: 0.875rem;
        text-align: center;
    }

    .checkout-btn {
        width: 100%;
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .checkout-btn:hover:not(:disabled) {
        background: var(--success-dark);
        transform: translateY(-1px);
    }

    .checkout-btn:disabled {
        background: var(--text-secondary);
        cursor: not-allowed;
        transform: none;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-cart-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-cart h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-cart p {
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .continue-shopping-btn {
        background: black;
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .continue-shopping-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Alerts */
    .alert {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        color: white;
        font-weight: 600;
        z-index: 1000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    }

    .alert.show {
        transform: translateX(0);
    }

    .alert.error {
        background: var(--danger-color);
    }

    .alert.success {
        background: var(--success-color);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .cart-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .item-controls {
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
        }

        .section-title {
            font-size: 1.75rem;
        }
    }
</style>

<div class="container">
    <div class="main-content">
        <div class="section-header">
            <h1 class="section-title">
                 Cart Items
                <span class="cart-count" id="cart-count">
                    {{ collect($carts)->sum(function($cart) { return collect($cart['items'])->sum('qty'); }) }}
                </span>
            </h1>
            @if(!empty($carts) && !empty($carts[0]['items']))
                <button class="clear-cart-btn" onclick="clearCart()">
                     Clear Cart
                </button>
            @endif
        </div>

        @if(empty($carts) || empty($carts[0]['items']))
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Add some delicious items to get started!</p>
                <a href="{{ route('user.packages') }}" class="continue-shopping-btn">
                    Browse Menu
                </a>
            </div>
        @else
            @php
                $cartItems = $carts[0]['items'];
                $totalAmount = collect($cartItems)->sum('total');
                $totalItems = collect($cartItems)->sum('qty');
                $limit = 20000;
            @endphp

            <div class="cart-container">
                <div class="cart-items">
                    @foreach($cartItems as $id => $item)
                        <div class="cart-item" id="cart-item-{{ $id }}">
                            <div class="item-image">
                                
                            </div>
                            
                            <div class="item-details">
                                <h3 class="item-name">{{ $item['name'] }}</h3>
                                <div class="item-price">₦{{ number_format($item['price']) }}</div>
                                <div class="item-subtotal">
                                    Subtotal: ₦{{ number_format($item['total']) }}
                                </div>
                            </div>

                            <div class="item-controls">
                                <div class="qty-control">
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, {{ $item['qty'] - 1 }})" 
                                            {{ $item['qty'] <= 1 ? 'disabled' : '' }}>-</button>
                                    <input type="number" class="qty-input" value="{{ $item['qty'] }}" 
                                           min="1" max="50" id="qty-input-{{ $id }}"
                                           onchange="updateQuantity({{ $id }}, this.value)">
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, {{ $item['qty'] + 1 }})">+</button>
                                </div>
                                
                                <button class="remove-btn" onclick="removeFromCart({{ $id }})" title="Remove item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span class="summary-label">Items ({{ $totalItems }})</span>
                        <span class="summary-value" id="items-total">₦{{ number_format($totalAmount) }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Delivery</span>
                        <span class="summary-value">#1000</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Total</span>
                        <span id="grand-total">₦{{ number_format($totalAmount) }}</span>
                    </div>

                    <div class="limit-info">
                        ⚠️ Spending limit: ₦{{ number_format($limit) }}
                        <br>
                        Remaining: ₦{{ number_format($limit - $totalAmount) }}
                    </div>

                    <button class="checkout-btn" {{ $totalAmount > $limit ? 'disabled' : '' }} onclick="checkout()">
                        <span>🛍️ Proceed to Checkout</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const LIMIT = 20000;

function showAlert(message, type = 'error') {
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => alert.classList.add('show'), 100);
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => document.body.removeChild(alert), 300);
    }, 3000);
}

function setLoading(element, isLoading) {
    if (isLoading) {
        element.classList.add('loading');
        const spinner = element.querySelector('.spinner') || document.createElement('div');
        spinner.className = 'spinner';
        element.appendChild(spinner);
    } else {
        element.classList.remove('loading');
        const spinner = element.querySelector('.spinner');
        if (spinner) spinner.remove();
    }
}

async function updateQuantity(id, newQty) {
    newQty = parseInt(newQty);
    
    if (newQty < 1 || newQty > 50) {
        showAlert('Invalid quantity. Must be between 1 and 50.', 'error');
        document.getElementById(`qty-input-${id}`).value = document.getElementById(`qty-input-${id}`).dataset.original || 1;
        return;
    }

    const cartItem = document.getElementById(`cart-item-${id}`);
    setLoading(cartItem, true);

    try {
        const response = await fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({ id, qty: newQty })
        });

        const result = await response.json();

        if (result.success) {
            showAlert(result.message, "success");
            // Reload page to reflect changes
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showAlert(result.message, "error");
            // Reset quantity input to original value
            const qtyInput = document.getElementById(`qty-input-${id}`);
            qtyInput.value = qtyInput.dataset.original || 1;
        }
    } catch (error) {
        console.error('Error updating cart:', error);
        showAlert('Failed to update cart. Please try again.', 'error');
    } finally {
        setLoading(cartItem, false);
    }
}

async function removeFromCart(id) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    const cartItem = document.getElementById(`cart-item-${id}`);
    setLoading(cartItem, true);

    try {
        const response = await fetch("{{ route('cart.remove') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({ id })
        });

        const result = await response.json();

        if (result.success) {
            showAlert(result.message, "success");
            // Smoothly remove the item
            cartItem.style.transform = 'translateX(-100%)';
            cartItem.style.opacity = '0';
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            showAlert(result.message, "error");
        }
    } catch (error) {
        console.error('Error removing item:', error);
        showAlert('Failed to remove item. Please try again.', 'error');
    } finally {
        setLoading(cartItem, false);
    }
}

async function clearCart() {
    if (!confirm('Are you sure you want to clear your entire cart?')) {
        return;
    }

    const clearBtn = document.querySelector('.clear-cart-btn');
    setLoading(clearBtn, true);

    try {
        const response = await fetch("{{ route('cart.clear') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({})
        });

        const result = await response.json();

        if (result.success) {
            showAlert(result.message, "success");
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showAlert(result.message, "error");
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
        showAlert('Failed to clear cart. Please try again.', 'error');
    } finally {
        setLoading(clearBtn, false);
    }
}

async function checkout() {
    const checkoutBtn = document.querySelector('.checkout-btn');
    
    if (checkoutBtn.disabled) {
        showAlert('Cannot checkout: Amount exceeds limit', 'error');
        return;
    }

    // Collect cart data from the page
    const cartItems = [];
    const cartItemElements = document.querySelectorAll('.cart-item');
    
    cartItemElements.forEach((element, index) => {
        const id = element.id.split('-')[2]; // extract id from cart-item-{id}
        const name = element.querySelector('.item-name').textContent.trim();
        const priceText = element.querySelector('.item-price').textContent.replace('₦', '').replace(',', '');
        const price = parseInt(priceText);
        const qty = parseInt(element.querySelector('.qty-input').value);
        const total = price * qty;
        
        cartItems.push({
            id: parseInt(id),
            name: name,
            qty: qty,
            price: price,
            total: total
        });
    });

    if (cartItems.length === 0) {
        showAlert('Your cart is empty', 'error');
        return;
    }

    const totalAmount = cartItems.reduce((sum, item) => sum + item.total, 0);
    
    // Optional: Add notes functionality
    const notes = prompt('Any special instructions or notes? (Optional)') || '';

    setLoading(checkoutBtn, true);
    checkoutBtn.disabled = true;

    try {
        const response = await fetch("{{ route('checkout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                items: cartItems,
                total_amount: totalAmount,
                notes: notes
            })
        });

        const result = await response.json();

        if (result.success) {
            showAlert(`✅ ${result.message}`, "success");
            
            // Show order details briefly
            setTimeout(() => {
                showAlert(`🎉 Order #${result.order.order_number} created successfully!`, "success");
            }, 1000);

            // Redirect to manage orders page with the order ID
            setTimeout(() => {
                window.location.href = `/orders/${result.order.order_number}`;
                
                // Option 2: Redirect to specific order page
                // window.location.href = `/orders/${result.order.id}`;
                
                // Option 3: Redirect to manage orders page
                // window.location.href = `/manage-orders`;
                
                // Option 4: Stay on current page and reload to show empty cart
                // window.location.reload();
            }, 2500);

        } else {
            showAlert(`❌ ${result.message}`, "error");
            checkoutBtn.disabled = false;
        }
    } catch (error) {
        console.error('Checkout error:', error);
        showAlert('❌ Failed to place order. Please check your connection and try again.', 'error');
        checkoutBtn.disabled = false;
    } finally {
        setLoading(checkoutBtn, false);
    }
}
// Store original quantities for reset functionality
document.addEventListener('DOMContentLoaded', function() {
    const qtyInputs = document.querySelectorAll('.qty-input');
    qtyInputs.forEach(input => {
        input.dataset.original = input.value;
    });
});
</script>
@endsection