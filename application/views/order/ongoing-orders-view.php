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
                <a href="<?= base_url();?>ongoing-orders" class="btn btn-sm btn-primary">Back</a>
                <?php if ($order['status'] == "FOR PICKUP"): ?>
                    <a href="<?= base_url();?>order-payment/<?= encryptData($order['id']) ?>" class="btn btn-sm btn-primary">Proceed to Payment</a>
                <?php endif ?>
            </div>
    	</div>
    	<div class="container-body">
            <div class="row">
                <div class="col-12 col-lg-2">
                    <strong>Status:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span>
                        <?= $order['status'] ?>&nbsp;
                        <?php if ($order['status'] == "FOR PROCESS"): ?>
                            <button class="btn btn-sm btn-link btn-edit-status">Edit</button>
                        <?php endif ?>
                    </span>
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
                    <strong>Amount:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><span>&#8369;</span><?= number_format($order['total_amount'], 2) ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Total Items:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= $order['total_quantity'] ?></span>
                </div>
                <div class="col-12 col-lg-2">
                    <strong>Date Pickup:</strong>
                </div>
                <div class="col-12 col-lg-10">
                    <span><?= date("M d, Y", strtotime($order['date_pickup'])); ?></span>
                </div>
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
        var order_id = '<?= encryptData($order['id']); ?>'
        var user_type = '<?= $this->session->userdata('user_type'); ?>'
    </script>

    <script type="text/javascript" src="<?= base_url();?>assets/js/order/ongoing-orders-view.js"></script>

<?php endif ?>