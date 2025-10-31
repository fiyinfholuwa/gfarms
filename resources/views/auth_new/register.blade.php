@extends('auth_new.app')

@section('content')
<div class="auth-wrapper d-flex flex-column flex-md-row">
    <!-- Form Section -->
    <div class="auth-form-container d-flex align-items-center justify-content-center">
        <form style="background:#c3e6cb;" class="auth-form shadow-sm p-4 p-md-5 rounded-4 w-100" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="text-center mb-4">
                <div class="brand-logo" style="text-align:center;">
                    <a href="#">
                        <img style="width:120px;" src="{{ asset('logo.png') }}" alt="Logo">
                    </a>
                                                        <a style="text-decoration:none; color:black;" href="{{ route("home") }}">Go Home</a>

                    <h3 class="fw-bold mb-2 text-success">Create Account</h3>
                    <p class="text-muted small">Join us today, it only takes a minute!</p>
                </div>
            </div>

            {{-- Global Errors --}}
            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- First Name --}}
            <div class="mb-3">
                <label for="first_name" class="form-label fw-semibold">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name') }}" placeholder="Enter First Name" required>
                @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Last Name --}}
            <div class="mb-3">
                <label for="last_name" class="form-label fw-semibold">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name') }}" placeholder="Enter First Name" required>
                @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="Enter Email" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Phone --}}
            <div class="mb-3">
                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="Enter Phone Number" required>
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- State --}}
            <div class="mb-3">
                <label for="state" class="form-label fw-semibold">State</label>
                <select name="state" id="state" class="form-control form-control-lg @error('state') is-invalid @enderror" required>
                    <option value="">Loading States...</option>
                </select>
                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- LGA --}}
            <div class="mb-3">
                <label for="lga" class="form-label fw-semibold">Local Government Area (LGA)</label>
                <select name="lga" id="lga" class="form-control form-control-lg @error('lga') is-invalid @enderror" required>
                    <option value="">Select State First</option>
                </select>
                @error('lga') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <input type="hidden" name="country" value="Nigeria">

            {{-- Password --}}
            <div class="mb-3 position-relative">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg ps-5 pe-5 @error('password') is-invalid @enderror"
                       placeholder="Enter Password" required>
                <i class="fas fa-lock position-absolute text-muted" style="top:50%; left:15px; transform:translateY(-50%);"></i>
                <button type="button" class="toggle-password position-absolute text-muted"
                    onclick="togglePassword('password', this)"
                    style="right: 15px; top: 50%; transform: translateY(-50%); background:none; border:none;">
                    <i class="fas fa-eye"></i>
                </button>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3 position-relative">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control form-control-lg ps-5 pe-5" placeholder="Re-enter Password" required>
                <i class="fas fa-lock position-absolute text-muted" style="top:50%; left:15px; transform:translateY(-50%);"></i>
                <button type="button" class="toggle-password position-absolute text-muted"
                    onclick="togglePassword('password_confirmation', this)"
                    style="right: 15px; top: 50%; transform: translateY(-50%); background:none; border:none;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-orange w-100 py-2 fw-semibold">Create Account</button>

            {{-- Already have account --}}
            <div class="text-center mt-4">
                <p class="mb-0 small">Already have an account?
                    <a href="{{ route('login') }}" class="fw-semibold text-dark text-decoration-none">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye-slash');
}

document.addEventListener('DOMContentLoaded', function() {
    // Load states
    fetch("{{ url('/locations/states') }}")
        .then(res => res.json())
        .then(states => {
            const stateDropdown = document.getElementById("state");
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            states.forEach(state => {
                stateDropdown.innerHTML += `<option value="${state.id}">${state.name}</option>`;
            });
        });

    // Load LGAs
    document.getElementById("state").addEventListener("change", function() {
        const selectedState = this.value;
        const lgaDropdown = document.getElementById("lga");
        if (selectedState) {
            lgaDropdown.innerHTML = '<option>Loading LGAs...</option>';
            fetch("{{ url('/locations/lgas') }}/" + encodeURIComponent(selectedState))
                .then(res => res.json())
                .then(data => {
                    lgaDropdown.innerHTML = '<option value="">Select LGA</option>';
                    if (data.lgas) {
                        data.lgas.forEach(lga => {
                            lgaDropdown.innerHTML += `<option value="${lga}">${lga}</option>`;
                        });
                    }
                });
        } else {
            lgaDropdown.innerHTML = '<option value="">Select State First</option>';
        }
    });
});
</script>

<style>
    :root {
        --orange: #f79c42;
        --orange-hover: #e7892d;
    }

    .auth-wrapper {
        min-height: 100vh;
    }

    .auth-form-container {
        flex: 1;
        padding: 2rem;
    }

    .auth-form {
        max-width: 480px;
        background: #c3e6cb;
    }

    .form-control {
        border: 1.8px solid #e3e6ea;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--orange);
        box-shadow: 0 0 0 0.2rem rgba(247, 156, 66, 0.2);
    }

    .btn-orange {
        background-color: var(--orange);
        color: #fff;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-orange:hover {
        background-color: var(--orange-hover);
    }

    @media (max-width: 768px) {
        .auth-form-container {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection
