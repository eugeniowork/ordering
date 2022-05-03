<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container ongoing-orders-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container ongoing-orders-container">
		<div class="container-header">
			<span class="header-title">Ongoing Orders</span><br>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm ongoing-orders-content d-none">
	            <table class="table table-bordered table-striped ongoing-orders-table">
	                <thead>
	                    <tr>
	                        <th class="th-customer">Customer Name</th>
	                        <th class="th-order-number">Order Number</th>
	                        <th class="th-total-amount">Amount</th>
	                        <th class="th-date-pickup">Date Pickup</th>
	                        <th class="th-status">Status</th>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/order/ongoing-orders.js"></script>
<?php endif ?>