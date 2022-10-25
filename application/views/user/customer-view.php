<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container customer-view-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container customer-view-container">
		<div class="container-header">
			<span class="header-title">Customer Details</span><br>
			<div class="buttons">
				<?php if($user_details['approval_status'] == "FOR APPROVAL"): ?>
	            	<button class="btn btn-sm btn-success btn-approve" data-name="APPROVED">Approve</button>
	            	<button class="btn btn-sm btn-danger btn-disapprove" data-name="DISAPPROVED">Disapprove</button>
	        	<?php endif; ?>
	            <a href="<?= base_url();?>customer" class="btn btn-sm btn-primary">Back</a>
	        </div>
		</div>
		<div class="container-body">
			<div class="row">
				<div class="col-12 col-lg-2">
					<?php if ($user_details['approval_status'] == "FOR APPROVAL"): ?>
						<span class="for-approval"><?= $user_details['approval_status']; ?></span>
					<?php elseif($user_details['approval_status'] == "APPROVED"): ?>
						<span class="approved"><?= $user_details['approval_status']; ?></span>
					<?php elseif($user_details['approval_status'] == "DISAPPROVED"): ?>
						<span class="disapproved"><?= $user_details['approval_status']; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Lastname</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['lastname'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Firstname</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['firstname'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Middlename</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['middlename'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Email Address 
							<?php if ($user_details['is_verified']): ?>
								<span class="verified-label">VERIFIED</span>
							<?php else: ?>
								<span class="unverified-label">UNVERIFIED</span>
							<?php endif ?>
						</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['email'] ?>">
					</div>
				</div>
			</div>
			<hr>
			<span style="font-size: 15px;font-weight: 600;color: #333;text-decoration: underline;">HISTORY</span>
			<table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date and Time</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approval_history as $key => $history): ?>
                        <tr>
                            <td><?= date('F d, Y h:i A', strtotime($history->created_date)) ?></td>
                            <td><?= $history->firstname." ".$history->lastname ?></td>
                            <td><?= $history->description; ?></td>
                            <td>
                            	<?php if ($history->approval_status == "FOR APPROVAL"): ?>
									<span class="for-approval"><?= $history->approval_status; ?></span>
								<?php elseif($history->approval_status == "APPROVED"): ?>
									<span class="approved"><?= $history->approval_status; ?></span>
								<?php elseif($history->approval_status == "DISAPPROVED"): ?>
									<span class="disapproved"><?= $history->approval_status; ?></span>
								<?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
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

	<div class="modal fade customer-approval-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <span>Remarks</span>
                        <input type="text" class="approval-remarks form-control" placeholder="Add remarks">
                    </div>
                    <div class="warning text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm btn-submit-approval">Submit</button>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal success-modal modal-theme" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;">
                    <p style="font-size: 80px;" class="success-icon-container"><i class="text-success fas fa-check-circle"></i></p>
                    <p style="font-weight: 600;" class="success-msg"></p>
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    	var user_id = '<?= $user_details['id'] ?>';
    </script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/user/customer-view.js"></script>
<?php endif ?>