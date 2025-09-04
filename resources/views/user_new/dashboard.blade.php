@extends('user_new.app')

@section('content')
<!-- banner section start -->
   <section class="banner-wrapper">
  <div class="custom-container">
    <div class="row g-4 align-items-stretch">
      <!-- Balance Slider (Wallet & Loan) -->
      <div class="col-md-6 col-12">
        <div id="balanceCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-inner h-100">
            <!-- Wallet Balance -->
            <div class="carousel-item active h-100">
              <div class="balance-card wallet-card text-center p-4 rounded-4 shadow-lg h-100 position-relative">
                <div class="balance-amount">₦{{ number_format(Auth::user()->wallet_balance) }}</div>
                <div class="balance-label">Wallet Balance</div>
                
              </div>
            </div>
            <!-- Loan Balance -->
            <div class="carousel-item h-100">
              <div class="balance-card loan-card text-center p-4 rounded-4 shadow-lg h-100 position-relative">
                <div class="balance-amount">₦{{ number_format(Auth::user()->loan_balance) }}</div>
                <div class="balance-label">Loan Balance</div>
                
              </div>
            </div>
          </div>
          
          <!-- Enhanced controls -->
          <div class="carousel-controls">
            <button class="control-btn" type="button" data-bs-target="#balanceCarousel" data-bs-slide="prev">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="control-btn" type="button" data-bs-target="#balanceCarousel" data-bs-slide="next">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Account Number Section -->
      <div class="col-md-6 col-12">
        <div class="balance-card account-card text-center p-4 rounded-4 shadow-lg h-100">
          @if(empty(Auth::user()->virtual_account_number))
            <!-- Generate button -->
            <div class="fade-in">
              <h4 class="mb-3 text-dark">Virtual Account</h4>
              <p class="text-muted mb-4">Generate your personal account number for easy funding</p>
              <button class="generate-btn w-100" 
                      id="generateBtn" onclick="generateAccount()">
                <span id="btnText">Generate Account Number</span>
                <i id="spinner" class="fas fa-spinner fa-spin d-none ms-2"></i>
              </button>
            </div>
          @else
            @php
              $accountData = json_decode(Auth::user()->virtual_account_number, true);
            @endphp
            <!-- Account Display State -->
            <div class="fade-in">
              <div class="d-flex align-items-center justify-content-center mb-3">
              </div>
              
              <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="account-number me-3" id="accountNumber">
                  {{ $accountData['account_number'] ?? '' }}
                </div>
                <button class="copy-btn" onclick="copyAccountNumber()" id="copyBtn" title="Copy Account Number">
                  <i class="fas fa-copy"></i>
                </button>
              </div>
              
              <div class="bank-info">
                <strong>{{ $accountData['bank']['name'] ?? '' }}</strong><br>
                {{ $accountData['account_name'] ?? '' }}
              </div>
              
              <div class="mt-3">
                <small class="text-muted">
                  <i class="fas fa-shield-alt me-1"></i>
                  Secured & Protected
                </small>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Toast for copy feedback -->
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="copyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <i class="fas fa-check-circle text-success me-2"></i>
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Account number copied to clipboard!
      </div>
    </div>
  </div>
</section>

<style>




.balance-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.balance-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.balance-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  transition: left 0.5s ease;
}

.balance-card:hover::before {
  left: 100%;
}

.wallet-card {
background: linear-gradient(135deg, #2c2c2c 0%, #000000 100%);
  color: white;
}

.loan-card {
background: linear-gradient(135deg, #ff8008 0%, #ffc837 100%);
  color: white;
}

.account-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
}

.balance-amount {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.balance-label {
  font-size: 1.1rem;
  opacity: 0.9;
  margin-bottom: 1rem;
}

.carousel-controls {
  position: absolute;
  bottom: 15px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
}

.control-btn {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.2);
  color: white;
}

.control-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: scale(1.1);
}

.account-number {
  font-size: 1.8rem;
  font-weight: 700;
  color: #333;
  letter-spacing: 2px;
  font-family: 'Courier New', monospace;
}

.copy-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid #ff6600;
  background: transparent;
  color: #ff6600;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  cursor: pointer;
}

.copy-btn:hover {
  background: #ff6600;
  color: white;
  transform: scale(1.1);
}

.copy-btn.copied {
  background: #28a745;
  border-color: #28a745;
  color: white;
}

.generate-btn {
  background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
  border: none;
  color: white;
  padding: 1rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.generate-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
}

.generate-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.bank-info {
  color: #666;
  font-weight: 500;
  margin-top: 1rem;
}

.balance-icon {
  font-size: 3rem;
  opacity: 0.1;
  position: absolute;
  top: 20px;
  right: 20px;
}

.fade-in {
  animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
  .balance-amount { font-size: 2rem; }
  .account-number { font-size: 1.4rem; }
  .banner-wrapper { padding: 1.5rem 0; }
  .carousel-controls { bottom: 10px; }
}
</style>

<script>
function copyAccountNumber() {
    const accountNumber = document.getElementById('accountNumber').textContent;
    const copyBtn = document.getElementById('copyBtn');
    const toast = new bootstrap.Toast(document.getElementById('copyToast'));
    
    // Copy to clipboard
    navigator.clipboard.writeText(accountNumber).then(function() {
        // Change button appearance
        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        copyBtn.classList.add('copied');
        
        // Show toast
        toast.show();
        
        // Reset button after 2 seconds
        setTimeout(() => {
            copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
            copyBtn.classList.remove('copied');
        }, 2000);
        
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = accountNumber;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            copyBtn.innerHTML = '<i class="fas fa-check"></i>';
            copyBtn.classList.add('copied');
            toast.show();
            
            setTimeout(() => {
                copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                copyBtn.classList.remove('copied');
            }, 2000);
        } catch (err) {
            console.error('Fallback copy failed: ', err);
        }
        
        document.body.removeChild(textArea);
    });
}

function generateAccount() {
    let btn = document.getElementById("generateBtn");
    let spinner = document.getElementById("spinner");
    let btnText = document.getElementById("btnText");

    // Save the original text
    let originalText = btnText.textContent;

    btn.disabled = true;
    btnText.textContent = "Generating...";
    spinner.classList.remove("d-none");

    fetch("{{ route('generate_virtual_account') }}", {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === true) {
            alert("Account generated successfully!");
            location.reload();
        } else {
            alert("Failed to generate account: " + (data.message || "Unknown error"));
        }
    })
    .catch(err => {
        alert("Error: " + err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btnText.textContent = originalText;
        spinner.classList.add("d-none");
    });
}
</script>
    <!-- banner section start -->

    

    
    <!-- Foods Section Start -->
<section class="section-t-space">
    <div class="custom-container">
        <div class="title d-flex justify-content-between align-items-center">
            <h2>Most Popular Foods</h2>
            <a href="{{ url('/foods') }}">View All</a>
        </div>

        <div class="row g-4">
            @if(count($foods) > 0)
                @foreach($foods as $food)
                    <div class="col-6">
                        <div class="product-box">
                            <div class="product-box-img">
                                                                <h5 class="badge bg-warning">{{ optional($food->cat)->name ?? 'Uncategorized' }}</h5>

                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#foodModal-{{ $food->id }}">
                                    <img class="img" 
                                         src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                                         alt="{{ $food->name }}" />
                                </a>

                                {{-- <div class="cart-box">
                                    <a href="javascript:void(0)" 
                                       onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})" 
                                       class="cart-bag">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </a>
                                </div> --}}
                            </div>

                            {{-- Like / Favorite button --}}
                            {{-- <div class="like-btn animate inactive">
                                <img class="outline-icon" src="{{ asset('assets/images/svg/like.svg') }}" alt="like" />
                                <img class="fill-icon" src="{{ asset('assets/images/svg/like-fill.svg') }}" alt="like" />
                                <div class="effect-group">
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                </div>
                            </div> --}}

                            <div class="product-box-detail">
                                <h4>{{ $food->name }}</h4>
                                <div class="d-flex justify-content-between gap-3">
                                    <h3 class="fw-semibold">₦{{ number_format($food->amount, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal for Food Details --}}
                    <div class="modal fade" id="foodModal-{{ $food->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $food->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                                                 alt="{{ $food->name }}" class="img-fluid rounded">
                                        </div>
                                        <div class="col-md-7">
                                            <h4 class="fw-bold">₦{{ number_format($food->amount, 2) }}</h4>
                                            <p>{{ $food->description ?? $food->short_description }}</p>

                                            @if($food->cat)
                                                <span class="badge bg-secondary">{{ $food->cat->name }}</span>
                                            @endif

                                            <div class="mt-3">
                                                <button 
                                                    onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})"
                                                    class="btn btn-success">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
                    <div class="text-center p-5 border rounded-4 shadow-sm bg-light" style="max-width: 500px;">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-4x text-muted"></i>
                        </div>
                        <h4 class="fw-bold text-secondary">No Products Available</h4>
                        <p class="text-muted">Please check back later for amazing updates 🌟</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Foods Section End -->
 <!-- other furniture section end -->

<?php 
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- 🔹 If user has NOT paid onboarding, show onboarding modal --}}
@if(!$has_paid_onboarding)
    <button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

   {{-- ✅ Clean Onboarding Modal --}}
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content pwa-modal">

            <!-- Clean Header -->
            <div class="modal-header pwa-header">
                <div class="w-100 text-center">
                    <div class="pwa-icon mb-3">🚀</div>
                    <h3 class="modal-title fw-bold mb-2 text-white">Complete Your Onboarding</h3>
                    <p class="mb-0 pwa-subtitle">Make a one-time payment to unlock full access</p>
                </div>
            </div>

            <!-- Clean Body -->
            <div class="modal-body pwa-body"> 
               <div class="text-center mb-4">
                   <h4 class="pwa-price mb-3">Pay only ₦500 for account activation</h4>
                   <p class="pwa-text">Complete your KYC later to fully unlock all features.</p>
               </div>

               <div class="pwa-features mb-4">
                   <div class="feature-item">
                       <div class="feature-icon">✅</div>
                       <div class="feature-text">Full access to all basic platform features after activation</div>
                   </div>
                   <div class="feature-item">
                       <div class="feature-icon">✅</div>
                       <div class="feature-text">Option to complete KYC for advanced benefits</div>
                   </div>
               </div>

               <!-- Clean Payment Buttons -->
               <div class="pwa-buttons">
                   <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" 
                      class="pwa-btn pwa-btn-primary">
                        Pay with Paystack
                   </a>
                   <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" 
                      class="pwa-btn pwa-btn-secondary">
                       Pay with Fincra
                   </a>
               </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Auto-show onboarding modal --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('showOnboardingModal').click();
    });
</script>

{{-- 🔹 If user paid onboarding but has NOT done KYC, show KYC modal --}}
@elseif(!$has_done_kyc)
    <!-- Hidden Trigger Button -->
<button type="button" class="btn btn-warning d-none" id="showKycModal" data-bs-toggle="modal" data-bs-target="#kycModal"></button>

{{-- ✅ Clean KYC Modal --}}
<div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content pwa-modal">

            <!-- Clean Header -->
            <div class="modal-header pwa-header">
                <div class="w-100 text-center">
                    <div class="pwa-icon mb-3">🎯</div>
                    <h3 class="modal-title fw-bold mb-2 text-white">Choose Account Type</h3>
                    <p class="mb-0 pwa-subtitle">Select the verification level you wish to complete</p>
                </div>
            </div>

            <!-- Clean Body -->
            <div class="modal-body pwa-body">

                <div class="text-center mb-4">
                    <p class="pwa-text">Select an Account level below to see its details and start verification.</p>
                </div>

                <!-- Clean KYC Level Cards -->
                <div class="kyc-grid mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card" data-level="{{ $key }}">
                            <h5 class="kyc-title">{{ $level['title'] }}</h5>
                            <p class="kyc-subtitle">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <!-- KYC Details Section -->
                <div id="kyc-details" class="kyc-details-section">
                    <div class="kyc-selected-info">
                        <h4 id="kyc-title" class="selected-title"></h4>
                        <p id="kyc-desc" class="selected-desc"></p>
                    </div>

                    <form id="kyc-form" method="POST">
                        @csrf
                        <button type="submit" class="pwa-btn pwa-btn-primary w-100">
                             Proceed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Auto-show KYC modal & dynamic behavior --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('showKycModal').click();

    const kycData = @json($kycLevels);
    const title = document.getElementById('kyc-title');
    const desc = document.getElementById('kyc-desc');
    const form = document.getElementById('kyc-form');
    const details = document.getElementById('kyc-details');

    document.querySelectorAll('.kyc-level-card').forEach(card => {
        card.addEventListener('click', () => {
            const data = kycData[card.dataset.level];
            title.textContent = data.title;
            desc.innerHTML = data.description; 
            form.action = data.endpoint || "#";
            details.style.display = 'block';
            document.querySelectorAll('.kyc-level-card').forEach(c => c.classList.remove('active-card'));
            card.classList.add('active-card');
        });
    });
});
</script>
@endif

{{-- ✅ Clean PWA Styles --}}
<style>
/* Clean PWA Modal Styles */
.pwa-modal {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    overflow: hidden;
}

.pwa-header {
    background: linear-gradient(135deg, #ff7e00, #ff5500);
    border: none;
    padding: 2rem 1.5rem;
}

.pwa-icon {
    font-size: 3rem;
    line-height: 1;
}

.pwa-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
}

.pwa-body {
    background: #ffffff;
    padding: 2rem 1.5rem;
}

.pwa-price {
    color: #ff5500;
    font-weight: 700;
    font-size: 1.3rem;
}

.pwa-text {
    color: #666;
    font-size: 1rem;
    line-height: 1.5;
}

.pwa-features {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.feature-item:last-child {
    margin-bottom: 0;
}

.feature-icon {
    font-size: 1.1rem;
    margin-right: 0.75rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.feature-text {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.4;
}

.pwa-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.pwa-btn {
    display: block;
    text-align: center;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    font-size: 1rem;
    cursor: pointer;
}

.pwa-btn-primary {
    background: #00b9f1;
    color: white;
}

.pwa-btn-primary:hover {
    background: #007ad9;
    color: white;
    transform: translateY(-1px);
}

.pwa-btn-secondary {
    background: #ff7e00;
    color: white;
}

.pwa-btn-secondary:hover {
    background: #ff5500;
    color: white;
    transform: translateY(-1px);
}

/* KYC Grid */
.kyc-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.kyc-level-card {
    flex: 1;
    min-width: 160px;
    max-width: 200px;
    padding: 1.25rem;
    border-radius: 12px;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    text-align: center;
}

.kyc-level-card:hover {
    background: #e9ecef;
    border-color: #ff7e00;
}

.kyc-level-card.active-card {
    background: #fff5f0;
    border-color: #ff7e00;
}

.kyc-title {
    color: #ff5500;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.kyc-subtitle {
    color: #666;
    font-size: 0.85rem;
    margin: 0;
}

.kyc-details-section {
    display: none;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.kyc-selected-info {
    text-align: center;
    margin-bottom: 1.5rem;
}

.selected-title {
    color: #ff5500;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.selected-desc {
    color: #666;
    margin: 0;
}

/* Mobile Responsive */
@media (max-width: 576px) {
    .pwa-header {
        padding: 1.5rem 1rem;
    }
    
    .pwa-body {
        padding: 1.5rem 1rem;
    }
    
    .pwa-icon {
        font-size: 2.5rem;
    }
    
    .kyc-grid {
        flex-direction: column;
    }
    
    .kyc-level-card {
        max-width: none;
    }
}

/* Remove all shadows globally for clean PWA look */
.modal-content {
    box-shadow: none !important;
}

.btn {
    box-shadow: none !important;
}

.btn:hover {
    box-shadow: none !important;
}
</style>

    <!-- banner section start -->
    {{-- <section class="banner-wapper grid-banner">
      <div class="custom-container">
        <div class="row">
          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-3.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
              <div class="banner-bg"></div>
            </div>
          </div>

          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-4.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section> --}}
    <!-- banner section end -->

@endsection