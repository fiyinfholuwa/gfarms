@extends('auth_new.app')

@section('content')
<div class="auth-wrapper d-flex flex-column flex-md-row">
   
    <!-- Right Side (Form Section) -->
    <div class="auth-form-container d-flex align-items-center justify-content-center">

        <form  style="background:#c3e6cb;" class="auth-form shadow-sm p-4 p-md-5 rounded-4 w-100" method="POST" action="{{ route('login') }}">


            @csrf
            <div class="text-center mb-4">

                 <div style="text-align:center;" class="brand-logo">
                <a href="#">
                    <img style="width:120px; text-align:center;" src="{{ asset('logo.png') }}" alt="Logo">
                </a>
                                <h3 class="fw-bold mb-2 text-success">Sign In</h3>

            </div>

            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="inputEmail" class="form-label fw-semibold">Email Address</label>
                <div class="position-relative">
                    <input type="email" 
                           class="form-control form-control-lg ps-5 @error('email') is-invalid @enderror" 
                           id="inputEmail" name="email" placeholder="Enter your email"
                           value="{{ old('email') }}" required autofocus>
                    <i class="fas fa-envelope position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="inputPassword" class="form-label fw-semibold">Password</label>
                <div class="position-relative">
                    <input type="password" 
                           class="form-control form-control-lg ps-5 pe-5 @error('password') is-invalid @enderror" 
                           id="inputPassword" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-lock position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                    <button type="button" class="toggle-password position-absolute text-muted"
                        onclick="togglePassword()" style="right: 15px; top: 50%; transform: translateY(-50%); background:none; border:none;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Global Error --}}
            @if(session('error'))
                <div class="alert alert-danger py-2">{{ session('error') }}</div>
            @endif

            {{-- Forgot password --}}
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('password.request') }}" class="text-decoration-none text-orange fw-semibold small">Forgot password?</a>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-orange w-100 py-2 fw-semibold">Sign In</button>

            {{-- Sign up --}}
            <div class="text-center mt-4">
                <p class="mb-0 small">Don’t have an account?
                    <a href="{{ route('register') }}" class="fw-semibold text-dark text-decoration-none">Sign up</a>
                </p>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    function togglePassword() {
        let input = document.getElementById('inputPassword');
        let icon = event.currentTarget.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye-slash');
    }
</script>

<style>
    :root {
        --orange: #f79c42;
        --orange-hover: #e7892d;
        --green: #2e8b57;
    }

    body {
        min-height: 100vh;
    }

    .auth-wrapper {
        min-height: 100vh;
    }

    
   
    .auth-image .text-content {
        position: relative;
        z-index: 2;
        max-width: 400px;
    }

    /* Form Section */
    .auth-form-container {
        flex: 1;
        padding: 2rem;
    }

    .auth-form {
        max-width: 420px;
        background:red;
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

    .text-orange {
        color: var(--orange);
    }

    @media (max-width: 768px) {
        .auth-image {
            display: none;
        }
        .auth-form-container {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection
