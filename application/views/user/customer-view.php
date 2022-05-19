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
	            <a href="<?= base_url();?>customer" class="btn btn-sm btn-primary">Back</a>
	        </div>
		</div>
		<div class="container-body">
			<div class="row">
				<div class="col-12 col-lg-12">
					<?php if ($user_details['is_verified']): ?>
						<span class="verified">Verified</span>
					<?php else: ?>
						<span class="unverified">Unverified</span>
					<?php endif ?>
					
				</div>
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
						<span>Email Address</span>
						<input type="text" class="form-control" readonly value="<?= $user_details['email'] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>