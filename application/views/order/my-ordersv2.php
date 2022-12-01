<div class="page-container my-orders-container">
	<div class="btn-status-container">
	    <div class="btn-status-content">
	    	<button class="btn-load-orders btn-active" data-status="ALL">ALL</button>
		    <button class="btn-load-orders" data-status="FOR PROCESS">FOR PROCESS</button>
		    <button class="btn-load-orders" data-status="FOR PICKUP">FOR PICKUP</button>
		    <button class="btn-load-orders" data-status="PICKED UP">PICKED UP</button>
		    <button class="btn-load-orders" data-status="CANCELED">CANCELED</button>
	    </div>
	</div><br>
	<div class="container-body" style="padding-top: 10px;">
		<div class="active-orders-container">
		</div>
		<div class="process-loading-container"></div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/order/my-ordersv2.js"></script>