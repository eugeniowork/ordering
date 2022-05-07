<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container cash-in-view-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container cash-in-view-container">
    	<div class="container-header">
    		<span class="header-title">Cash In</span><br>
            <div class="buttons">
                <a href="<?= base_url();?>cash-in" class="btn btn-sm btn-primary">Back</a>
                <?php if ($cash_in['status'] == "PENDING"): ?>
					<?php if (strtotime($cash_in['date_expiration']) > time()): ?>
						<button class="btn btn-primary btn-sm btn-confirm-cash-in d-none">Confirm Cash In</button>
					<?php endif ?>
				<?php endif ?>
                
            </div>
    	</div>
    	<div class="container-body">
    		<?php if ($cash_in['status'] == "PENDING"): ?>
    			<?php if (strtotime($cash_in['date_expiration']) > time()): ?>
	    			<div class="row">
		    			<div class="col-12 col-lg-4">
		                    <strong>Customer Name</strong><br>
		                    <span><?= $cash_in['fullname'] ?></span>
		                </div>
		                <div class="col-12 col-lg-4">
		                    <strong>Reference No.</strong><br>
		                    <span><?= $cash_in['reference_no'] ?></span>
		                </div>
		                <div class="col-12 col-lg-4">
		                    <strong>Date Created</strong><br>
		                    <span><?= date("M d, Y h:i a", strtotime($cash_in['created_date'])); ?></span>
		                </div>
		            </div><hr>
		            <div class="authentication-method-container">
	            		<p>Select Authentication Method</p>
						<button class="btn btn-facial-recognition">
							<span>Facial Recognition</span>
							<img src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg">
						</button><br>
						<button class="btn btn-code">
							<span>Code</span>
							<img src="<?= base_url();?>assets/uploads/images/code_icon.png">
						</button>
	            	</div>
    			<?php else: ?>
    				<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Cash in request expired.</span>
	    		<?php endif ?>
    		<?php elseif($cash_in['status'] == "CANCELED"): ?>
    			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Cash in canceled.</span>
    		<?php elseif($cash_in['status'] == "DONE"): ?>
    			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Cash in successful.</span>
    		<?php endif ?>
		</div>
	
		<?php if ($cash_in['status'] == "PENDING"): ?>
			<?php if (strtotime($cash_in['date_expiration']) > time()): ?>
				<div class="modal fade" id="verification_code_modal" tabindex="-1" role="dialog" aria-hidden="true">
		            <div class="modal-dialog modal-dialog-centered" role="document">
		                <div class="modal-content">
		                    <div class="modal-header">
		                        <h5 class="modal-title">Verification Code</h5>
		                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                        <span aria-hidden="true">&times;</span>
		                        </button>
		                    </div>
		                    <div class="modal-body">
		                    	<?php
		                    		$email = "";
		                    		$mail_part1 = explode("@", $user_details['email']);
	        						$mail_part2 = substr($mail_part1[0],4); // Sub string after fourth character.
	        						$email = substr($mail_part1[0],0,4); // Add first four character part.
							        $email .= str_repeat("*", strlen($mail_part2))."@"; // Replace *. And add @
							        $email .= $mail_part1[1]; // Add last part.
		                    	?>
		                    	<span>A 6 digit verification code was sent to customer's email address.</span><br><br>
		                    	<div class="form-group">
		                    		<input type="text" class="form-control code" placeholder="Enter code">
		                    	</div>
		                    	<div class="warning text-danger"></div>
		                    </div>
		                    <div class="modal-footer">
		                        <button class="btn btn-primary btn-sm btn-verify-code">Submit</button>
		                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="modal fade" id="face_modal" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="editAttendanceModalLongTitle">Face Recognition</h5>
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

		        <div class="modal fade" id="confirm_cash_in_modal" tabindex="-1" role="dialog" aria-hidden="true">
		            <div class="modal-dialog modal-dialog-centered" role="document">
		                <div class="modal-content">
		                    <div class="modal-header">
		                        <h5 class="modal-title">Confirm Cash In</h5>
		                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                        <span aria-hidden="true">&times;</span>
		                        </button>
		                    </div>
		                    <div class="modal-body">
		                    	<div class="form-group">
		                    		<span>Amount</span>
		                    		<input type="text" class="form-control" value="<?= $cash_in['request_amount'] ?>" readonly>
		                    	</div>
		                    	<div class="form-group">
		                    		<span>Cash Amount</span>
		                    		<input type="text" class="form-control float-only cash-amount" placeholder="Enter cash amount">
		                    	</div>
		                    	<div class="form-group">
		                    		<span>Change</span>
		                    		<input type="text" class="form-control cash-change" readonly>
		                    	</div>
		                    	<div class="cash-amount-warning"></div>
		                    </div>
		                    <div class="modal-footer">
		                    	<button class="btn btn-primary btn-sm btn-save-cash-in" disabled>Submit</button>
		                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
		                    </div>
		                </div>
		            </div>
		        </div>

				<script type="text/javascript">
					var request_amount = '<?= $cash_in['request_amount'] ?>';
					var cash_in_id = '<?= encryptData($cash_in['id']) ?>';
		    		var reference_no = '<?= $cash_in['reference_no'] ?>';
					var customer_email = '<?= $user_details['email'] ?>';
					var face1_value = new Float32Array(Object.values(JSON.parse('<?= $user_details['face1_value'] ?>')));
		    		var face2_value = new Float32Array(Object.values(JSON.parse('<?= $user_details['face2_value'] ?>')));
				</script>

				<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
				<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>
		    	<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/cash-in-view.js"></script>
			<?php endif ?>
		<?php endif ?>
	</div>
<?php endif ?>