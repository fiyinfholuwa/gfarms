@extends('auth.app')

@section('content')
<style>
    .otp-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        flex-wrap: wrap;
    }
    .otp-image {
        flex: 1;
        background: url('https://businesspost.ng/wp-content/uploads/2023/08/Raw-Food-Items.jpg') no-repeat center center;
        background-size: cover;
    }
    .otp-section {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        background: #fff;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }
    .otp-card {
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .brand-logo {
        margin-bottom: 20px;
    }
    .brand-logo img {
        max-width: 180px;
    }
    .otp-input-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .otp-input {
        width: 45px;
        height: 50px;
        font-size: 20px;
        text-align: center;
        border: 2px solid #ddd;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .otp-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.5);
        outline: none;
    }
    .otp-card button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 8px;
    }
    .otp-card a {
        color: #007bff;
        text-decoration: none;
    }
    .otp-card a:hover {
        text-decoration: underline;
    }

    /* ✅ Hide image on small screens */
    @media (max-width: 768px) {
        .otp-image {
            display: none;
        }
        .otp-section {
            flex: 1 1 100%;
            box-shadow: none;
        }
    }
</style>

<div class="otp-container">
    <!-- Left Image -->
    <div class="otp-image"></div>

    <!-- OTP Form Section -->
    <div class="otp-section">
        <div class="otp-card">
            <div class="brand-logo">
                <a href="#">
                    <img src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="Logo">
                </a>
            </div>

            <p class="mb-4">Enter the 6-digit OTP sent to your email</p>

            {{-- ✅ OTP Verification Form --}}
            <form action="{{ route('otp.verify.submit') }}" method="POST" id="otpForm">
                @csrf
                <div class="otp-input-group">
                    @for($i = 1; $i <= 6; $i++)
                        <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
                    @endfor
                </div>
                @error('otp')
                    <small style="color:red; font-weight:bolder;">{{ $message }}</small>
                @enderror
                <button type="submit" class="btn btn-primary mb-3">Verify OTP</button>
            </form>

            {{-- ✅ Resend OTP --}}
            <form action="{{ route('otp.resend') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link">Resend OTP</button>
            </form>

            <p class="mt-3"><a href="{{ route('login') }}">Back to Login</a></p>
        </div>
    </div>
</div>

{{-- ✅ JavaScript for OTP Navigation --}}
<script>
document.querySelectorAll('.otp-input').forEach((input, index, arr) => {
    input.addEventListener('input', function () {
        if (this.value.length === 1 && index < arr.length - 1) {
            arr[index + 1].focus();
        }
    });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            arr[index - 1].focus();
        }
    });
});
</script>

{{-- ✅ Custom Toast Styles --}}
<style>
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #007bff;
    color: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.4s ease;
    z-index: 9999;
}
.toast.show {
    opacity: 1;
    transform: translateY(0);
}
.toast.error {
    background: #dc3545;
}
.toast.success {
    background: #28a745;
}
</style>

@if(session('status'))
    <div id="toast" class="toast success">{{ session('status') }}</div>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {
    const toast = document.getElementById("toast");
    if(toast){
        toast.classList.add("show");
        setTimeout(() => {
            toast.classList.remove("show");
        }, 4000); // ✅ Hide after 4 seconds
    }
});
</script>


@endsection
