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
							<h4 class="text-dark mb-5">Sign In</h4>
							
							<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-12 mb-4">
            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <small style="color:red; font-weight:bolder;" class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group col-md-12">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            @error('password')
                <small style="color:red; font-weight:bolder;" class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-12">
            <div class="d-flex my-2 justify-content-between">
                <div class="d-inline-block mr-3">
                    {{-- <div class="control control-checkbox">Remember me
                        <input type="checkbox" name="remember" />
                        <div class="control-indicator"></div>
                    </div> --}}
                </div>
                <p><a class="text-blue" href="{{ route('password.request') }}">Forgot Password?</a></p>
            </div>

            <button type="submit" class="btn btn-primary  mb-4">Sign In</button>

            <p class="sign-upp">Don't have an account yet ?
                <a class="text-blue" href="{{ route('register') }}">Sign Up</a>
            </p>
        </div>
    </div>
</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	
@endsection