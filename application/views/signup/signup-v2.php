<style type="text/css">
	/*.footer{
		top: 0px !important;
	}*/
	body{
		background: #A87824 !important;
	}
	@media screen and (max-width : 950px){
		body{
			background: white !important;
		}
	}
</style>
<div class="page-container signup-v2-container">
	<div class="container-body" style="padding-top: 0px;">
		<div class="d-flex flex-column justify-content-center align-items-center signup-v2-flex">
			<div class="signup-v2-body">
				<form id="form" enctype="multipart/form-data" autocomplete="off">
					<p class="main-title">Sign up to <strong><?= APPNAME ?></strong></p>
					<div class="face-container">
			        	<div class="row">
				            <div class="col-12 col-lg-12" style="text-align: center;">
				            	<span>Face Recognition&nbsp;<span class="text-danger">*</span></span><br>
				            	<img id="img_face" src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg"><br>
				                <button type="button" class="btn btn-sm btn-primary btn-open-camera" style="width: 130px">Register Face</button>
				            </div>
			            </div>
			        </div>
					<div class="info-container">
			            <div class="row">
			                <div class="col-12 col-lg-6">
			                    <span>Lastname&nbsp;<span class="text-danger">*</span></span>
			                    <input type="text" class="form-control text-only" name="lastname" placeholder="Enter lastname" required/>
			                </div>
			                <div class="col-12 col-lg-6">
			                    <span>Firstname&nbsp;<span class="text-danger">*</span></span>
			                    <input type="text" class="form-control text-only" name="firstname" placeholder="Enter firstname" required/>
			                </div>
			                <div class="col-12 col-lg-6">
			                    <span>Middlename&nbsp;</span>
			                    <input type="text" class="form-control text-only" name="middlename" placeholder="Enter middlename" />
			                </div>
			                <div class="col-12 col-lg-6">
				                <span>Email Address&nbsp;<span class="text-danger">*</span></span>
				                <input type="text" class="form-control" name="email" placeholder="Enter email" required/>
				                <small class="email-warning text-danger"></small>
				            </div>
				            <div class="col-12 col-lg-6">
				                <span>Password&nbsp;<span class="text-danger">*</span></span>
				                <input type="password" class="form-control" name="password" placeholder="Enter password" required/>
				                <div class="password-requirement-container">
				                	<div class="one-upper"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
				                	<div class="one-lower"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one uppercase letter.</div>
				                	<div class="one-number"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one number.</div>
				                	<div class="one-special-char"><i class="fa fa-check-circle"></i>&nbsp;Must contain at least one special character.</div>
				                	<div class="six-char-long"><i class="fa fa-check-circle"></i>&nbsp;Must be at least 6 characters in length.</div>
				                </div>
				            </div>
				            <div class="col-12 col-lg-6">
				                <span>Confirm Password&nbsp;<span class="text-danger">*</span></span>
				                <input type="password" class="form-control" name="confirm_password" placeholder="Enter password" required/>
				            </div>
			            </div>
			        </div>
			        <br>
			        <div class="btn-group">
			        	<button class="btn btn-sm btn-primary btn-save-registration" disabled>Save</button>&nbsp;
			        	<a class="btn btn-sm btn-primary" href="<?= base_url();?>login">Go to Login</a>
			        </div><br><br>
				</form>
				<div class="signup-terms-container">
					<span>By using this website, you fully understand the <a class="btn-show-terms" style="cursor: pointer;">Terms and Condition.</a>You grant the permission and right to take photographs of you as a required part of the process.</span><br>
		        	<span><input type="checkbox" class="i-agree-checkbox-signup" id="iAgreeCheckboxSignup">&nbsp;&nbsp;<label for="iAgreeCheckboxSignup">I agree to the terms and condition.</label></span>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="face_modal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editAttendanceModalLongTitle">Register Face</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="webcam-container col-12 col-md-8 col-xl-9 align-top" id="webcam-container">
						<div class="video-container"><video id="webcam" autoplay muted playsinline></video></div>
						<div class="loading d-none">
							<center>Detecting face</center>
							<div class="spinner-border" role="status">
								<span class="sr-only"></span>
							</div>
	                    </div>
						<div id="error_msg" class="col-12 alert-danger d-none">
	                        <span>Fail to start camera</span> <br>
	                        <span>1. Please allow permission to access camera.</span> <br>
	                        <span>2. If you are browsing through social media built in browsers, look for the ... or browser icon on the right top/bottom corner, and open the page in Sarafi (iPhone)/ Chrome (Android)</span>
	                    </div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary btn-submit-face" disabled>Submit</button>
				</div>
			</div>
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

	<div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="terms_for_signup_modal" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title">Terms and Conditions</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	            	<p><b>RETENTION OF DATA</b></p>
	            	<p>The personal data of registered customers will be kept for the duration of studying in the university.</p>
	            	<p><?= APPNAME ?> will retain your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes and enforce our legal agreements and policies.</p>
	                <p><?= APPNAME ?> will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of our Service, or we are legally obligated to retain this data for more extended periods.
	                </p>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/signup/signup-v2.js"></script>