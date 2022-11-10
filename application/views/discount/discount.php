<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container discount-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container discount-container">
		<div class="container-header">
			<span class="header-title">Discount</span>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm discount-content d-none">
	            <table class="table table-bordered table-striped discount-table">
	                <thead>
	                    <tr>
	                    	<th>Name</th>
	                        <th>Code</th>
	                        <th>Percentage</th>
	                        <th>Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url();?>assets/js/discount/discount.js"></script>
<?php endif ?>