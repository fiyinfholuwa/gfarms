@extends('auth_new.app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card fade-in">
        <div class="brand text-center mb-4">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="brand-logo">
            <h2 class="fw-bold mt-3 text-dark">Welcome Back 👋</h2>
            <p class="text-muted small">We’re glad to see you again</p>
        </div>

        {{-- Error Alert --}}
        @if(session('error'))
            <div class="alert alert-danger fade-in mb-3">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="input-group floating mb-4">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder=" " />
                <label for="email"><i class="fas fa-envelope me-1"></i> Email Address</label>
                @error('email')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="input-group floating mb-4">
                <input type="password" id="password" name="password" required placeholder=" " />
                <label for="password"><i class="fas fa-lock me-1"></i> Password</label>
                <button type="button" onclick="togglePassword()" class="toggle-btn">
                    <i class="fas fa-eye"></i>
                </button>
                @error('password')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="text-end mb-3">
                <a href="{{ route('password.request') }}" class="text-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-submit w-100">Sign In</button>

            <div class="text-center mt-4">
                <p class="small mb-0">Don’t have an account?
                    <a href="{{ route('register') }}" class="text-link fw-bold">Sign up</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = event.currentTarget.querySelector('i');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye-slash');
}
</script>

<style>
body {
    margin: 0;
    height: 100vh;
    font-family: 'Inter', sans-serif;
    background: radial-gradient(circle at top right, #e3f2fd, #e0e7ff, #ede7f6);
    display: flex;
    justify-content: center;
    align-items: center;
    animation: softGlow 8s ease-in-out infinite alternate;
}

@keyframes softGlow {
    from { background-position: left; }
    to { background-position: right; }
}

.auth-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 1rem;
}

.auth-card {
    width: 100%;
    max-width: 420px;
    padding: 2.8rem 2.5rem;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(16px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.1);
    animation: floatIn 0.6s ease-out both;
}

.brand-logo {
    width: 90px;
    border-radius: 50%;
    background: white;
    padding: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
}

h2 {
    font-weight: 700;
    color: #222;
}

p {
    color: #666;
}

/* === Floating Inputs === */
.input-group {
    position: relative;
}

.floating input {
    width: 100%;
    padding: 0.9rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    background: transparent;
    font-size: 0.95rem;
    color: #333;
    outline: none;
    transition: all 0.3s ease;
}

.floating input:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 8px rgba(74,144,226,0.3);
    background: #fff;
}

.floating label {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.9rem;
    color: #777;
    pointer-events: none;
    transition: all 0.2s ease;
    background: transparent;
}

.floating input:focus + label,
.floating input:not(:placeholder-shown) + label {
    top: -8px;
    left: 10px;
    font-size: 0.8rem;
    background: #fff;
    padding: 0 6px;
    color: #4a90e2;
    font-weight: 600;
}

/* Password toggle */
.toggle-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: #aaa;
    cursor: pointer;
}

/* Button */
.btn-submit {
    padding: 0.75rem;
    background: linear-gradient(90deg, #4a90e2, #357ABD);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(74,144,226,0.4);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(74,144,226,0.6);
}

/* Links */
.text-link {
    color: #4a90e2;
    text-decoration: none;
    transition: 0.3s;
}

.text-link:hover {
    color: #357ABD;
}

/* Error alert */
.alert-danger {
    background: rgba(255, 235, 235, 0.9);
    border: 1px solid #ffb3b3;
    color: #b71c1c;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Animation */
.fade-in {
    animation: fadeIn 1s ease both;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes floatIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 480px) {
    .auth-card {
        padding: 2rem 1.5rem;
    }
}
</style>
@endsection
