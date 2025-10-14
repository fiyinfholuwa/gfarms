@extends('auth_new.app')

@section('content')


<!-- Modal CSS -->
<style>
    .action_modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .action_modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .action_modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 32px;
        max-width: 400px;
        width: 90%;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.3);
        transform: scale(0.9) translateY(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-align: center;
        position: relative;
    }

    .action_modal-overlay.active .action_modal {
        transform: scale(1) translateY(0);
    }

    .action_modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .action_modal-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .action_modal-icon.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .action_modal-icon.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .action_modal-icon.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .action_modal-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .action_modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .action_modal-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .action_modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }
</style>

<!-- Modal HTML -->
<div class="action_modal-overlay" id="clipboardModal" onclick="closeClipboardModal(event)">
    <div class="action_modal" onclick="event.stopPropagation()">
        <div class="action_modal-icon" id="modalIcon">
            <span id="modalIconText"><i class="fa fa-info-circle text-white"></i></span>
        </div>
        <h3 class="action_modal-title" id="modalTitle">Notice</h3>
        <p class="action_modal-message" id="modalMessage">This is a message.</p>
        <button class="action_modal-btn" onclick="closeClipboardModal()">Ok</button>
    </div>
</div>

<!-- Modal JS -->
<script>
    function showSessionModal(type, message) {
        const overlay = document.getElementById('clipboardModal');
        const icon = document.getElementById('modalIcon');
        const iconText = document.getElementById('modalIconText');
        const title = document.getElementById('modalTitle');
        const msg = document.getElementById('modalMessage');

        // Reset classes to allow proper icon color
        icon.className = 'action_modal-icon';

        if (type === 'success') {
            icon.classList.add('success');
            iconText.innerHTML = '<i class="fa fa-check-circle text-white"></i>';
            title.textContent = 'Success!';
        } else if (type === 'info') {
            icon.classList.add('info');
            iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
            title.textContent = 'Info';
        } else if (type === 'warning') {
            icon.classList.add('warning');
            iconText.innerHTML = '<i class="fa fa-exclamation-triangle text-white"></i>';
            title.textContent = 'Warning';
        } else if (type === 'error') {
            icon.classList.add('error');
            iconText.innerHTML = '<i class="fa fa-times-circle text-white"></i>';
            title.textContent = 'Error';
        } else {
            icon.classList.add('info');
            iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
            title.textContent = 'Notice';
        }

        msg.textContent = message;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeClipboardModal(event) {
        if (event && event.target !== event.currentTarget) return;

        const overlay = document.getElementById('clipboardModal');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modal on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeClipboardModal();
        }
    });

    @if(Session::has('message'))
    // Get Laravel flash message type and message
    const type = "{{ Session::get('alert-type', 'info') }}";
    const message = "{{ Session::get('message') }}";

    // Show modal on page load
    showSessionModal(type, message);

    // Clear session keys so it won't show again
    {{ Session::forget('message') }}
    {{ Session::forget('alert-type') }}
    @endif
</script>


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

<form class="auth-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                    class="form-control @error('student_id') is-invalid @enderror">
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

        {{-- Proceed Button --}}
        <div class="submit-btn mt-3">
            <button type="button" class="btn auth-btn w-100" id="proceedBtn">
                <i class="fa fa-arrow-right"></i> Proceed
            </button>
        </div>

        <h4 class="signup mt-3">
            Already have an account?
            <a style="color:black; font-weight:bold;" href="{{ route('login') }}">Sign In</a>
        </h4>
    </div>
</form>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms of Use</h5>
      </div>

      <div class="modal-body terms-content" style="max-height: 400px; overflow-y: auto; line-height: 1.6;">
        {!! $settings->login_terms ?? "Not Set" !!}
      </div>

      <div class="modal-footer d-flex justify-content-between terms-footer" style="display: none; opacity: 0; transition: opacity 0.3s ease;">
        <button  type="button" class="btn btn-dark" data-bs-dismiss="modal">Decline</button>
        <button style="background:darkorange; color:white;" type="button" class="btn btn-warning" id="acceptTermsBtn">Accept</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('termsModal');

    modal.addEventListener('shown.bs.modal', function() {
        const termsBody = modal.querySelector('.terms-content');
        const footer = modal.querySelector('.terms-footer');

        // Always hide the buttons first when modal opens
        footer.style.display = 'none';
        footer.style.opacity = '0';

        if (termsBody && footer) {
            // When user scrolls
            termsBody.addEventListener('scroll', function onScroll() {
                const scrollPosition = termsBody.scrollTop + termsBody.clientHeight;
                const scrollHeight = termsBody.scrollHeight;

                // If user reaches bottom of scrollable area
                if (scrollPosition >= scrollHeight - 5) {
                    footer.style.display = 'flex';
                    setTimeout(() => footer.style.opacity = '1', 50);
                } else {
                    // Hide again if user scrolls back up
                    footer.style.opacity = '0';
                    setTimeout(() => footer.style.display = 'none', 300);
                }
            });
        }
    });
});
</script>

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

    // Load LGAs
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

    // Proceed Button → Open Terms Modal
    document.getElementById("proceedBtn").addEventListener("click", function() {
        let termsModal = new bootstrap.Modal(document.getElementById("termsModal"));
        termsModal.show();
    });

    // Accept Button → Submit Form
    document.getElementById("acceptTermsBtn").addEventListener("click", function() {
        let termsModalEl = document.getElementById("termsModal");
        let modalInstance = bootstrap.Modal.getInstance(termsModalEl);
        modalInstance.hide();

        document.querySelector(".auth-form").submit();
    });
});
</script>
@endsection
