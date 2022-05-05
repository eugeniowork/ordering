<div class="page-container my-wallet-container">
	<div class="container-header">
		<span class="header-title">My Wallet</span><br>
	</div>
	<div class="container-body">
		<span style="font-size: 20px;">Balance</span><br>
		<strong><span>&#8369;</span><?= number_format($user_details['facepay_wallet_balance'], 2) ?></strong>
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
            		<span>123654891</span>
            	</div>
            	<div class="form-group">
            		<span>Transaction Date</span><br>
            		<span>May 03, 2022 10:00 AM</span>
            	</div>
            	<div class="form-group">
            		<span>Description</span><br>
            		<span>Cash In</span>
            	</div>
            	<div class="form-group">
            		<span>Amount</span><br>
            		<span><span>&#8369;</span>900</span>
            	</div>
            	<div class="form-group">
            		<span>Ending Balance</span><br>
            		<span><span>&#8369;</span>800</span>
            	</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/my-wallet.js"></script>