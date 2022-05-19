<div class="page-container signup-v2-container">
	<div class="container-body" style="top: 0px;">
		<div class="d-flex flex-column justify-content-center align-items-center signup-v2-flex">
			<div class="signup-v2-body">
				<form id="form" enctype="multipart/form-data" autocomplete="off">
					<p class="main-title">Sign up to <strong><?= APPNAME ?></strong></p>
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
				            </div>
				            <div class="col-12 col-lg-6">
				                <span>Confirm Password&nbsp;<span class="text-danger">*</span></span>
				                <input type="password" class="form-control" name="confirm_password" placeholder="Enter password" required/>
				            </div>
			            </div>
			        </div>
			        <div class="face-container">
			        	<div class="row">
				            <div class="col-12 col-lg-3">
				            	<span>Face Recognition&nbsp;<span class="text-danger">*</span></span><br>
				            	<img id="img_face" src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg"><br>
				                <button type="button" class="btn btn-sm btn-primary btn-open-camera" style="width: 130px">Register Face</button>
				            </div>
			            </div>
			        </div>
			        <div class="btn-group pull-right">
			        	<button class="btn btn-sm btn-primary btn-save-registration">Save</button>
			        </div>
				</form>
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
</div>

<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/signup/signup-v2.js"></script>