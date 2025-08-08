@extends('user.app')

@section('content')
<style>
    h2, h3 { margin-bottom: 15px; }
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .search-box input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 250px;
    }
    .cart-box {
        background: #fafafa;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        width: 300px;
        position: sticky;
        top: 10px;
    }
    .cart-box ul {
        padding: 0;
        list-style: none;
        margin-bottom: 10px;
    }
    .cart-box li {
        padding: 5px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 5px;
    }
    .cart-actions button {
        background: red;
        color: white;
        border: none;
        padding: 3px 7px;
        border-radius: 4px;
        cursor: pointer;
    }
    .cart-actions input {
        width: 50px;
        text-align: center;
    }
    .product-section {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    .product-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        background: #f4f4f4;
    }
    .product-card h3 {
        font-size: 18px;
        margin: 10px;
    }
    .product-card p {
        margin: 0 10px 10px;
        font-size: 14px;
        color: #555;
    }
    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-top: 1px solid #eee;
    }
    .qty-input {
        width: 60px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
    }
    .add-btn {
        background: green;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .add-btn:hover { background: darkgreen; }
</style>

<div class="container">
    <div class="top-bar">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search food...">
        </div>
    </div>

    <div class="product-section">
        <!-- Products -->
        <div>
            <h2>Browse Products</h2>
            <div class="product-grid" id="productGrid">
                @foreach($foods as $food)
                    <div class="product-card" data-name="{{ strtolower($food->name) }}">
                        <img src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                            alt="{{ $food->name }}">
                        <h3>{{ $food->name }}</h3>
                        <p><strong>₦{{ number_format($food->amount, 2) }}</strong></p>
                        <p>{{ $food->short_description }}</p>
                        <div class="product-footer">
                            <input type="number" min="1" value="1" class="qty-input" id="qty-{{ $food->id }}">
                            <button 
                                onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})"
                                class="add-btn">
                                Add
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart -->
        <div class="cart-box">
            <h3>🛒 Cart</h3>
            <ul id="cart-items"></ul>
            <p><strong>Total: ₦<span id="cart-total">0</span></strong></p>
        </div>
    </div>
</div>

<script>
const cart = [];
let totalAmount = 0;
const LIMIT = 50000;

function addToCart(id, name, price) {
    const qty = parseInt(document.getElementById(`qty-${id}`).value) || 1;
    const itemTotal = qty * price;

    if (totalAmount + itemTotal > LIMIT) {
        alert(`❌ You cannot exceed ₦${LIMIT.toLocaleString()}. Current total: ₦${totalAmount.toLocaleString()}`);
        return;
    }

    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        if (totalAmount - existingItem.total + (existingItem.qty + qty) * price > LIMIT) {
            alert(`❌ Adding this quantity will exceed ₦${LIMIT.toLocaleString()}`);
            return;
        }
        existingItem.qty += qty;
        existingItem.total = existingItem.qty * price;
    } else {
        cart.push({ id, name, qty, price, total: itemTotal });
    }

    recalcTotal();
    renderCart();
}

function updateQty(id, newQty) {
    const item = cart.find(i => i.id === id);
    if (!item) return;

    const diff = (newQty * item.price) - item.total;
    if (totalAmount + diff > LIMIT) {
        alert(`❌ You cannot exceed ₦${LIMIT.toLocaleString()}`);
        return;
    }

    item.qty = newQty;
    item.total = newQty * item.price;
    recalcTotal();
    renderCart();
}

function removeFromCart(id) {
    const index = cart.findIndex(i => i.id === id);
    if (index !== -1) {
        cart.splice(index, 1);
    }
    recalcTotal();
    renderCart();
}

function recalcTotal() {
    totalAmount = cart.reduce((sum, item) => sum + item.total, 0);
}

function renderCart() {
    const cartList = document.getElementById('cart-items');
    cartList.innerHTML = '';

    cart.forEach(item => {
        const li = document.createElement('li');

        li.innerHTML = `
            <span>${item.name}</span>
            <div class="cart-actions">
                <input type="number" min="1" value="${item.qty}" onchange="updateQty(${item.id}, this.value)">
                <button onclick="removeFromCart(${item.id})">X</button>
            </div>
        `;

        cartList.appendChild(li);
    });

    document.getElementById('cart-total').textContent = totalAmount.toLocaleString();
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#productGrid .product-card').forEach(card => {
        const name = card.getAttribute('data-name');
        card.style.display = name.includes(query) ? 'flex' : 'none';
    });
});
</script>
@endsection
