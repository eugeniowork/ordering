<div class="page-container forgot-password-container">
	<div class="container-body" style="top: 0px;">
		<div class="d-flex flex-column justify-content-center align-items-center forgot-password-flex">
			<div class="forgot-password-body">
				<p class="main-title">Rest Password</p>
				<div class="form-group">
					<p>Email address.</p>
					<input type="text" class="form-control email" placeholder="Enter email">
				</div>
				<div class="warning"></div>
				<br>
				<div class="btn-group" style="display: flex !important">
					<button class="btn btn-sm btn-primary btn-submit-email">Submit</button>&nbsp;
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

<script type="text/javascript" src="<?= base_url();?>assets/js/login/forgot-password.js"></script>