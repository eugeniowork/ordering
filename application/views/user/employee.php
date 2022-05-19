<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container employee-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container employee-container">
		<div class="container-header">
			<span class="header-title">List - Employee</span><br>
			<div class="buttons">
	            <a href="<?= base_url();?>employee-add" class="btn btn-sm btn-primary">Add New</a>
	        </div>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm employee-content d-none">
	            <table class="table table-bordered table-striped employee-table">
	                <thead>
	                    <tr>
	                        <th class="th-name">Name</th>
	                        <th class="th-email">Email</th>
	                        <th class="th-role">Role</th>
	                        <th class="th-status">Status</th>
	                        <th class="th-action">Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/user/employee.js"></script>
<?php endif ?>