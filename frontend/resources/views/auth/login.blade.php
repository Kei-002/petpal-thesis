@extends('layouts.base')
@section('body')

<link rel="stylesheet" href="{{ asset('css/loginPage.css') }}">
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" id="loginForm">
					@csrf
					<span class="login100-form-title p-b-43 mb-4">
						<strong>Login to continue</strong>
					</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" id="email">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" id="password" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						{{-- <div class="contact100-form-checkbox my-2">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div> --}}

						<div class="my-1">
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" id="loginSubmit">
							Login
						</button>
					</div>
					
					{{-- <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div> --}}

				</form>

				<div class="login100-more" style="background-image: url('{{ asset('images/loginHero.jpg') }}');">
				</div>
                
			</div>
		</div>
        
	</div>

    
	
	
	<script src="{{ asset('js/loginPage.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>

</body>




@endsection