<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container order-payment-successful-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container order-payment-successful-container">
        <div class="container-body" style="top: 0px;">  
            <div class="d-flex flex-column justify-content-center align-items-center payment-successful-flex">
				<div class="payment-successful-body">
					<div class="d-flex p-2 justify-content-center">
			            <img src="<?= base_url();?>assets/uploads/images/check_icon.jpg" alt="logo">
			        </div>
			        <div class="form-group d-flex p-2 justify-content-center">
			        	<span class="main-title">Payment Successful!</span>
			        </div>
			        <div class="form-group d-flex p-0 justify-content-center">
			        	<span>Payment successful for Order Number <?= $order['order_number'] ?>.</span>
			        </div>
			        <div class="form-group d-flex p-0 justify-content-center">
			        	<span>Amount Paid <span>&#8369;</span><?= number_format($order['total_amount'], 2) ?></span>
			        </div>
			        <div class="btn-group d-flex p-2 justify-content-center">
			        	<a href="<?= base_url();?>ongoing-orders" class="btn btn-primary">Done</a>&nbsp;
			        	<button class="btn btn-primary">Print Receipt</button>
			        </div>
				</div>
			</div>
        </div>
    </div>
<?php endif ?>