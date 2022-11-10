<style type="text/css">
	.footer{
		top: 0px !important;
	}
</style>
<div class="page-container verify-account-container">
	<div class="container-body" style="padding-top: 0px;">
		<div class="verify-account-div">
			<div class="d-flex flex-column justify-content-center align-items-center verify-account-flex">
				<div class="verify-account-body">
					<input type="hidden" class="email" value="<?= $email ?>">
					<p class="main-title">Verify Email Address</p><br>
					<div class="form-group">
						<p>Enter 6-digit verfication code sent to your email address.</p>
						<input type="text" class="form-control code" placeholder="Enter code">
					</div>
					<div class="form-group" style="font-style: italic;">
						<span>Didn't received the email? <button class="btn btn-sm btn-link btn-resend">Resend it now</button></span><br>
						<span>Need Help?<button class="btn btn-sm btn-link">Contact Us</button></span>
					</div>
					<div class="warning"></div>
					<br>
					<div class="btn-group" style="display: flex !important">
						<button class="btn btn-sm btn-primary btn-verify">Verify</button>&nbsp;
						<a href="<?= base_url(); ?>" class="btn btn-sm btn-secondary">Cancel</a>
					</div>
				</div>
			</div>
		</div>

		<div class="verified-account-div" style="display: none;">
			<div class="d-flex flex-column justify-content-center align-items-center verified-account-flex" >
				<div class="verified-account-body">
					<div class="d-flex p-2 justify-content-center">
			            <img src="<?= base_url();?>assets/uploads/images/verified-email.jpg" alt="logo">
			        </div>
			        <div class="form-group d-flex p-2 justify-content-center">
			        	<span class="main-title">Email Verified</span>
			        </div>
			        <div class="form-group d-flex p-2 justify-content-center">
			        	<span >You have successfully verified your email.</span>
			        </div>
			        <div class="form-group d-flex p-2 justify-content-center">
			        	<a href="<?= base_url();?>login" class="btn btn-primary">Go to Login</a>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/verification/verify-account.js"></script>