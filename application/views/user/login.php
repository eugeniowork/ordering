<div class="page-container login-container">
	<div class="container-body">
		<div class="d-flex flex-column justify-content-center align-items-center login-flex">
			<div class="login-body">
				<p class="main-title">Sign in to <strong><?= APPNAME ?></strong></p>
				<div class="form-group">
					<span>Email</span>
					<i class="fa fa-user"></i>
					<input type="text" class="form-control" placeholder="Enter email">
				</div>
				<div class="form-group">
					<span>Password</span>
					<i class="fa fa-lock"></i>
					<input type="password" class="form-control" placeholder="Enter password">
				</div>
				<div class="warning"></div>
				<button class="btn btn-sm btn-primary btn-login form-control">LOGIN</button>
				<button class="btn btn-link form-control btn-forgot-password" style="font-size: 12px">Forgot Password?</button>
				<a href="<?= base_url();?>signup" class="btn btn-link form-control">Signup</a>
			</div>
		</div>
	</div>
</div>