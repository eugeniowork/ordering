<div class="page-container signup-container">
	<div class="container-header">
		<span class="header-title">PROFILE</span><br>
		<div class="buttons">
            <button class="btn btn-sm btn-primary btn-update" disabled>Update</button>
        </div>
	</div>
	<div class="container-body">
		<form id="form" enctype="multipart/form-data">
			<div class="info-container">
	            <div class="row">
	                <div class="col-12 col-lg-3">
	                    <span>Lastname&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="lastname" placeholder="Enter lastname" required value="<?= $user_details['lastname'] ?>" />
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Firstname&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="firstname" placeholder="Enter firstname" required value="<?= $user_details['firstname'] ?>"/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Middlename&nbsp;</span>
	                    <input type="text" class="form-control text-only" name="middlename" placeholder="Enter middlename" value="<?= $user_details['middlename'] ?>"/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Phone number&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="phone_number" placeholder="Enter phone number" required value="<?= $user_details['phone_number'] ?>"/>
	                </div>
	                <div class="col-12 col-lg-3">
		                <span>Email Address&nbsp;<span class="text-danger">*</span></span>
		                <input type="text" class="form-control" name="email" placeholder="Enter email" required value="<?= $user_details['email'] ?>"/>
		            </div>
	            </div>
	        </div>
	        <div class="face-container">
	        	<div class="row">
	        		<div class="col-12 col-lg-12">
	        			<?php 
	        				$is_wear_glasses = false;
	        				if($user_faces['face2_value']){
	        					$is_wear_glasses = true;
	        				}
	        			?>
	        			<span>Do you wear glasses?</span><br>
	        			<input type="radio" name="with_glasses" id="yes" value="yes" <?= $is_wear_glasses? "checked":"" ?>>
	        			<label for="yes">Yes</label>
	        			<input type="radio" name="with_glasses" id="no" value="no" <?= $is_wear_glasses? "":"checked" ?>>
	        			<label for="no">No</label>
					</div>
		            <div class="col-12 col-lg-3">
		            	<span>Face 1&nbsp;<span class="text-danger">*</span></span><br>
		            	<img id="img_face" src="<?= base_url().$user_faces['face1_path'];?>"><br>
		                <button type="button" class="btn btn-sm btn-primary btn-open-camera" data-number="1" style="width: 200px">Update Face</button>
		            </div>
		            <div class="col-12 col-lg-3 face2-div <?= $is_wear_glasses? "":"d-none" ?>">
		            	<span>Face 2&nbsp;<span class="text-danger">*</span></span><br>
		            	<?php if($is_wear_glasses): ?>
		            		<img id="img_face2" src="<?= base_url().$user_faces['face2_path'];?>"><br>
	            		<?php else: ?>
	            			<img id="img_face2" src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg"><br>
	            		<?php endif; ?>
		            	
		                <button type="button" class="btn btn-sm btn-primary btn-open-camera" data-number="2" style="width: 200px">Update Face</button>
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
</div>

<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/user/my-profile.js"></script>