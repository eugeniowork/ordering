<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container customer-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container customer-container">
		<div class="container-header">
			<span class="header-title">List - Customer</span><br>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm user-content d-none">
                <span class="title">APPROVED CUSTOMERS</span><br><br>
	            <table class="table table-bordered table-striped user-table">
	                <thead>
	                    <tr>
	                        <th class="th-name">Name</th>
	                        <th class="th-email">Email</th>
	                        <th class="th-verified">Verified?</th>
	                        <th class="th-status">Status</th>
	                        <th class="th-action">Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
            <hr>
            <div class="table-responsive-sm user-for-approval-content">
                <span class="title">FOR APPROVAL CUSTOMERS</span><br><br>
                <table class="table table-bordered table-striped user-for-approval-table">
                    <thead>
                        <tr>
                            <th class="th-name">Name</th>
                            <th class="th-email">Email</th>
                            <th class="th-verified">Verified?</th>
                            <th class="th-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="process-loading-container-for-approval"></div>
		</div>
	</div>

	<div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                		<span>Status&nbsp;<span class="text-danger">*</span></span>
                		<select class="form-control status">
                			<option disabled selected>Please select status</option>
                			<option value="1">Active</option>
                			<option value="0">Inactive</option>
                		</select>
                	</div>
                	<div class="cash-amount-warning"></div>
                </div>
                <div class="modal-footer">
                	<button class="btn btn-primary btn-sm btn-save-change-status">Submit</button>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
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
                    <p style="font-size: 80px;"><i class="text-success fas fa-check-circle"></i></p>
                    <p style="font-weight: 600;" class="success-msg"></p>
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript" src="<?= base_url();?>assets/js/user/customer.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/user/customer-for-approval.js"></script>
<?php endif ?>