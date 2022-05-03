<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container order-payment-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container order-payment-container">
		<div class="container-header">
    		<span class="header-title">Order #<?= $order['order_number'] ?><br>
            <div class="buttons">
                <a href="<?= base_url();?>ongoing-orders-view/<?= encryptData($order['id']) ?>" class="btn btn-sm btn-primary">Back</a>
                <?php if ($order['status'] == "FOR PICKUP"): ?>
                	<button class="btn btn-primary btn-sm btn-open-payment-confirmation d-none">Confirm Payment</button>
                <?php endif ?>
            </div>
    	</div>
		<div class="container-body">
			<?php if ($order['status'] == "FOR PICKUP"): ?>
				<div class="row">
					<div class="col-12 col-lg-6">
						<strong>Payment Method</strong>
						<div class="payment-method-container">
							<input type="radio" id="cash" value="cash">
							<label for="cash">Cash</label>
							&nbsp;&nbsp;&nbsp;
							<input type="radio" id="face_pay" value="face_pay">
							<label for="face_pay">FacePay</label>

							<div class="face-pay-container d-none">
								<strong>Select Authentication Method</strong><br>
								<button class="btn btn-facial-recognition">
									<span>Facial Recognition</span>
									<img src="<?= base_url();?>assets/uploads/images/face-recognition-default.jpg">
								</button><br>
								<button class="btn btn-code">
									<span>Code</span>
									<img src="<?= base_url();?>assets/uploads/images/code_icon.png">
								</button>
							</div>
							<div class="cash-container d-none">
								<div class="form-group">
									<span>Cash Amount&nbsp;<span class="text-danger">*</span></span>
									<input type="text" class="form-control cash-amount float-only" placeholder="Enter amount" style="width: 50%">
									<div class="cash-amount-warning"></div>
								</div>
								<div class="form-group">
									<span>Change</span>
									<span class="form-control cash-change" style="width: 50%" readonly></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<strong>Order Details</strong><br>
						<div class="order-details-container">
							<div class="quantity-container">Quantity</div>
							<div class="name-container">Name</div>
							<div class="price-container">Total Price</div>
						</div>
						<?php foreach ($order_items as $key => $item): ?>
							<div class="order-details-container">
								<div class="quantity-container"><?= $item->quantity ?></div>
								<div class="name-container"><?= $item->name; ?></div>
								<div class="price-container"><span>&#8369;</span><?= number_format($item->price * $item->quantity, 2); ?></div>
							</div>
						<?php endforeach ?>
						<div class="order-details-container">
							<div class="quantity-container"></div>
							<div class="name-container"><strong>Total Amount</strong></div>
							<div class="price-container"><strong><span>&#8369;</span><?= number_format($order['total_amount'],2) ?></strong></div>
						</div>
					</div>
				</div>
			<?php elseif($order['status'] == "FOR PROCESS"): ?>
				<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Order is not yet ready for pickup.</span>
			<?php elseif($order['status'] == "CANCELED"): ?>
				<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Order canceled.</span>
			<?php elseif($order['status'] == "PICKED UP"): ?>
				<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;Order picked up.</span>
			<?php endif ?>
		</div>
    </div>
    <?php if ($order['status'] == "FOR PICKUP"): ?>
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

    	<div class="modal fade" id="confirm_payment_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    	<span>Are you sure you want to confirm payment?</span>
                        <div class="warning text-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm btn-confirm-payment">Yes</button>
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                    </div>
                </div>
            </div>
        </div>

    	<script type="text/javascript">
    		var total_order_amount = '<?= $order['total_amount'] ?>'
    		var order_id = '<?= encryptData($order['id']) ?>'
    	</script>
    	<script type="text/javascript" src="<?= base_url();?>assets/js/order/order-payment.js"></script>
    <?php endif ?>
<?php endif ?>