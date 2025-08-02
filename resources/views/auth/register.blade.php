@extends('auth.app')

@section('content')
<style>
    .signup-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        flex-wrap: wrap;
    }
    .signup-image {
        flex: 1;
        background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBT3kvoSawunVAxcSG_6vFcNUcGx9Sm138vQ&s') no-repeat center center;
        background-size: cover;
    }
    .signup-form-section {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        background: #fff;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }
    .signup-card {
        width: 100%;
        max-width: 450px;
    }
    .signup-card h4 {
        margin-bottom: 20px;
        color: #333;
    }
    .signup-card .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    .signup-card button {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-size: 16px;
    }
    .signup-card .text-blue {
        color: #007bff;
        text-decoration: none;
    }
    .signup-card .text-blue:hover {
        text-decoration: underline;
    }
    .brand-logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .brand-logo img {
        max-width: 180px;
    }

    /* ✅ Hide image on small screens */
    @media (max-width: 768px) {
        .signup-image {
            display: none;
        }
        .signup-form-section {
            flex: 1 1 100%;
            box-shadow: none;
        }
    }
</style>

<div class="signup-container">
    <!-- Left Image -->
    <div class="signup-image"></div>

    <!-- Right Signup Form -->
    <div class="signup-form-section">
        <div class="signup-card">
            <div class="brand-logo">
                <a href="#">
                    <img src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="Logo">
                </a>
            </div>

            <h4>Sign Up</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}">
                        @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
                        @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <select name="state" id="state" class="form-control">
                            <option value="">Loading States...</option>
                        </select>
                        @error('state')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <select name="lga" id="lga" class="form-control">
                            <option value="">Select State First</option>
                        </select>
                        @error('lga')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div style="display:none;" class="form-group col-md-12 mb-3">
                        <input type="text" name="country" class="form-control" value="Nigeria" readonly>
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label><input type="checkbox" name="terms"> I Agree to the Terms</label>
                        @error('terms')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mb-3">
                            <i class="fa fa-user-plus"></i> Sign Up
                        </button>
                        <p>You already have an account?
                            <a class="text-blue" href="{{ route('login') }}">Sign In</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    let stateDropdown = $("#state");
    let lgaDropdown = $("#lga");

    // ✅ Load states from Laravel endpoint
    $.get("{{ url('/locations/states') }}", function(states) {
        stateDropdown.empty().append('<option value="">Select State</option>');
        states.forEach(function(state){
            stateDropdown.append('<option value="'+ state.id +'">'+ state.name +'</option>');
        });
    });

    // ✅ Load LGAs dynamically
    stateDropdown.on("change", function(){
        let selectedState = $(this).val();
        if(selectedState){
            lgaDropdown.empty().append('<option>Loading LGAs...</option>');
            $.get("{{ url('/locations/lgas') }}/" + encodeURIComponent(selectedState), function(data){
                lgaDropdown.empty().append('<option value="">Select LGA</option>');
                if(data.lgas){
                    data.lgas.forEach(function(lga){
                        lgaDropdown.append('<option value="'+ lga +'">'+ lga +'</option>');
                    });
                }
            });
        } else {
            lgaDropdown.empty().append('<option value="">Select State First</option>');
        }
    });
});
</script>
@endsection
