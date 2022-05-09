<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container employee-add-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container employee-container">
		<div class="container-header">
			<span class="header-title">Employee Add</span><br>
			<div class="buttons">
				<button class="btn btn-sm btn-primary btn-save">Save</button>
	            <a href="<?= base_url();?>employee" class="btn btn-sm btn-primary">Back</a>
	        </div>
		</div>
		<div class="container-body">
			<form id="form">
				<div class="row">
	                <div class="col-12 col-lg-3">
	                    <span>Lastname&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="lastname" placeholder="Enter lastname" required/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Firstname&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="firstname" placeholder="Enter firstname" required/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Middlename&nbsp;</span>
	                    <input type="text" class="form-control text-only" name="middlename" placeholder="Enter middlename" />
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Phone number&nbsp;<span class="text-danger">*</span></span>
	                    <input type="text" class="form-control text-only" name="phone_number" placeholder="Enter phone number" required/>
	                </div>
	                <div class="col-12 col-lg-3">
	                    <span>Role&nbsp;<span class="text-danger">*</span></span>
	                    <select class="form-control" name="user_type">
	                    	<option disabled selected>Please select</option>
	                    	<option value="admin">Admin</option>
	                    	<option value="staff">Staff</option>
	                    </select>
	                </div>
	                <div class="col-12 col-lg-3">
		                <span>Email Address&nbsp;<span class="text-danger">*</span></span>
		                <input type="text" class="form-control" name="email" placeholder="Enter email" required/>
		            </div>
		            <div class="col-12 col-lg-3">
		                <span>Password&nbsp;<span class="text-danger">*</span></span>
		                <input type="password" class="form-control" name="password" placeholder="Enter password" required/>
		            </div>
		            <div class="col-12 col-lg-3">
		                <span>Confirm Password&nbsp;<span class="text-danger">*</span></span>
		                <input type="password" class="form-control" name="confirm_password" placeholder="Enter password" required/>
		            </div>
	            </div>
            </form>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/user/employee-add.js"></script>
<?php endif ?>