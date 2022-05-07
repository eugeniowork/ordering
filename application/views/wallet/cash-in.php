<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container cash-in-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container cash-in-container">
		<div class="container-header">
			<span class="header-title">List - Cash In</span><br>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm cash-in-content d-none">
	            <table class="table table-bordered table-striped cash-in-table">
	                <thead>
	                    <tr>
	                        <th class="th-customer">Customer Name</th>
	                        <th class="th-amount">Amount</th>
	                        <th class="th-created-date">Created Date</th>
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
	<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/cash-in.js"></script>
<?php endif ?>