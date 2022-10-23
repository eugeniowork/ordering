<div class="page-container change-password-container">
	<div class="container-body" style="top: 0px;">
		<div class="d-flex flex-column justify-content-center align-items-center change-password-flex">
			<div class="change-password-body">
				<p class="main-title">Change Password</p>
				<div class="form-group">
					<span>Password.</span>
					<input type="password" class="form-control password" placeholder="Enter password">
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