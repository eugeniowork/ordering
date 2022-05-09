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
	            <table class="table table-bordered table-striped user-table">
	                <thead>
	                    <tr>
	                        <th class="th-name">Name</th>
	                        <th class="th-phone-no">Phone No.</th>
	                        <th class="th-email">Email</th>
	                        <th class="th-verified">Verified?</th>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/user/customer.js"></script>
<?php endif ?>