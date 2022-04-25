<div class="page-container signup-container">
	<div class="container-header">
		<span class="header-title">SIGN UP</span><br>
		<div class="buttons">
            <button class="btn btn-sm btn-primary btn-save-registration">Save</button>
        </div>
	</div>

	<div class="container-body">
		<form id="form" enctype="multipart/form-data">
			<div>
				<small style="font-style: italic;" class="text-danger"><i class="fa fa-info-circle"></i>&nbsp;During face registration, make sure that your face is visible. Don't hide you face behind a mask, sunglasses or a hat.</small><br>
				<small style="font-style: italic;" class="text-danger"><i class="fa fa-info-circle"></i>&nbsp;If you have big changes to your appearance, such as heavy makeup or facial hair changes, keep in mind that face recognition may not recognize you.</small>
			</div><br>
			<br>
	        <div class="row">
	            <div class="col-lg-8">
	                <div class="warning"></div>
	            </div>
	        </div>
			<div class="info-container">
	            <div class="row">
	                <div class="col-12 col-lg-3">
	                    <span>Lastname <span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="lastname" placeholder="Enter lastname" required/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Firstname <span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="firstname" placeholder="Enter firstname" required/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Middlename</span>
	                    <input type="text" class="form-control text-only" name="middlename" placeholder="Enter middlename" />
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Phone number <span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="phone_number" placeholder="Enter phone number" required/>
	                </div>
	                <div class="col-12 col-lg-3">
		                <span>Email Address<span class="text-danger">*</span></span>
		                <input type="text" class="form-control" name="email" placeholder="Enter email" required/>
		            </div>
		            <div class="col-12 col-lg-3">
		                <span>Password<span class="text-danger">*</span></span>
		                <input type="password" class="form-control" name="password" placeholder="Enter password" required/>
		            </div>
		            <div class="col-12 col-lg-3">
		                <span>Confirm Password<span class="text-danger">*</span></span>
		                <input type="password" class="form-control" name="confirm_password" placeholder="Enter password" required/>
		            </div>
	            </div>
	            <div class="row">
		            <div class="col-12 col-lg-3">
		            	<span>Face 1<span class="text-danger">*</span></span><br>
		            	<img id="img_face" src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg"><br>
		                <button type="button" class="btn btn-sm btn-primary btn-open-camera" style="width: 200px">Register Face</button>
		            </div>
		            <div class="col-12 col-lg-3">
		            	<span>Face 2</span><br>
		            	<img id="img_face2" src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg"><br>
		                <button type="button" class="btn btn-sm btn-primary btn-open-camera" style="width: 200px">Register Face</button>
		            </div>
	            </div>
	        </div>
        </form>
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
<script type="text/javascript" src="<?= base_url();?>assets/js/signup/signup.js"></script>