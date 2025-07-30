@extends('auth.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center">
<div class="card-header bg-primary">
							<div class="ec-brand">
								<a href="" title="Ekka">
                                                            
									<img class="ec-brand-icon" src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="" />
								</a>
							</div>
						</div>
                </div>
                <div class="card-body p-5 text-center">
                    <p class="mb-4">Enter the 6-digit OTP sent to your email</p>

                    {{-- ✅ OTP Verification Form --}}
                    <form action="{{ route('otp.verify.submit') }}" method="POST" id="otpForm">
                        @csrf
                        <div class="d-flex justify-content-between otp-input-group mb-4">
                            @for($i = 1; $i <= 6; $i++)
                                <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
                            @endfor
                        </div>

                        @error('otp')
                            <small style="color:red; font-weight:bolder;" class="text-danger">{{ $message }}</small>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-block mb-3">Verify OTP</button>
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
    </div>
</div>

{{-- ✅ CSS for OTP Boxes --}}
<style>
.otp-input-group {
    gap: 10px;
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
</style>

{{-- ✅ JavaScript for Smooth Input Navigation --}}
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
@endsection
