<div class="page-container login-container">
	<div class="container-body">
		<div class="d-flex flex-column justify-content-center align-items-center login-flex">
			<div class="login-body">				<form class="login-form">
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
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/login/login.js"></script>