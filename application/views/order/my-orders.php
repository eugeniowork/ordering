<div class="page-container my-orders-container">
	<div class="container-body" style="top: 0px;">
		<div class="active-orders-container">
			<span class="title">Acitve Orders</span><br>
		</div><hr>
		<div class="past-orders-container">
			<span class="title">Past Orders</span><br>
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

<div class="modal fade" id="details_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order #<span class="order-number-title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="order-details-loading-container" style="width: 100%;"></div>
                <div class="order-details-container"></div>
                <div class="order-history-container" style="display: none;">
                    <hr>
                    <strong>History:</strong>
                    <table class="table table-bordered table-striped order-history-table">
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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

<script type="text/javascript" src="<?= base_url();?>assets/js/order/my-orders.js"></script>