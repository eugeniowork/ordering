<div class="page-container my-wallet-container">
	<div class="container-header">
		<span class="header-title">My Wallet</span><br>
	</div>
	<div class="container-body">
		<span style="font-size: 20px;">Balance</span><br>
		<strong><span>&#8369;</span><?= number_format($user_details['facepay_wallet_balance'], 2) ?></strong>
        <button class="btn btn-link btn-sm btn-cash-in">Cash In</button>

		<br><br>
		<span style="font-size: 20px;">Recent Transactions</span><br>
		<div class="transaction-container">
		</div>
		<div class="process-loading-container" style="width: 50px;"></div>
	</div>
</div>

<div class="modal fade" id="transaction_details_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<span>Reference No.</span><br>
            		<span>#reference_no</span>
            	</div>
            	<div class="form-group">
            		<span>Transaction Date</span><br>
            		<span>#transaction_date</span>
            	</div>
            	<div class="form-group">
            		<span>Description</span><br>
            		<span>#description</span>
            	</div>
            	<div class="form-group">
            		<span>Amount</span><br>
            		<span>#amount</span>
            	</div>
            	<div class="form-group">
            		<span>Ending Balance</span><br>
            		<span>#ending_balance</span>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cash_in_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="cash-in-details-container"></div>
                <div class="cash-in-process-loading-container" style="width: 50px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_cash_in_cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Cash In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Are you sure you want to cancel cash in?</span>
                <div class="warning text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-confirm-cancel-cash-in">Yes</button>
                <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/my-wallet.js"></script>