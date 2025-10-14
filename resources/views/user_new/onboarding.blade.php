@extends('user_new.app')

@section('content')

@php 
    $has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
    $has_done_kyc = has_done_kyc(Auth::user()->id);
    $kycLevels = kyc_levels();
@endphp

<div class="container my-4">
    
    {{-- ========================= KYC SECTION ========================= --}}
    @if(!$has_done_kyc)
    <div class="pwa-modal shadow-sm mb-4">
        <!-- Header -->
        <div class="pwa-header text-center">
            <div class="pwa-icon mb-3">🎯</div>
            <h3 class="fw-bold mb-2 text-white">Choose Account Type</h3>
            <p class="mb-0 pwa-subtitle">Select the verification level you wish to complete</p>
        </div>

        <!-- Body -->
        <div class="pwa-body">
            <div class="text-center mb-4">
                <p class="pwa-text">Select an Account level below to see its details and start verification.</p>
            </div>

            <!-- KYC Level Cards -->
            <div class="kyc-grid mb-4">
                @foreach($kycLevels as $key => $level)
                    <div class="kyc-level-card" data-level="{{ $key }}">
                        <h5 class="kyc-title">{{ $level['title'] }}</h5>
                        <p class="kyc-subtitle">Click to view details</p>
                    </div>
                @endforeach
            </div>

            <!-- KYC Details -->
            <div id="kyc-details" class="kyc-details-section">
                <div class="kyc-selected-info">
                    <h4 id="kyc-title" class="selected-title"></h4>
                    <p id="kyc-desc" class="selected-desc"></p>
                </div>

                <form id="kyc-form" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="pwa-btn pwa-btn-secondary w-50 me-2">← Back</a>
                        <button type="submit" class="pwa-btn pwa-btn-primary w-50">Proceed →</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif


    {{-- ========================= ONBOARDING SECTION ========================= --}}
    @if(!$has_paid_onboarding && $has_done_kyc)
    <div class="pwa-modal shadow-sm mb-4">
        <!-- Header -->
        <div class="pwa-header text-center">
            <div class="pwa-icon mb-3">🚀</div>
            <h3 class="fw-bold mb-2 text-white">Complete Your Onboarding</h3>
            <p class="mb-0 pwa-subtitle">Make a one-time payment to unlock full access</p>
        </div>

        <!-- Body -->
        <div class="pwa-body">
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

            <!-- Buttons -->
            <div class="pwa-buttons">
                <a style="display:none;" href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" class="pwa-btn pwa-btn-primary">
                    Pay with Paystack
                </a>
                <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" class="pwa-btn pwa-btn-secondary">
                    Pay with Fincra
                </a>
                <a href="{{ route('dashboard') }}" class="pwa-btn pwa-btn-back">← Back</a>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ========================= SCRIPT ========================= --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Handle KYC dynamic details
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

{{-- ========================= STYLE ========================= --}}
<style>
/* Container look */
.pwa-modal {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    overflow: hidden;
    margin-bottom: 2rem;
}

/* Header */
.pwa-header {
    background: linear-gradient(135deg, #ff7e00, #000000);
    border: none;
    padding: 2rem 1.5rem;
    color: white;
}
.pwa-icon { font-size: 3rem; }
.pwa-subtitle { color: rgba(255,255,255,0.9); font-size: 1rem; }

/* Body */
.pwa-body { padding: 2rem 1.5rem; background: #fff; }
.pwa-price { color: #ff5500; font-weight: 700; font-size: 1.3rem; }
.pwa-text { color: #444; font-size: 1rem; line-height: 1.5; }

/* Features */
.pwa-features {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}
.feature-item { display: flex; align-items: flex-start; margin-bottom: 1rem; }
.feature-icon { margin-right: .75rem; }

/* Buttons */
.pwa-buttons { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
.pwa-btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    min-width: 180px;
}
.pwa-btn-primary { background: #FF6600; color: #fff; }
.pwa-btn-primary:hover { background: #e65c00; }
.pwa-btn-secondary { background: #000; color: #fff; }
.pwa-btn-secondary:hover { background: #333; }
.pwa-btn-back {
    border: 2px solid #FF6600;
    background: transparent;
    color: #FF6600;
}
.pwa-btn-back:hover { background: #FF6600; color: #fff; }

/* KYC cards */
.kyc-grid { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
.kyc-level-card {
    min-width: 160px; max-width: 200px;
    padding: 1.25rem; border-radius: 12px;
    background: #f8f9fa; cursor: pointer;
    border: 2px solid transparent; text-align: center;
}
.kyc-level-card:hover { background: #fff5f0; border-color: #ff7e00; }
.kyc-level-card.active-card { background: #fff5f0; border-color: #ff7e00; }
.kyc-title { color: #ff5500; font-weight: 600; }

/* Details */
.kyc-details-section { display: none; margin-top: 1.5rem; border-top: 1px solid #e9ecef; padding-top: 1.5rem; }
.kyc-selected-info { text-align: center; margin-bottom: 1.5rem; }
.selected-title { color: #ff5500; font-weight: 700; }
.selected-desc { color: #666; }

/* Responsive */
@media (max-width: 576px) { .kyc-grid { flex-direction: column; } }
</style>
@endsection
