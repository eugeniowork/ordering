<div class="page-container my-orders-view-container">
    <div class="container-header">
        <span class="header-title">Order #<?= $order['order_number'] ?></span><br>
        <div class="buttons">
            <?php if ($order['status'] == "PICKED UP"): ?>
                <a href="<?= base_url()."order-receipt-pdf/".encryptData($order['id']);?>" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>
            <?php endif ?>

            <?php if ($order['status'] == "FOR PROCESS"): ?>
                <button class="btn btn-sm btn-resched-pickup btn-primary">Resched pickup</button>
                <button class="btn btn-sm btn-cancel-order btn-primary">Cancel Order</button>
            <?php endif ?>
            <a href="<?= base_url();?>my-orders" class="btn btn-sm btn-primary">Back</a>
        </div>
    </div>
    <div class="container-body">
        <span class="title">Order Details</span>
        <div class="order-details">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <strong>Status:</strong><br>
                    <span><?= $order['status'] ?></span>
                </div>
                <div class="col-12 col-lg-4">
                    <strong>Date Ordered:</strong><br>
                    <span><?= date("M d, Y h:i A", strtotime($order['created_date'])); ?></span>
                </div>
                <div class="col-12 col-lg-4">
                    <strong>Scheduled Date Pickup:</strong><br>
                    <span><?= date("M d, Y h:i A", strtotime($order['date_pickup'])); ?></span>
                </div>
                <?php if($order['status'] == 'PICKED UP'): ?>
                    <div class="col-12 col-lg-4">
                        <strong>Actual Date Pickup:</strong><br>
                        <span><?= date("M d, Y h:i A", strtotime($order['actual_date_pickup'])); ?></span>
                    </div>
                    <div class="col-12 col-lg-4">
                        <strong>Payment method:</strong><br>
                        <span><?= $order['mode_of_payment'] ?></span>
                    </div>
                <?php endif; ?>
                <div class="col-12 col-lg-4">
                    <strong>Special Instruction:</strong><br>
                    <span><?= nl2br($order['instruction']); ?></span>
                </div>
            </div>
        </div>
        <hr>

        <span class="title">Order Items</span>
        <div class="order-items">
            <?php foreach ($order_items as $key => $item): ?>
                <div class="items-content">
                    <div class="qty-container">x<?= $item->quantity ?></div>
                    <div class="name-container"><?= $item->name; ?></div>
                    <div class="price-container"><span>&#8369;</span><?= number_format($item->price * $item->quantity, 2); ?></div>
                </div>
            <?php endforeach ?>
            <div class="items-content">
                <div class="qty-container"></div>
                <div class="name-container"><strong>Sub Total</strong></div>
                <div class="price-container"><strong>&#8369;<?= number_format($order['total_amount'], 2); ?></strong></div>
            </div>
            <?php if($order['status'] == 'PICKED UP' && $order_discounts): ?>
                <?php foreach ($order_discounts as $key => $discount): ?>
                    <div class="items-content">
                        <div class="qty-container"></div>
                        <div class="name-container"><strong><?= $discount->name; ?></strong></div>
                        <div class="price-container"><strong><span>- &#8369;</span><?= number_format($discount->amount, 2); ?></strong></div>
                    </div>
                <?php endforeach ?>
                <div class="items-content">
                    <div class="qty-container"></div>
                    <div class="name-container"><strong>Grand Total</strong></div>
                    <div class="price-container"><strong>&#8369;<?= number_format($order['grand_total'], 2); ?></strong></div>
                </div>
            <?php endif; ?>
        </div><hr>

        <span style="color: #7d7d7d;font-weight: 600;font-size: 20px;">Order Status Updates</span>
        <div class="order-tracking-widget-container"></div>
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
                    <textarea rows="3" class="form-control remarks" placeholder="Enter remarks"></textarea>
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

<div class="modal fade" id="resched_pickup_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resched Pickup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <span>Date: </span>
                    <input type="datetime-local" class="form-control resched-date-pickup">
                </div>
                <div class="warning text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-confirm-resched">Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    var order_id = '<?= encryptData($order['id']); ?>';
    var date_pickup = '<?= $order['date_pickup'] ?>';
</script>

<script type="text/javascript" src="<?= base_url();?>assets/js/order/my-orders-view.js"></script>