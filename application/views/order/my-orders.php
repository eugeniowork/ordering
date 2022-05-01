<div class="page-container orders-container">
	<div class="container-body" style="top: 0px;">
		<div class="active-orders-container">
			<span class="title">Acitve Orders</span><br>
			<!-- <div class="row">
				<div class="col-12 col-lg-3">
					<span style="font-weight: 600; color: #333" class="status">FOR PROCESS</span><br>
					<small style="font-style: italic">May 03, 2022</small>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
				</div>
				<div class="col-12 col-lg-2">
					<br>
					<strong><span>&#8369;</span>159</strong>
				</div>
			</div> -->
		</div><hr>
		<div class="past-orders-container">
			<span class="title">Past Orders</span><br>
			<!-- <div class="row">
				<div class="col-12 col-lg-3">
					<span style="font-weight: 600; color: #333" class="status">CANCELLED</span><br>
					<small style="font-style: italic">May 03, 2022</small>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
					<div class="order-product-container">
						<span>1x</span>&nbsp;
						<span>Pizza</span>
					</div>
				</div>
				<div class="col-12 col-lg-2">
					<br>
					<strong><span>&#8369;</span>159</strong>
				</div>
			</div> -->

		</div>
		<div class="process-loading-container"></div>
	</div>
</div>

<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea rows="3" class="form-control cancel-order-remarks" placeholder="Please enter reason of cancelling"></textarea>
                </div>
                <div class="warning text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-confirm-cancel-order">Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/order/my-orders.js"></script>