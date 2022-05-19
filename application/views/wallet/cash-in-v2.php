<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container cash-in-v2-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container cash-in-v2-container">
			<div class="container-header">
			<span class="header-title">Cash In</span><br>
			<div class="buttons">
                <button class="btn btn-primary btn-sm btn-scan-face">Scan/Rescan Face</button>
                <button class="btn btn-primary btn-sm btn-confirm-cash-in d-none">Confirm Cash In</button>
            </div>
		</div>
		<div class="container-body">
			<div class="row">
    			<div class="col-12 col-lg-2">
                    <strong>Customer Name</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span class="cutomer-name-val">N/A</span>
                </div>
            </div>
            <div class="row">
    			<div class="col-12 col-lg-2">
                    <strong>Customer Email</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span class="cutomer-email-val">N/A</span>
                </div>
            </div><hr>

            <div class="cash-in-details-container d-none">
            	<div class="row">
	    			<div class="col-12 col-lg-3">
	    				<span>Request Amount</span>
			            <input type="text" class="form-control float-only request-amount" placeholder="Enter request amount">
	                </div>
	            </div>
	            <div class="row">
	    			<div class="col-12 col-lg-3">
	    				<span>Cash Amount</span>
		                <input type="text" class="form-control float-only cash-amount" placeholder="Enter cash amount">
		                <div class="cash-amount-warning"></div>
	                </div>
	            </div>
	            <div class="row">
	    			<div class="col-12 col-lg-3">
	    				<span>Change</span>
		                <input type="text" class="form-control cash-change" readonly>
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
                    	<span>Are you sure you want to confirm cash-in?</span>
                        <div class="warning text-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm btn-save-cash-in">Yes</button>
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<script type="text/javascript">
		var users = JSON.parse('<?php echo json_encode($users) ?>');
	</script>
	<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/cash-in-v2.js"></script>
<?php endif ?>