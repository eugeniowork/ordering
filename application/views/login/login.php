<div class="page-container login-container">
	<div class="container-body" style="top: 0px;">
		<div class="d-flex flex-column justify-content-center align-items-center login-flex">
			<div class="login-body">				
				<form class="login-form">
					<p class="main-title">Sign in to <strong><?= APPNAME ?></strong></p>
					<div class="form-group">
						<span>Email</span>
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="email" placeholder="Enter email" required>
					</div>
					<div class="form-group">
						<span>Password</span>
						<i class="fa fa-lock"></i>
						<input type="password" class="form-control" name="password" placeholder="Enter password" required>
					</div>
					<div class="warning"></div>
					<button type="submit" class="btn btn-sm btn-primary btn-login form-control">LOGIN</button>
					<button type="button" class="btn btn-link form-control btn-forgot-password" style="font-size: 12px">Forgot Password?</button>
					<a href="<?= base_url();?>signup" class="btn btn-link form-control">Signup</a>
				</form>

				<div class="otp-form">
					<div class="form-group">
						<p class="main-title">Enter your One-Time Password</p>
						<p style="font-size: 13px;">You will receive a One-Time Password (OTP) on your registered email address.</p>
						<input type="text" class="form-control code" placeholder="Enter code">
					</div>
					<div class="form-group" style="font-style: italic;">
						<span>Didn't received the email? <button class="btn btn-sm btn-link btn-resend">Resend it now</button></span><br>
						<span>Need Help?<button class="btn btn-sm btn-link">Contact Us</button></span>
					</div>
					<div class="warning"></div>
					<br>
					<div class="btn-group" style="display: flex !important">
						<button class="btn btn-sm btn-primary btn-submit-otp">Submit</button>&nbsp;
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/login/login.js"></script>