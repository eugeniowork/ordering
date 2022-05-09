<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container wallet-transaction-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container wallet-transaction-container">
		<div class="container-header">
			<span class="header-title">List - Wallet Transaction</span><br>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm transaction-content d-none">
	            <table class="table table-bordered table-striped transaction-table">
	                <thead>
	                    <tr>
	                        <th class="th-customer">Customer Name</th>
	                        <th class="th-reference-number">Reference Number</th>
	                        <th class="th-description">Description</th>
	                        <th class="th-debit">Debit</th>
	                        <th class="th-credit">Credit</th>
	                        <th class="th-ending-balance">Ending Balance</th>
	                        <th class="th-transaction-date">Transaction Date</th>
	                        <th class="th-action">Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
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
	            		<span>Customer Name.</span><br>
	            		<span>#customer_name</span>
	            	</div>
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

	<script type="text/javascript" src="<?= base_url();?>assets/js/wallet/wallet-transaction.js"></script>
<?php endif ?>