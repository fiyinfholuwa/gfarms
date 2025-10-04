@extends('user_new.app')

@section('content')
<style>
    :root {
        --primary-color: #ff8c00;
        --secondary-color: #000000;
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

    .accordion-button:not(.collapsed) {
        box-shadow: none;
    }

    .accordion-body {
        background: var(--light-bg);
        padding: 1.5rem;
        font-size: 0.95rem;
        line-height: 1.6;
        border-top: 1px solid #eee;
    }

    .accordion-body p {
        margin-bottom: 0.75rem;
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
        font-size: 0.85rem;
    }
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: #fff;
    }

    .list-group-item {
        border: 1px solid #eee;
        border-radius: 8px !important;
        margin-bottom: 6px;
        background: #fff;
        font-size: 0.9rem;
    }

    .modal-header {
        background: var(--primary-color);
        color: #fff;
    }
</style>

<div class="ec-content-wrapper">
    <div class="content p-3">
        <h1 class="mb-4 fw-bold">My Profile</h1>

        <div class="accordion" id="profileAccordion">

            <!-- BIO DATA -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBio">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBio" aria-expanded="true">
                         Bio Data
                    </button>
                </h2>
                <div id="collapseBio" class="accordion-collapse collapse show" data-bs-parent="#profileAccordion">
                    <div class="accordion-body">
                        <p><strong>Full Name:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
                        <p><strong>LGA:</strong> {{ ucfirst(Auth::user()->lga) }}</p>
                        <p><strong>State:</strong> {{ ucfirst(Auth::user()->state) }}</p>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAddress">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddress">
                         Address
                    </button>
                </h2>
                <div id="collapseAddress" class="accordion-collapse collapse" data-bs-parent="#profileAccordion">
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
                <h2 class="accordion-header" id="headingPassword">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword">
                         Change Password
                    </button>
                </h2>
                <div id="collapsePassword" class="accordion-collapse collapse" data-bs-parent="#profileAccordion">
                    <div class="accordion-body">
                        <form action="{{ route('profile.changePassword') }}" method="POST">
    @csrf
    <div class="form-group mb-3 position-relative">
        <label class="fw-semibold">Old Password</label>
        <input type="password" name="old_password" class="form-control" id="old_password" required>
        <span class="toggle-password" toggle="#old_password">
            <i class="fa fa-eye"></i>
        </span>
    </div>

    <div class="form-group mb-3 position-relative">
        <label class="fw-semibold">New Password</label>
        <input type="password" name="new_password" class="form-control" id="new_password" required>
        <span class="toggle-password" toggle="#new_password">
            <i class="fa fa-eye"></i>
        </span>
    </div>

    <div class="form-group mb-3 position-relative">
        <label class="fw-semibold">Confirm New Password</label>
        <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
        <span class="toggle-password" toggle="#new_password_confirmation">
            <i class="fa fa-eye"></i>
        </span>
    </div>

    <button type="submit" class="btn btn-success">Update Password</button>
</form>

<style>
.toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    color: #666;
}
</style>

<script>
document.querySelectorAll('.toggle-password').forEach(function(el) {
    el.addEventListener('click', function() {
        let input = document.querySelector(this.getAttribute('toggle'));
        if (input.getAttribute('type') === 'password') {
            input.setAttribute('type', 'text');
            this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.setAttribute('type', 'password');
            this.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });
});
</script>

                    </div>
                </div>
            </div>

            <!-- DELETE ACCOUNT -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDelete">
                    <button class="accordion-button collapsed bg-danger text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelete">
                         Delete Account
                    </button>
                </h2>
                <div id="collapseDelete" class="accordion-collapse collapse" data-bs-parent="#profileAccordion">
                    <div class="accordion-body">
                        <p class="text-danger fw-semibold"> Warning: Deleting your account is permanent. All your data will be lost.</p>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fa fa-trash"></i> Delete My Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.addAddress') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Home Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter new address" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('profile.deleteAccount') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">Confirm Account Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Enter your password to confirm deletion:</p>
                        <input type="password" name="password" class="form-control" placeholder="System password" required>
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
@endsection
