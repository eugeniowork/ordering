<div class="page-container change-password-container">
	<div class="container-body" style="padding-top: 10px;">
		<div class="d-flex flex-column justify-content-center align-items-center change-password-flex">
			<div class="change-password-body">
				<p class="main-title">Change Password</p>
				<div class="form-group">
					<span>Password.</span>
					<input type="password" class="form-control password" placeholder="Enter password">
					<div class="password-requirement-container">
	                	<div class="one-upper"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
	                	<div class="one-lower"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
	                	<div class="one-number"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one number.</div>
	                	<div class="one-special-char"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one special character.</div>
	                	<div class="six-char-long"><i class="fa fa-check-circle"></i>&nbsp;Must be at least 6 characters in length.</div>
	                </div>
				</div>
				<div class="form-group">
					<span>Confirm Password.</span>
					<input type="password" class="form-control confirm-password" placeholder="Enter confirm password">
				</div>
				<div class="warning"></div>
				<br>
				<div class="btn-group" style="display: flex !important">
					<button class="btn btn-sm btn-primary btn-submit">Submit</button>&nbsp;
					<a href="<?= base_url(); ?>" class="btn btn-sm btn-secondary">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal success-modal modal-theme" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
            	<p style="font-size: 80px;"><i class="text-success fas fa-check-circle"></i></p>
            	<p style="font-weight: 600;" class="success-msg"></p>
            	<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<script>
	var email = '<?= $email ?>';
</script>

<script type="text/javascript" src="<?= base_url();?>assets/js/login/change-password.js"></script>