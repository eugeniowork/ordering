<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container employee-view-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container employee-view-container">
		<div class="container-header">
			<span class="header-title">Employee Details</span><br>
			<div class="buttons">
	            <a href="<?= base_url();?>employee" class="btn btn-sm btn-primary">Back</a>
	        </div>
		</div>
		<div class="container-body">
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
						<span>Phone No.</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['phone_number'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Email Address</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['email'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Role</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['user_type'] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>