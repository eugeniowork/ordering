<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container cash-in-successful-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container cash-in-successful-container">
        <div class="container-body" style="top: 0px;">
        	<div class="d-flex flex-column justify-content-center align-items-center cash-in-successful-flex">
        		<div class="cash-in-successful-body">
					<div class="d-flex p-2 justify-content-center">
			            <img src="<?= base_url();?>assets/uploads/images/check_icon.jpg" alt="logo">
			        </div>
			        <div class="form-group d-flex p-2 justify-content-center">
			        	<span class="main-title">Cash In Successful!</span>
			        </div>
			        <div class="form-group d-flex p-0 justify-content-center">
			        	<span>Reference no. <?= $cash_in_details['reference_no'] ?></span>
			        </div>
			        <div class="form-group d-flex p-0 justify-content-center">
			        	<span>Amount <span>&#8369;</span><?= number_format($cash_in_details['request_amount'], 2) ?></span>
			        </div>
			        <div class="form-group d-flex p-0 justify-content-center">
			        	<span><?= date('M d, Y h:i a', strtotime($cash_in_details['created_date'])) ?></span>
			        </div>
			        <div class="btn-group d-flex p-2 justify-content-center">
			        	<a href="<?= base_url();?>cash-in-v2" class="btn btn-primary">Done</a>&nbsp;
			        	<a href="<?= base_url()."cash-in-receipt-pdf/".encryptData($cash_in_details['id']);?>" target="_blank" class="btn btn-primary">Print Receipt</a>
			        </div>
				</div>
			</div> 
		</div>
    </div>
<?php endif ?>