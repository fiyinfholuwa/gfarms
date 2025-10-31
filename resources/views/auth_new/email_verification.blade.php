@extends('auth_new.app')

@section('content')
<div class="auth-img">
    
    
</div>

<form style="margin-top:100px;" class="auth-form" id="verifyOtpForm" method="POST" action="{{ route('otp.verify.submit') }}">
    @csrf
    <div class="custom-container">

<div class="auth-content text-center">
        {{-- ✅ Logo section (same as login) --}}
        
        <div>
            <h2 class="text-dark">Email Verification</h2>
            <h4  class="text-dark p-0">Enter the 6-digit OTP sent to your email</h4>
        </div>
    </div>
<div class="mb-4">
           <a href="#">
                    <img style="width:120px; text-align:center;" src="{{ asset('logo.png') }}" alt="Logo">
                </a>
                
        </div>

        {{-- OTP Input Fields --}}
        <div class="form-group text-center mb-4">
            <div class="otp-input-group d-flex justify-content-center gap-2 mb-2">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" name="otp[]" maxlength="1" class="otp-input form-control text-center" required>
                @endfor
            </div>
            <div id="otpMessage" class="text-center mt-2"></div>
        </div>

        {{-- Verify Button --}}
        <div class="submit-btn mb-3">
            <button type="submit" class="btn auth-btn w-100">
                <i class="fa fa-spin fa-spinner d-none me-2" id="verifyLoader"></i>
                Verify OTP
            </button>
        </div>

        {{-- Bottom Links --}}
        <div class="text-center mt-3">
            <button type="button" id="resendOtpBtn" class="btn btn-link text-success fw-semibold">
                <i class="fa fa-spin fa-spinner d-none me-2" id="resendLoader"></i>
                Resend OTP
            </button>
            <p class="mt-2 mb-0">
                <a href="{{ route('logout') }}" class="text-dark">
                    <i class="fa fa-arrow-left me-1"></i> Back to Login
                </a>
            </p>
        </div>
    </div>
</form>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- OTP Scripts --}}
<script>
document.querySelectorAll('.otp-input').forEach((input, index, arr) => {
    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 1 && index < arr.length - 1) arr[index + 1].focus();
    });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && index > 0) arr[index - 1].focus();
    });
});

// ✅ Verify OTP
document.getElementById('verifyOtpForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const loader = document.getElementById('verifyLoader');
    const messageBox = document.getElementById('otpMessage');

    loader.classList.remove('d-none');
    messageBox.innerHTML = "";

    fetch(form.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": form.querySelector('[name=_token]').value,
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            otp: Array.from(form.querySelectorAll('input[name="otp[]"]'))
                .map(i => i.value)
                .join('')
        })
    })
    .then(async res => {
        let data = await res.json().catch(() => ({}));
        if (res.ok && data.status) {
            messageBox.innerHTML = `<span class="text-success"><i class="fa fa-check-circle"></i> ${data.message}</span>`;
            setTimeout(() => window.location.href = "{{ route('user.orders') }}", 1200);
        } else {
            messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> ${data.message || 'Invalid OTP. Try again.'}</span>`;
            form.querySelectorAll('.otp-input').forEach(i => i.value = '');
            form.querySelector('.otp-input').focus();
        }
    })
    .catch(error => {
        messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ${error.message}</span>`;
    })
    .finally(() => loader.classList.add('d-none'));
});

// ✅ Resend OTP
document.getElementById('resendOtpBtn').addEventListener('click', function () {
    const loader = document.getElementById('resendLoader');
    const messageBox = document.getElementById('otpMessage');

    loader.classList.remove('d-none');
    messageBox.innerHTML = "";

    fetch("{{ route('otp.resend') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('[name=_token]').value,
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            messageBox.innerHTML = `<span class="text-success"><i class="fa fa-check-circle"></i> ${data.message}</span>`;
            document.querySelectorAll('.otp-input').forEach(i => i.value = '');
            document.querySelector('.otp-input').focus();
        } else {
            messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> ${data.message || 'Could not resend OTP.'}</span>`;
        }
    })
    .catch(() => {
        messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Failed to resend OTP.</span>`;
    })
    .finally(() => loader.classList.add('d-none'));
});
</script>

{{-- Styling to Match Login Page --}}
<style>
.auth-form {
    background-color: #d4edda; /* ✅ very light green background */
    border-radius: 10px;
    padding: 2rem;
    width: 100%;
    max-width: 400px;
    margin: auto;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.auth-content h2 {
    font-weight: 700;
    color: #fff;
}
.auth-content h4 {
    font-weight: 400;
    color: #fff;
    margin-top: 8px;
}
.otp-input {
    width: 48px;
    height: 52px;
    font-size: 20px;
    text-align: center;
    border-radius: 8px;
    border: 2px solid #ccc;
    transition: border-color 0.3s ease;
}
.otp-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 6px rgba(40, 167, 69, 0.3);
}
.btn.auth-btn {
    background-color: #28a745;
    border: none;
    color: #fff;
    font-weight: 600;
    transition: 0.3s ease;
}
.btn.auth-btn:hover {
    background-color: #218838;
}
#otpMessage {
    font-size: 0.9rem;
}
</style>
@endsection
