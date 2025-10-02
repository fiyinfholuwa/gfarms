@extends('auth_new.app')

@section('content')
<div class="auth-img">
    <img class="img-fluid auth-bg" 
         src="https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg" 
         alt="auth_bg" />
    <div class="auth-content">
        <div>
            <h2>Create Account</h2>
            <h4 class="p-0">Join us today, it only takes a minute!</h4>
        </div>
    </div>
</div>

<form class="auth-form" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="custom-container">

        {{-- First Name --}}
        <div class="form-group">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name" 
                   class="form-control @error('first_name') is-invalid @enderror" 
                   placeholder="Match BVN Name" value="{{ old('first_name') }}" required>
            @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Last Name --}}
        <div class="form-group">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name" 
                   class="form-control @error('last_name') is-invalid @enderror" 
                   placeholder="Match BVN Name" value="{{ old('last_name') }}" required>
            @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="Enter Email" value="{{ old('email') }}" required>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Phone --}}
        <div class="form-group">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" id="phone" name="phone" 
                   class="form-control @error('phone') is-invalid @enderror" 
                   placeholder="Number linked to your BVN" value="{{ old('phone') }}" required>
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- State --}}
        <div class="form-group">
            <label for="state" class="form-label">State</label>
            <select name="state" id="state" class="form-control @error('state') is-invalid @enderror" required>
                <option value="">Loading States...</option>
            </select>
            @error('state')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- LGA --}}
        <div class="form-group">
            <label for="lga" class="form-label">Local Government Area (LGA)</label>
            <select name="lga" id="lga" class="form-control @error('lga') is-invalid @enderror" required>
                <option value="">Select State First</option>
            </select>
            @error('lga')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <input type="hidden" name="country" value="Nigeria">

        {{-- Employee Status --}}
        <div class="form-group">
            <label for="employee_status" class="form-label">Employee Status</label>
            <select id="employee_status" name="employee_status" 
                    class="form-control @error('employee_status') is-invalid @enderror" required>
                <option value="">Select Status</option>
                <option value="Employed">Employed</option>
                <option value="Non Student/Non Employed">Non Student / Non Employed</option>
                <option value="Trader">Trader</option>
                <option value="Student">Student</option>
            </select>
            @error('employee_status')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Student Fields --}}
        <div id="student_fields" style="display:none;">
            <div class="form-group">
                <label for="student_id" class="form-label">Student ID Card</label>
                <input type="file" id="student_id" name="student_id" 
                       class="form-control @error('student_id') is-invalid @enderror" 
                       placeholder="Enter Student ID">
                @error('student_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="school_name" class="form-label">School Name</label>
                <input type="text" id="school_name" name="school_name" 
                       class="form-control @error('school_name') is-invalid @enderror" 
                       placeholder="Enter School Name">
                @error('school_name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="form-group position-relative">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Enter Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password')" 
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;">
                👁
            </button>
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group position-relative">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                   class="form-control" placeholder="Re-enter Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')" 
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;">
                👁
            </button>
        </div>

        {{-- Terms --}}
        <div class="form-group">
    <label>
        <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }}>
        I Agree to the 
        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Use</a>
    </label>
    @error('terms')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms of Use</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
        <h6>1. Introduction</h6>
        <p>
          Welcome to our food ordering platform. By accessing or using our service, 
          you agree to be bound by these Terms of Use. Please read them carefully before proceeding.
        </p>

        <h6>2. Ordering</h6>
        <p>
          Orders placed through the platform are considered final once payment is completed. 
          We prepare meals fresh, and therefore cancellations are not possible once the order is confirmed.
        </p>

        <h6>3. Payments</h6>
        <p>
          All payments are processed securely through our trusted payment partners. 
          We do not store your payment card details. You agree to pay all charges incurred by you or any users of your account.
        </p>

        <h6>4. Delivery</h6>
        <p>
          Delivery times are estimated and may vary due to traffic, weather, or availability. 
          Our team will do its best to ensure your food arrives on time and in good condition.
        </p>

        <h6>5. Food Safety & Allergies</h6>
        <p>
          We strive to provide accurate information about ingredients and allergens. 
          However, we cannot guarantee that food is free from traces of allergens. 
          Customers are advised to review meal descriptions carefully before ordering.
        </p>

        <h6>6. Refunds</h6>
        <p>
          Refunds will only be provided if your order cannot be fulfilled due to circumstances on our end. 
          In cases of late delivery or dissatisfaction, please contact customer support for assistance.
        </p>

        <h6>7. User Responsibilities</h6>
        <p>
          You agree to use the platform lawfully and not for fraudulent or abusive purposes. 
          Misuse of the service may result in suspension or termination of your account.
        </p>

        <h6>8. Limitation of Liability</h6>
        <p>
          Our company shall not be held liable for any indirect, incidental, or consequential damages 
          arising from the use of the service, including but not limited to allergic reactions or late deliveries.
        </p>

        <h6>9. Governing Law</h6>
        <p>
          These Terms of Use are governed by and construed in accordance with the laws of your jurisdiction. 
          Any disputes shall be resolved in the competent courts within our operational area.
        </p>

        <h6>10. Changes to Terms</h6>
        <p>
          We reserve the right to modify or update these terms at any time. 
          Continued use of the service indicates your acceptance of the updated terms.
        </p>

        <p>
          Thank you for choosing our platform to buy food and pay small!
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        {{-- Submit --}}
        <div class="submit-btn mt-3">
            <button type="submit" class="btn auth-btn w-100">
                <i class="fa fa-user-plus"></i> Sign Up
            </button>
        </div>

        <h4 class="signup mt-3">
            Already have an account? <a style="color:black; font-weight:bold;" href="{{ route('login') }}"> Sign In</a>
        </h4>
    </div>
</form>

{{-- Scripts --}}
<script>
    function togglePassword(fieldId) {
        let field = document.getElementById(fieldId);
        field.type = field.type === "password" ? "text" : "password";
    }

    document.addEventListener("DOMContentLoaded", function () {
        const employeeStatus = document.getElementById("employee_status");
        const studentFields = document.getElementById("student_fields");
        const studentIdInput = document.getElementById("student_id");
        const schoolNameInput = document.getElementById("school_name");

        function toggleStudentFields() {
            if (employeeStatus.value === "Student") {
                studentFields.style.display = "block";
                studentIdInput.required = true;
                schoolNameInput.required = true;
            } else {
                studentFields.style.display = "none";
                studentIdInput.required = false;
                schoolNameInput.required = false;
                studentIdInput.value = "";
                schoolNameInput.value = "";
            }
        }

        employeeStatus.addEventListener("change", toggleStudentFields);
        toggleStudentFields();

        // Load states
        fetch("{{ url('/locations/states') }}")
            .then(res => res.json())
            .then(states => {
                let stateDropdown = document.getElementById("state");
                stateDropdown.innerHTML = '<option value="">Select State</option>';
                states.forEach(state => {
                    stateDropdown.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                });
            });

        // Load LGAs when state changes
        document.getElementById("state").addEventListener("change", function() {
            let selectedState = this.value;
            let lgaDropdown = document.getElementById("lga");
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
@endsection
