<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container ongoing-orders-view-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
    <div class="page-container ongoing-orders-view-container">
    	<div class="container-header">
    		<span class="header-title">Order #<?= $order['order_number'] ?></span><br>
            <div class="buttons">
                <?php if ($order['status'] == "PICKED UP"): ?>
                    <a href="<?= base_url()."order-receipt-pdf/".encryptData($order['id']);?>" target="_blank" class="btn btn-sm btn-primary">Print Receipt</a>
                <?php endif ?>
                <a href="<?= base_url();?>orders-history" class="btn btn-sm btn-primary">Back</a>
            </div>
    	</div>
    	<div class="container-body">
            <div class="row">
                <div class="col-12 col-lg-2">
                    <strong>Status:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= $order['status'] ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Customer Name:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= $order['fullname'] ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Order Number:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= $order['order_number'] ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Total Items:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= $order['total_quantity'] ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Sub Total:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><span>&#8369;</span><?= number_format($order['total_amount'], 2) ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Discount:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><span>&#8369;</span><?= number_format($order['discount_total'], 2) ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Grand Total:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><span>&#8369;</span><?= number_format($order['grand_total'], 2) ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Date Ordered:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= date("M d, Y h:i A", strtotime($order['created_date'])); ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Scheduled Date Pickup:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= date("M d, Y h:i A", strtotime($order['date_pickup'])); ?></span>
                </div>
                <?php if($order['status'] == 'PICKED UP'): ?>
                    <div class="col-12 col-lg-2">
                        <strong>Actual Date Pickup:</strong>
                    </div>
                    <div class="col-12 col-lg-10">
                        <span><?= date("M d, Y h:i A", strtotime($order['actual_date_pickup'])); ?></span>
                    </div>

                    <div class="col-12 col-lg-2">
                        <strong>Payment method:</strong>
                    </div>
                    <div class="col-12 col-lg-10">
                        <span><?= $order['mode_of_payment'] ?></span>
                    </div>
                <?php endif; ?>
                <div class="col-12 col-lg-12">
                    <strong>Items:</strong>
                </div>
            </div>
            <table class="table table-bordered table-striped ongoing-orders-table">
                <thead>
                    <tr>
                        <th class="th-name">Name</th>
                        <th class="th-category-name">Category Name</th>
                        <th class="th-quantity">Quantity</th>
                        <th class="th-price">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $key => $item): ?>
                        <tr>
                            <td><?= $item->name ?></td>
                            <td><?= $item->category_name ?></td>
                            <td><?= $item->quantity ?></td>
                            <td><?= $item->price ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <hr>
            <span style="color: #7d7d7d;font-weight: 600;font-size: 20px;">Order Status Updates</span>
            <div class="order-tracking-widget-container"></div>
    	</div>
    </div>

    <script>
        var order_id = '<?= encryptData($order['id']); ?>'
    </script>

    <script type="text/javascript" src="<?= base_url();?>assets/js/order/orders-history-view.js"></script>
<?php endif ?>