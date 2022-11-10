<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container discount-view-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container discount-view-container">
		<div class="container-header">
    		<span class="header-title">Discount Details</span>
    		<div class="buttons">
	            <a href="<?= base_url();?>discount" class="btn btn-sm btn-primary">Back</a>
	        </div>
    	</div>
		<div class="container-body">
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Name</span>
						<input type="text" class="form-control" readonly value="<?= $discount_details['name'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Code</span>
						<input type="text" class="form-control" readonly value="<?= $discount_details['code'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Percentage</span>
						<input type="text" class="form-control" readonly value="Php <?= $discount_details['percentage'] ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>