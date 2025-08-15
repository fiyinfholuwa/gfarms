

@extends('user.app')
@section('content')



			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<!-- Top Statistics -->
					
    <style>
       
        
        .dash-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .card-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        
        .card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
        
        .card-body {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
        }
        
        .card-body h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .card-body p {
            font-size: 0.95rem;
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .card-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 2rem;
            opacity: 0.3;
        }
        
        .account-section {
            position: relative;
        }
        
        .account-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 50px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            border-radius: 6px;
            padding: 5px 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }
        
        .copy-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }
        
        .copy-btn.copied {
            background: rgba(76, 175, 80, 0.8);
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
		.card-body h2{
			color:#fff !important;
		}
        .custom-toast {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 8px;
        }
        
        @media (max-width: 576px) {
            .card-body h2 {
                font-size: 1.4rem;
            }
            .card-icon {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-sm-6 p-3">
                <div class="card card-mini dash-card card-1">
                    <div class="card-body">
                        <i class="fas fa-wallet card-icon"></i>
                        <h2 class="mb-1">₦1,503</h2>
                        <p>Wallet Balance</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 p-3">
                <div class="card card-mini dash-card card-2">
                    <div class="card-body">
                        <i class="fas fa-chart-line card-icon"></i>
                        <h2 class="mb-1">₦79,503</h2>
                        <p>Loan Balance</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 p-3">
                <div class="card card-mini dash-card card-3">
                    <div class="card-body account-section">
                        <i class="fas fa-university card-icon"></i>
                        <button class="copy-btn" onclick="copyAccountNumber()" id="copyBtn">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <h2 class="mb-1 account-number" id="accountNumber">2300221232</h2>
                        <p>Wema Bank</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 p-3">
                <div class="card card-mini dash-card card-4">
                    <div class="card-body">
                        <i class="fas fa-user-circle card-icon"></i>
                        <h2 class="mb-1">Active</h2>
                        <p>User Account</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container">
        <div id="copyToast" class="toast custom-toast" role="alert">
            <div class="toast-body d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                Account number copied to clipboard!
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyAccountNumber() {
            const accountNumber = document.getElementById('accountNumber').textContent;
            const copyBtn = document.getElementById('copyBtn');
            const toast = new bootstrap.Toast(document.getElementById('copyToast'));
            
            // Copy to clipboard
            navigator.clipboard.writeText(accountNumber).then(function() {
                // Change button appearance
                copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                copyBtn.classList.add('copied');
                
                // Show toast
                toast.show();
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copy';
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
                    copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    copyBtn.classList.add('copied');
                    toast.show();
                    
                    setTimeout(() => {
                        copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copy';
                        copyBtn.classList.remove('copied');
                    }, 2000);
                } catch (err) {
                    console.error('Fallback copy failed: ', err);
                }
                
                document.body.removeChild(textArea);
            });
        }
    </script>
</body>
</html>
					
					
					
					<div class="row">
    <div class="col-12 p-b-15">
        <!-- Recent Order Table -->
        <div class="card card-table-border-none card-default recent-orders" id="recent-orders">
            <div class="card-header justify-content-between">
                <h2>Recent Food Orders</h2>
                <div class="date-range-report">
                    <span></span>
                </div>
            </div>
            <div class="card-body pt-0 pb-5">
                <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Food Item</th>
                            <th class="d-none d-lg-table-cell">Quantity</th>
                            <th class="d-none d-lg-table-cell">Order Date</th>
                            <th class="d-none d-lg-table-cell">Order Cost</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>F1001</td>
                            <td><a class="text-dark" href="">Jollof Rice & Grilled Chicken</a></td>
                            <td class="d-none d-lg-table-cell">2 Plates</td>
                            <td class="d-none d-lg-table-cell">Aug 10, 2025</td>
                            <td class="d-none d-lg-table-cell">₦3,500</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="#">View</a></li>
                                        <li class="dropdown-item"><a href="#">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>F1002</td>
                            <td><a class="text-dark" href="">Pepper Soup & Boiled Yam</a></td>
                            <td class="d-none d-lg-table-cell">1 Bowl</td>
                            <td class="d-none d-lg-table-cell">Aug 11, 2025</td>
                            <td class="d-none d-lg-table-cell">₦2,200</td>
                            <td><span class="badge badge-primary">Delayed</span></td>
                            <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="#">View</a></li>
                                        <li class="dropdown-item"><a href="#">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>F1003</td>
                            <td><a class="text-dark" href="">Efo Riro with Pounded Yam</a></td>
                            <td class="d-none d-lg-table-cell">3 Servings</td>
                            <td class="d-none d-lg-table-cell">Aug 12, 2025</td>
                            <td class="d-none d-lg-table-cell">₦4,500</td>
                            <td><span class="badge badge-warning">On Hold</span></td>
                            <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="#">View</a></li>
                                        <li class="dropdown-item"><a href="#">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>F1004</td>
                            <td><a class="text-dark" href="">Shawarma (Beef) & Coke</a></td>
                            <td class="d-none d-lg-table-cell">4 Packs</td>
                            <td class="d-none d-lg-table-cell">Aug 13, 2025</td>
                            <td class="d-none d-lg-table-cell">₦6,000</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="#">View</a></li>
                                        <li class="dropdown-item"><a href="#">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>F1005</td>
                            <td><a class="text-dark" href="">Fried Rice & Turkey</a></td>
                            <td class="d-none d-lg-table-cell">2 Plates</td>
                            <td class="d-none d-lg-table-cell">Aug 14, 2025</td>
                            <td class="d-none d-lg-table-cell">₦3,800</td>
                            <td><span class="badge badge-danger">Cancelled</span></td>
                            <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="#">View</a></li>
                                        <li class="dropdown-item"><a href="#">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

					<div class="row">
{{-- 						
						<div class="col-xl-7">
							<!-- Top Products -->
							<div class="card card-default ec-card-top-prod">
								<div class="card-header justify-content-between">
									<h2>Top Products</h2>
									<div>
										<button class="text-black-50 mr-2 font-size-20"><i
												class="mdi mdi-cached"></i></button>
										<div class="dropdown show d-inline-block widget-dropdown">
											<a class="dropdown-toggle icon-burger-mini" href="#" role="button"
												id="dropdown-product" data-bs-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false" data-display="static">
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="#">Update Data</a></li>
												<li class="dropdown-item"><a href="#">Detailed Log</a></li>
												<li class="dropdown-item"><a href="#">Statistics</a></li>
												<li class="dropdown-item"><a href="#">Clear Data</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body mt-10px mb-10px py-0">
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p1.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Baby cotton shoes</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">58</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$520</span>
												<del>$580</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p2.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Hoodies for men</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">20</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$250</span>
												<del>$300</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p3.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Long slive t-shirt</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">10</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$480</span>
												<del>$654</del>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div> --}}
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

<?php 
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- 🔹 If user has NOT paid onboarding, show onboarding modal --}}
@if(!$has_paid_onboarding)
    <button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

   {{-- ✅ Fancy Onboarding Modal (Uncancelable + Two Payment Options) --}}
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" 
             style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white">🚀 Complete Your Onboarding</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Make a one-time payment to unlock full access</p>
            </div>

            <!-- Body -->
            <div class="modal-body d-flex flex-column justify-content-center align-items-center text-center px-5 py-4" 
                 style="background:#fffaf5;">
                
               <!-- Payment Info -->
<p class="fw-bold mb-3" style="color:#ff5500; font-size:1.3rem;">
    Pay only ₦500 for account activation.  
    <br>Complete your KYC later to fully unlock all features.
</p>

<!-- Features -->
<ul class="list-unstyled mb-4 text-start" style="max-width:400px; font-size:1rem; color:#444;">
    <li class="mb-2">✅ Full access to all basic platform features after activation</li>
    <li class="mb-2">✅ Option to complete KYC for advanced benefits</li>
</ul>

                <!-- ✅ Two Payment Options -->
                <!-- ✅ Two Payment Options (Always Side by Side) -->
<div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
    <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" 
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#00b9f1,#007ad9); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
         Pay with Paystack
    </a>
    <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" 
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
        Pay with Fincra
    </a>
</div>

            </div>
        </div>
    </div>
</div>

<!-- 🌈 Gradient Animation -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.btn:hover {
    transform: scale(1.05);
}
</style>

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

{{-- ✅ Fancy KYC Modal (Uncancelable) --}}
<div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white"> Choose Account Type</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Select the verification level you wish to complete</p>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-5" style="background:#fffaf5;">

                <p class="fw-bold text-center mb-4" style="color:#ff5500; font-size:1.1rem;">
                    Select an Account level below to see its details and start verification.
                </p>

                <!-- Fancy KYC Level Cards -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card shadow-sm" data-level="{{ $key }}" 
                             style="width:200px; padding:15px; border-radius:15px; background:#fff; cursor:pointer; transition:all 0.3s; border:1px solid #eee; text-align:center;">
                            <h5 class="fw-bold mb-2" style="color:#ff5500;">{{ $level['title'] }}</h5>
                            <p class="text-muted small mb-0">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <hr>

                <!-- KYC Details Section -->
                <div id="kyc-details" style="display:none;">
                    <h4 id="kyc-title" class="fw-bold mb-2" style="color:#ff5500;"></h4>
                    <p id="kyc-desc" class="text-muted mb-4"></p>

                    <form id="kyc-form" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg fw-bold text-white shadow-sm"
                                style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:5px 40px; font-size:1rem; transition:0.3s;">
                             Proceed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🌈 Animation + Hover Effects -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.kyc-level-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15);
    border-color: #ff7e00;
}
.active-card {
    border: 2px solid #ff7e00 !important;
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15) !important;
    transform: translateY(-3px);
}
</style>

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

{{-- ✅ Custom Styles --}}
<style>
    .kyc-level-btn {
        background:linear-gradient(135deg,#ff7e00,#ff5500);
        color:white; font-weight:bold; border:none;
        border-radius:25px; padding:12px 20px; width:45%;
        box-shadow:0 4px 10px rgba(255,85,0,0.3);
        transition:transform .2s, box-shadow .3s;
    }
    .kyc-level-btn:hover {
        transform:scale(1.05);
        box-shadow:0 6px 15px rgba(255,85,0,0.5);
    }
</style>

@endsection
