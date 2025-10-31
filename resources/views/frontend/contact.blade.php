@extends('frontend.app')

@section('content')

<!-- ===============================
Contact Section
=============================== -->
<section class="contact-section py-5" style="background:#f7fdf8;">
    <div class="container">
        
        <!-- Title -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="color:#208a3e;">Get in Touch with Us</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                At <strong>Ginella Farms</strong>, we are passionate about delivering fresh, nutritious, and hygienic products. 
                Reach out to us for inquiries, partnerships, or orders — we’d love to hear from you.
            </p>
        </div>

        <!-- Contact Info Cards -->
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="info-box text-center p-4 h-100">
                    <div class="icon mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <p class="text-muted small mb-0">123 Protein Street, Ibadan, Nigeria</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-box text-center p-4 h-100">
                    <div class="icon mb-3" style="color:#ff8c00;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <p class="text-muted small mb-0">
                        <a href="tel:+2340000000000" class="text-muted text-decoration-none">+234 000 000 0000</a><br>
                        <a href="tel:+2340000000000" class="text-muted text-decoration-none">+234 000 000 0000</a>
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-box text-center p-4 h-100">
                    <div class="icon mb-3" style="color:#28a745;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="text-muted small mb-0">
                        <a href="mailto:info@ginellafarms.com.ng" class="text-muted text-decoration-none">
                            info@ginellafarms.com.ng
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-box text-center p-4 h-100">
                    <div class="icon mb-3" style="color:#ff8c00;">
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form-container p-5 shadow-lg rounded-4 bg-white">
                    <h4 class="text-center mb-4 fw-bold" style="color:#208a3e;">Send Us a Message</h4>
                  


<form method="POST" action="{{ route('contact.send') }}">
    @csrf
    <div class="row g-3">
        <div class="col-md-6">
            <input type="text" name="name" value="{{ old('name') }}"
                class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                placeholder="Your Name" required>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                placeholder="Email Address" required>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <input type="tel" name="phone" value="{{ old('phone') }}"
                class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                placeholder="Phone Number" required>
            @error('phone')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <select name="subject"
                class="form-select form-select-lg rounded-3 @error('subject') is-invalid @enderror"
                required>
                <option value="">Select Subject</option>
                <option {{ old('subject') == 'Product Inquiry' ? 'selected' : '' }}>Product Inquiry</option>
                <option {{ old('subject') == 'Wholesale Order' ? 'selected' : '' }}>Wholesale Order</option>
                <option {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
            </select>
            @error('subject')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <textarea name="message"
                class="form-control form-control-lg rounded-3 @error('message') is-invalid @enderror"
                rows="4" placeholder="Your Message..." required>{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-lg px-5 text-white rounded-pill"
                style="background:linear-gradient(90deg,#28a745,#ff8c00); border:none;">
                Send Message <i class="fas fa-paper-plane ms-2"></i>
            </button>
        </div>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .info-box {
        border-radius: 12px;
        background: #fff;
        transition: all 0.3s ease;
        border: 1px solid #e6f4ea;
    }
    .info-box:hover {
        transform: translateY(-5px);
        border-color: #28a745;
        box-shadow: 0 8px 18px rgba(0, 128, 0, 0.1);
    }
    .info-box .icon i {
        font-size: 30px;
        color: #28a745;
    }
    .social-btn {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #28a745, #ff8c00);
        color: #fff;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        transition: all 0.3s;
    }
    .social-btn:hover {
        transform: scale(1.15);
        background: linear-gradient(135deg, #ff8c00, #28a745);
    }
    .contact-form-container {
        transition: all 0.4s ease;
    }
    .contact-form-container:hover {
        box-shadow: 0 10px 25px rgba(0, 128, 0, 0.1);
    }
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.1);
    }
</style>

@endsection
