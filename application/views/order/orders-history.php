<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container orders-history-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container orders-history-container">
		<div class="container-header">
			<span class="header-title">Orders History</span><br>
		</div>
		<div class="container-body">
			<div class="form-group">
				<div class="row">
					<div class="col-12 col-lg-3">
						<span>Date Ordered From</span>
						<input type="date" class="form-control date-from" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
					</div>
					<div class="col-12 col-lg-3">
						<span>Date Ordered To</span>
						<input type="date" class="form-control date-to" value="<?= date('Y-m-d') ?>">
					</div>
				</div>
				<button class="btn btn-primary btn-filter">Filter</button>
			</div>
			<hr>
			<div class="table-responsive-sm orders-history-content" style="overflow-y: auto; display: none;">
	            <table class="table table-bordered table-striped orders-history-table">
	                <thead>
	                    <tr>
	                        <th class="th-customer">Customer Name</th>
	                        <th class="th-order-number">Order Number</th>
	                        <th class="th-total-amount">Amount</th>
	                        <th class="th-status">Status</th>
	                        <th class="th-date-pickup">Scheduled Date Pickup</th>
	                        <th class="th-date-pickup">Actual Date Pickup</th>
	                        <th class="th-date-ordered">Date Ordered</th>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/order/orders-history.js"></script>
<?php endif ?>