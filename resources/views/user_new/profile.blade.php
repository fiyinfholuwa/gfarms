@extends('user_new.app')

@section('content')
<style>
    :root {
        --primary-color: #ff8c00;
        --light-bg: #f9f9f9;
    }

    .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.06);
        background: #fff;
    }

    .accordion-button {
        background: var(--primary-color) !important;
        color: #fff !important;
        font-weight: 600;
        font-size: 1rem;
        padding: 1rem 1.25rem;
    }

    .accordion-body {
        background: var(--light-bg);
        padding: 1.5rem;
        font-size: 0.95rem;
    }

    .btn-primary, .btn-success {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #fff !important;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.9rem;
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
        border-radius: 8px;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: #fff;
    }

    .profile-img-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .profile-img-container img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid var(--primary-color);
        object-fit: cover;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 38px;
        cursor: pointer;
        color: #666;
    }
</style>

<div class="ec-content-wrapper">
    <div class="content p-3">
        <h1 class="fw-bold mb-3">My Profile</h1>

        <div class="accordion" id="profileAccordion">

            <!-- BIO DATA -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBio">
                        Bio Data
                    </button>
                </h2>
                <div id="collapseBio" class="accordion-collapse collapse show">
                    <div class="accordion-body">

                        <!-- Profile Image -->
                        <div class="profile-img-container mb-3">
                            <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuWnBi14T_ynO92D9yJX_F6IJocVAd5q3pZA&s') }}" id="profilePreview">
                            <form id="imageForm" action="{{ route('profile.uploadImage') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_image" id="profileInput" accept="image/*" class="form-control mb-2" style="width:200px;">
                                <button type="submit" class="btn btn-primary btn-sm">Update Image</button>
                            </form>
                        </div>

                        <p><strong>Full Name:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Alt Email:</strong> {{ Auth::user()->alt_email ?? 'N/A' }}</p>

                        <!-- Alternative Email Modal Trigger -->
                        <div class="mb-3">
                            {{-- <label class="fw-semibold">Alternative Email</label><br> --}}
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#altEmailModal">Update Alternative Email</button>
                        </div>

                        <!-- Alternative Phone Modal Trigger -->
                        <div class="mb-3">
                            {{-- <label class="fw-semibold">Alternative Phone</label><br> --}}
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#altPhoneModal">Update Alternative Phone</button>
                        </div>

                        <p><strong>Alternative Phone:</strong> {{ Auth::user()->alt_phone ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
                        <p><strong>LGA:</strong> {{ ucfirst(Auth::user()->lga) }}</p>
                        <p><strong>State:</strong> {{ ucfirst(Auth::user()->state) }}</p>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddress">
                        Address
                    </button>
                </h2>
                <div id="collapseAddress" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        @php
                            $addresses = json_decode(Auth::user()->home_address ?? '[]', true);
                        @endphp
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fa fa-plus-circle"></i> Add Address
                            </button>
                        </div>
                        @if(!empty($addresses))
                            <ul class="list-group">
                                @foreach($addresses as $index => $address)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $address }}
                                        <form action="{{ route('profile.deleteAddress', $index) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                                            @csrf
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic">No addresses added yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CHANGE PASSWORD -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword">
                        Change Password
                    </button>
                </h2>
                <div id="collapsePassword" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <form action="{{ route('profile.changePassword') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3 position-relative">
                                <label>Old Password</label>
                                <input type="password" name="old_password" class="form-control" id="old_password" required>
                                <span class="toggle-password" toggle="#old_password"><i class="fa fa-eye"></i></span>
                            </div>
                            <div class="form-group mb-3 position-relative">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" required>
                                <span class="toggle-password" toggle="#new_password"><i class="fa fa-eye"></i></span>
                            </div>
                            <div class="form-group mb-3 position-relative">
                                <label>Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                                <span class="toggle-password" toggle="#new_password_confirmation"><i class="fa fa-eye"></i></span>
                            </div>
                            <button type="submit" class="btn btn-success">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DELETE ACCOUNT -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-danger text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelete">
                        Delete Account
                    </button>
                </h2>
                <div id="collapseDelete" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <p class="text-danger fw-semibold">Warning: Deleting your account is permanent.</p>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fa fa-trash"></i> Delete My Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->

    {{-- Add Alternative Email --}}
    <div class="modal fade" id="altEmailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="emailForm">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Update Alternative Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" id="alt_email" class="form-control" required>
                        </div>
                        <div id="otpSection" class="mb-3 d-none">
                            <label>OTP</label>
                            <input type="text" id="otpInput" class="form-control" placeholder="Enter OTP">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="sendOtpBtn">Send OTP</button>
                        <button type="button" class="btn btn-success d-none" id="verifyOtpBtn">Verify & Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Alternative Phone --}}
    <div class="modal fade" id="altPhoneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="phoneForm">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Update Alternative Phone</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="text" id="alt_phone" class="form-control" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="verifyPhoneOtpBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Address Modal --}}
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.addAddress') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="address" class="form-control" placeholder="Enter new address" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.deleteAccount') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Confirm Account Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Enter your password to confirm deletion:</p>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-password').forEach(el => {
    el.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        input.type = input.type === 'password' ? 'text' : 'password';
        this.innerHTML = input.type === 'password'
            ? '<i class="fa fa-eye"></i>'
            : '<i class="fa fa-eye-slash"></i>';
    });
});

// OTP flow for Alternative Email
document.getElementById('sendOtpBtn').addEventListener('click', function () {
    let email = document.getElementById('alt_email').value;
    if (!email) return alert('Enter an email');
    fetch('{{ route('profile.sendOtp') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ email })
    }).then(r=>r.json()).then(d=>{
        if(d.status==='ok'){
            alert('OTP sent!');
            document.getElementById('otpSection').classList.remove('d-none');
            this.classList.add('d-none');
            document.getElementById('verifyOtpBtn').classList.remove('d-none');
        } else alert(d.message);
    });
});

document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    let otp = document.getElementById('otpInput').value;
    let email = document.getElementById('alt_email').value;
    fetch('{{ route('profile.verifyOtp') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ email, otp })
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        if(d.status==='ok') location.reload();
    });
});


document.getElementById('verifyPhoneOtpBtn').addEventListener('click', function () {
    let phone = document.getElementById('alt_phone').value;
    fetch('{{ route('profile.updateAltPhone') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
        body: JSON.stringify({ phone })
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        if(d.status==='ok') location.reload();
    });
});


</script>
@endsection
