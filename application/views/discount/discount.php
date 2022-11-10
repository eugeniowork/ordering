<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container discount-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container discount-container">
		<div class="container-header">
			<span class="header-title">Discount</span>
			<div class="buttons">
	            <a href="<?= base_url();?>discount/discount-add" class="btn btn-sm btn-primary">Add New</a>
	        </div>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm discount-content d-none">
	            <table class="table table-bordered table-striped discount-table">
	                <thead>
	                    <tr>
	                    	<th>Name</th>
	                        <th>Code</th>
	                        <th>Percentage</th>
	                        <th>Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
		</div>
	</div>

	<div class="modal fade" id="confirm_remove_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<span>Are you sure you want to remove <strong class="discount-name"></strong>?</span>
                    <div class="warning text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm btn-confirm-remove-discount">Yes</button>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal success-modal modal-theme" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-body" style="text-align: center;">
	            	<p style="font-size: 80px;"><i class="text-success fas fa-check-circle"></i></p>
	            	<p style="font-weight: 600;" class="success-msg"></p>
	            	<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Okay</button>
	            </div>
	        </div>
	    </div>
	</div>

	<script type="text/javascript" src="<?= base_url();?>assets/js/discount/discount.js"></script>
<?php endif ?>