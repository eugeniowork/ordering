<div class="page-container my-points-container">
	<div class="container-header">
		<span class="header-title">My Points</span><br>
	</div>
	<div class="container-body">
		<span style="font-size: 20px;">Points</span><br>
		<strong><?= number_format($user_details['points_balance'], 2) ?></strong>

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


<script type="text/javascript" src="<?= base_url();?>assets/js/points/my-points.js"></script>