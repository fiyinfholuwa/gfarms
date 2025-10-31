@extends('frontend.app')

@section('content')
<style>
    :root {
        --primary-color: #d97706;
        --primary-dark: #92400e;
        --success-color: #000000;
        --success-dark: #1f2937;
        --danger-color: #ef4444;
        --danger-dark: #b91c1c;
        --warning-color: #f59e0b;
        --warning-dark: #b45309;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }
    .main-content { padding: 2rem 0; min-height: 70vh; }
    .section-header { margin-bottom: 2rem; display:flex; justify-content:space-between; align-items:center; }
    .section-title { font-size: 1rem; font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:0.75rem; }
    .cart-count { background:var(--primary-color); color:white; border-radius:50%; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:600; }
    .clear-cart-btn { background:var(--danger-color); color:white; border:none; border-radius:var(--radius-lg); padding:0.75rem 1.25rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; gap:0.5rem; }
    .clear-cart-btn:hover { background:var(--danger-dark); transform:translateY(-1px); }
    .cart-container { display:grid; grid-template-columns:1fr 300px; gap:2rem; align-items:start; }
    .cart-items { background:var(--bg-primary); border-radius:var(--radius-xl); padding:1.5rem; box-shadow:var(--shadow-sm); border:1px solid var(--border-color); }
    .cart-item { display:flex; align-items:center; gap:1rem; padding:1.25rem; border:1px solid var(--border-color); border-radius:var(--radius-lg); margin-bottom:1rem; background:var(--bg-primary); transition:all 0.2s ease; }
    .cart-item:hover { box-shadow:var(--shadow-md); transform:translateY(-1px); }
    .cart-item:last-child { margin-bottom:0; }
    .item-image { width:80px; height:80px; background:var(--bg-tertiary); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:var(--text-secondary); font-size:2rem; flex-shrink:0; overflow:hidden; }
    .item-image img { width:100%; height:100%; object-fit:cover; }
    .item-details { flex:1; }
    .item-name { font-size:1.125rem; font-weight:600; color:var(--text-primary); margin-bottom:0.25rem; }
    .item-price { font-size:1rem; color:var(--primary-color); font-weight:600; margin-bottom:0.5rem; }
    .item-subtotal { font-size:0.875rem; color:var(--text-secondary); }
    .item-controls { display:flex; flex-direction:column; align-items:center; gap:0.75rem; }
    .qty-control { display:flex; align-items:center; border:1px solid var(--border-color); border-radius:var(--radius-md); overflow:hidden; background:var(--bg-primary); }
    .qty-btn { background:var(--bg-tertiary); border:none; padding:0.5rem 0.75rem; cursor:pointer; transition:all 0.2s ease; font-weight:600; color:var(--text-primary); width:2.5rem; height:2.5rem; display:flex; align-items:center; justify-content:center; }
    .qty-btn:hover:not(:disabled) { background:var(--border-color); }
    .qty-btn:disabled { opacity:0.5; cursor:not-allowed; }
    .qty-input { border:none; width:3.5rem; text-align:center; padding:0.5rem; font-weight:600; height:2.5rem; background:var(--bg-primary); }
    .qty-input:focus { outline:none; background:var(--bg-secondary); }
    .remove-btn { background:var(--danger-color); color:white; border:none; border-radius:var(--radius-md); padding:0.5rem; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; justify-content:center; width:2.5rem; height:2.5rem; }
    .remove-btn:hover { background:var(--danger-dark); transform:scale(1.05); }
    .cart-summary { background:var(--bg-primary); border-radius:var(--radius-xl); padding:1.5rem; box-shadow:var(--shadow-sm); border:1px solid var(--border-color); height:fit-content; position:sticky; top:2rem; }
    .summary-title { font-size:1.25rem; font-weight:600; margin-bottom:1rem; color:var(--text-primary); }
    .summary-row { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; border-bottom:1px solid var(--border-color); }
    .summary-row:last-child { border-bottom:none; font-weight:600; font-size:1.125rem; color:var(--text-primary); }
    .summary-label { color:var(--text-secondary); }
    .summary-value { font-weight:600; color:var(--text-primary); }
    .checkout-btn { width:100%; background:var(--success-color); color:white; border:none; border-radius:var(--radius-lg); padding:1rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; justify-content:center; gap:0.5rem; font-size:1rem; margin-top:1rem; }
    .checkout-btn:hover:not(:disabled) { background:var(--success-dark); transform:translateY(-1px); }
    .checkout-btn:disabled { background:var(--text-secondary); cursor:not-allowed; transform:none; }
    .empty-cart { text-align:center; padding:4rem 2rem; color:var(--text-secondary); }
    .empty-cart-icon { font-size:4rem; margin-bottom:1rem; opacity:0.5; }
    .empty-cart h2 { font-size:1.5rem; margin-bottom:0.5rem; color:var(--text-primary); }
    .empty-cart p { margin-bottom:2rem; font-size:1.1rem; }
    .continue-shopping-btn { background:black; color:white; border:none; border-radius:var(--radius-lg); padding:0.75rem 1.5rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; }
    .continue-shopping-btn:hover { background:var(--primary-dark); transform:translateY(-1px); }
    
    @media (max-width:768px) {
        .cart-container { grid-template-columns:1fr; gap:1rem; }
        .section-header { flex-direction:column; align-items:flex-start; gap:1rem; }
        .cart-item { flex-direction:column; align-items:flex-start; gap:1rem; }
        .item-controls { flex-direction:row; width:100%; justify-content:space-between; }
        .section-title { font-size:1.75rem; }
    }
</style>

<div class="container">
    <div class="main-content">
        <div class="section-header">
            <h3 class="section-title">
                🛒 Cart Items
                <span class="cart-count" id="cart-count">
                    {{ collect($carts)->sum(function($cart) { return collect($cart['items'])->sum('qty'); }) }}
                </span>
            </h3>
            @if(!empty($carts) && !empty($carts[0]['items']))
                <button class="clear-cart-btn" onclick="clearCart()">
                    🗑️ Clear Cart
                </button>
            @endif
        </div>

        @if(empty($carts) || empty($carts[0]['items']))
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Add some delicious items to get started!</p>
                <a href="{{ route('shop') }}" class="continue-shopping-btn">
                    Go to Shop
                </a>
            </div>
        @else
            @php
                $cartItems = $carts[0]['items'];
                $totalAmount = collect($cartItems)->sum('total');
                $totalItems = collect($cartItems)->sum('qty');
            @endphp

            <div class="cart-container">
                <div class="cart-items">
                    @foreach($cartItems as $id => $item)
                        <div class="cart-item" id="cart-item-{{ $id }}">
                            <div class="item-image">
                                <img src="{{ get_product_image($item['id']) }}" alt="{{ $item['name'] }}" />
                            </div>

                            <div class="item-details">
                                <h3 class="item-name">{{ $item['name'] }}</h3>
                                <div class="item-price">₦{{ number_format($item['price']) }}</div>
                                <div class="item-subtotal">
                                    Subtotal: ₦<span class="item-total">{{ number_format($item['total']) }}</span>
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
                        <span>Total</span>
                        <span id="grand-total">₦{{ number_format($totalAmount) }}</span>
                    </div>

                    <button class="checkout-btn" onclick="openCheckoutModal()">
                        <span>Proceed to Checkout</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- ================== SIMPLIFIED CHECKOUT MODAL ================== -->
<div class="modal fade" id="checkoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title">Checkout</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- Delivery Address -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Delivery Address *</label>
          
          @php
              $addresses = json_decode(Auth::user()->home_address, true) ?? [];
          @endphp

          @if(empty($addresses))
              <div class="alert alert-warning d-flex align-items-center p-2 rounded-3">
                  <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                  <span>You don't have a saved delivery address.</span>
              </div>
              <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                  <i class="fas fa-plus me-1"></i> Add Delivery Address
              </a>
          @else
              <select id="deliveryAddress" name="delivery_address" class="form-select rounded-3" required>
                  @foreach($addresses as $address)
                      <option value="{{ $address }}">{{ $address }}</option>
                  @endforeach
              </select>
          @endif
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Phone Number *</label>
          <input type="tel" 
                 class="form-control" 
                 id="phone_number" 
                 placeholder="Enter your phone number"
                 value="{{ Auth::user()->phone ?? '' }}"
                 required />
          <small class="form-text text-muted">Enter a valid phone number for delivery updates</small>
        </div>

        <!-- Order Summary -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Order Summary</label>
          <div class="card bg-light">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span>Items Total:</span>
                <strong id="modal-items-total">₦0</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Delivery Fee:</span>
                <strong>₦1,000</strong>
              </div>
              <hr>
              <div class="d-flex justify-content-between">
                <span class="fs-5 fw-bold">Total Amount:</span>
                <strong class="fs-5 text-success" id="modal-grand-total">₦0</strong>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-success" id="confirmCheckout">
          Pay With PayPal
        </button>
      </div>

    </div>
  </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
/* ---------- Configuration & Utilities ---------- */
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const DELIVERY_FEE = 1000;

function showAlert(message, type = 'error') {
    const alert = document.createElement('div');
    alert.className = `custom-alert ${type}`;
    alert.textContent = message;

    Object.assign(alert.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        zIndex: '99999',
        padding: '12px 20px',
        borderRadius: '8px',
        color: '#fff',
        fontWeight: '500',
        fontSize: '15px',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        opacity: '0',
        transition: 'opacity 0.3s ease, transform 0.3s ease',
        transform: 'translateY(-10px)',
        pointerEvents: 'none'
    });

    if (type === 'success') alert.style.background = '#2ecc71';
    else if (type === 'warning') alert.style.background = '#f1c40f';
    else alert.style.background = '#e74c3c';

    document.body.appendChild(alert);

    setTimeout(() => {
        alert.style.opacity = '1';
        alert.style.transform = 'translateY(0)';
    }, 100);

    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            if (document.body.contains(alert)) document.body.removeChild(alert);
        }, 300);
    }, 3000);
}

function numberWithCommas(x) {
    return x.toLocaleString(undefined, {maximumFractionDigits: 0});
}

function parseCurrencyToNumber(text) {
    if (!text) return 0;
    return parseFloat(text.toString().replace(/[^0-9.-]+/g,"")) || 0;
}

function calculateCartTotalFromDOM() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach((el) => {
        const priceText = el.querySelector('.item-price') ? el.querySelector('.item-price').textContent : '';
        const qtyInput = el.querySelector('.qty-input');
        const price = parseCurrencyToNumber(priceText);
        const qty = qtyInput ? parseInt(qtyInput.value || 0, 10) : 0;
        total += price * qty;
    });
    return total;
}

function refreshSummaryUI() {
    const total = calculateCartTotalFromDOM();
    document.getElementById('items-total').textContent = `₦${numberWithCommas(total)}`;
    document.getElementById('grand-total').textContent = `₦${numberWithCommas(total)}`;
}

/* ---------- Modal Functions ---------- */
function openCheckoutModal() {
    const total = calculateCartTotalFromDOM();
    const grandTotal = total + DELIVERY_FEE;
    
    // Update modal amounts
    document.getElementById('modal-items-total').textContent = `₦${numberWithCommas(total)}`;
    document.getElementById('modal-grand-total').textContent = `₦${numberWithCommas(grandTotal)}`;
    
    const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    modal.show();
}

/* ---------- Cart Action Functions ---------- */
async function updateQuantity(id, newQty) {
    newQty = parseInt(newQty);
    if (isNaN(newQty) || newQty < 1 || newQty > 50) {
        showAlert('Invalid quantity. Must be between 1 and 50.', 'error');
        const qtyInput = document.getElementById(`qty-input-${id}`);
        if (qtyInput) qtyInput.value = qtyInput.dataset.original || 1;
        return;
    }

    const cartItem = document.getElementById(`cart-item-${id}`);
    if (cartItem) cartItem.style.opacity = '0.6';

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
            setTimeout(() => window.location.reload(), 800);
        } else {
            showAlert(result.message, "error");
            const qtyInput = document.getElementById(`qty-input-${id}`);
            if (qtyInput) qtyInput.value = qtyInput.dataset.original || 1;
        }
    } catch (error) {
        console.error('Error updating cart:', error);
        showAlert('Failed to update cart. Please try again.', 'error');
    } finally {
        if (cartItem) cartItem.style.opacity = '1';
    }
}

async function removeFromCart(id) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    const cartItem = document.getElementById(`cart-item-${id}`);
    if (cartItem) cartItem.style.opacity = '0.6';

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
            if (cartItem) {
                cartItem.style.transform = 'translateX(-100%)';
                cartItem.style.opacity = '0';
            }
            setTimeout(() => window.location.reload(), 500);
        } else {
            showAlert(result.message, "error");
            if (cartItem) cartItem.style.opacity = '1';
        }
    } catch (error) {
        console.error('Error removing item:', error);
        showAlert('Failed to remove item. Please try again.', 'error');
        if (cartItem) cartItem.style.opacity = '1';
    }
}

async function clearCart() {
    if (!confirm('Are you sure you want to clear your entire cart?')) {
        return;
    }

    const clearBtn = document.querySelector('.clear-cart-btn');
    if (clearBtn) clearBtn.disabled = true;

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
            if (clearBtn) clearBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
        showAlert('Failed to clear cart. Please try again.', 'error');
        if (clearBtn) clearBtn.disabled = false;
    }
}

/* ---------- Initialize ---------- */
document.addEventListener('DOMContentLoaded', function() {
    // Store original quantities
    document.querySelectorAll('.qty-input').forEach(input => {
        input.dataset.original = input.value;
    });

    // Update summary initially
    refreshSummaryUI();

    // Update summary when qty changes locally
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function() {
            let v = parseInt(this.value, 10) || 1;
            if (v < 1) v = 1;
            if (v > 50) v = 50;
            this.value = v;
            refreshSummaryUI();
        });
    });

    // Confirm checkout handler
    const confirmCheckoutBtn = document.getElementById('confirmCheckout');
    if (confirmCheckoutBtn) {
        confirmCheckoutBtn.addEventListener('click', async () => {
            const address = document.getElementById('deliveryAddress')?.value?.trim() || '';
            const phone_number = document.getElementById('phone_number')?.value?.trim() || '';
            const cartItems = [];
            
            // Validate inputs
            if (!address) {
                showAlert('Please select a delivery address', 'error');
                return;
            }
            
            if (!phone_number || !/^\+?\d{10,15}$/.test(phone_number)) {
                showAlert('Please enter a valid phone number (10-15 digits)', 'error');
                return;
            }
            
            // Collect cart items
            document.querySelectorAll('.cart-item').forEach((el) => {
                const id = el.id.split('-')[2];
                const name = el.querySelector('.item-name')?.textContent?.trim() || '';
                const priceText = el.querySelector('.item-price')?.textContent || '';
                const price = parseCurrencyToNumber(priceText);
                const qty = parseInt(el.querySelector('.qty-input')?.value || 0, 10);
                cartItems.push({ id: parseInt(id,10), name, qty, price, total: price * qty });
            });

            if (cartItems.length === 0) {
                showAlert("Your cart is empty", "error");
                return;
            }

            const totalAmount = cartItems.reduce((s,i) => s + i.total, 0);

            // Prepare FormData
            const formData = new FormData();
            formData.append('items', JSON.stringify(cartItems));
            formData.append('total_amount', totalAmount);
            formData.append('address', address);
            formData.append('phone_number', phone_number);
            formData.append('payment_method', 'cash');

            confirmCheckoutBtn.disabled = true;
            confirmCheckoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            try {
                const response = await fetch("{{ route('checkout') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.status) {
                    showAlert(result.message, "success");
                    
                    // Close modal
                    const modalElement = document.getElementById('checkoutModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                    
                    // Redirect
                    if (result.url) {
                        setTimeout(() => {
                            window.location.href = result.url;
                        }, 1000);
                    } else {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    showAlert(result.message, "error");
                    confirmCheckoutBtn.disabled = false;
                    confirmCheckoutBtn.innerHTML = 'Pay With PayPal';
                }
            } catch (error) {
                console.error('Checkout error:', error);
                showAlert('Failed to place order. Please try again.', "error");
                confirmCheckoutBtn.disabled = false;
                    confirmCheckoutBtn.innerHTML = 'Pay With PayPal';
            }
        });
    }
});
</script>

@endsection