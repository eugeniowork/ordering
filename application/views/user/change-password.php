<div class="page-container change-my-password-container">
	<div class="container-header">
		<span class="header-title">Change Password</span><br>
		<div class="buttons">
			<button class="btn btn-sm btn-primary btn-save">Save</button>
            <a onclick="window.history.go(-1); return false;" class="btn btn-sm btn-primary">Back</a>
        </div>
	</div>
	<div class="container-body">
		<form id="form">
			<div class="row">
				<div class="col-12 col-lg-3">
                    <span>Old Password&nbsp;<span class="text-danger">*</span></span>
                    <input type="password" class="form-control" name="old_password" placeholder="Enter old password" required/>
                </div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-3">
                    <span>New Password&nbsp;<span class="text-danger">*</span></span>
                    <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required/>
                    <div class="password-requirement-container">
	                	<div class="one-upper"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
	                	<div class="one-lower"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
	                	<div class="one-number"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one number.</div>
	                	<div class="one-special-char"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one special character.</div>
	                	<div class="six-char-long"><i class="fa fa-check-circle"></i>&nbsp;Must be at least 6 characters in length.</div>
	                </div>
                </div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-3">
                    <span>Confirm Password&nbsp;<span class="text-danger">*</span></span>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Enter confirm password" required/>
                </div>
			</div>
        </form>
	</div>
</div>

<div class="modal fade" id="warning_modal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editAttendanceModalLongTitle">Warning</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">Okay</button>
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

<script type="text/javascript" src="<?= base_url();?>assets/js/user/change-password.js"></script>