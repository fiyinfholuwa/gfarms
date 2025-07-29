@extends('auth.app')

@section('content')

<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="ec-brand">
                        <a href="" title="Ekka">
									<img class="ec-brand-icon" src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="" />
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">Sign Up</h4>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <!-- Full Name -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}">
                                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- State Dropdown -->
                            <div class="form-group col-md-12 mb-3">
                                <select name="state" id="state" class="form-control">
                                    <option value="">Loading States...</option>
                                </select>
                                @error('state')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- LGA Dropdown -->
                            <div class="form-group col-md-12 mb-3">
                                <select name="lga" id="lga" class="form-control">
                                    <option value="">Select State First</option>
                                </select>
                                @error('lga')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Country -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="text" name="country" class="form-control" value="Nigeria" readonly>
                            </div>

                            <!-- Password -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group col-md-12 mb-3">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            </div>

                            <!-- Terms -->
                            <div class="col-md-12 mb-3">
                                <label><input type="checkbox" name="terms"> I Agree to the Terms</label>
                                @error('terms')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary  mb-3">
                                    <i class="fa fa-user-plus"></i> Sign Up
                                </button>
                                <p class="sign-upp">You Already have an account?
                <a class="text-blue" href="{{ route('login') }}">Sign In</a>
            </p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
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

    // ✅ When state changes, fetch LGAs via Laravel endpoint
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
