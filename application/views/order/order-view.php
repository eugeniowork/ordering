<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container order-view-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
    <div class="page-container order-view-container">
        <div class="container-header">
            <span class="header-title">Order #<?= $order['order_number'] ?></span><br>
            <div class="buttons">
                <?php if ($order['status'] == "PICKED UP"): ?>
                    <a href="<?= base_url()."order-receipt-pdf/".encryptData($order['id']);?>" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>
                <?php elseif ($order['status'] == "FOR PICKUP"): ?>
                    <a href="<?= base_url();?>order-payment/<?= encryptData($order['id']) ?>" class="btn btn-sm btn-primary">Proceed to Payment</a>
                <?php elseif ($order['status'] == "FOR PROCESS"): ?>
                    <button class="btn btn-sm btn-primary btn-edit-status">Update Status</button>
                <?php endif ?>
                <a href="#" onclick="history.back()" class="btn btn-sm btn-primary">Back</a>
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

    <?php if ($order['status'] == "FOR PROCESS"): ?>
        <div class="modal fade" id="change_order_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Order Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <span>Status&nbsp;<span class="text-danger">*</span></span>
                            <select class="form-control status">
                                <option disabled selected>Select status</option>
                                <option value="FOR PICKUP">FOR PICKUP</option>
                                <option value="CANCELED">CANCEL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span>Remarks</span>
                            <textarea rows="3" class="form-control remarks" placeholder="Enter remarks"></textarea>
                        </div>
                        <div class="warning text-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm btn-confirm-change-order-status">Submit</button>
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <script>
        var order_id = '<?= encryptData($order['id']); ?>';
        var user_type = '<?= $this->session->userdata('user_type'); ?>';
    </script>

    <script type="text/javascript" src="<?= base_url();?>assets/js/order/order-view.js"></script>
<?php endif ?>