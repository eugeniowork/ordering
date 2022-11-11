<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container discount-add-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container discount-add-container">
		<div class="container-header">
			<span class="header-title">Discount Add</span>
    		<div class="buttons">
	            <button class="btn btn-sm btn-primary btn-save">Save</button>
	            <a href="<?= base_url();?>discount" class="btn btn-sm btn-primary">Back</a>
	        </div>
		</div>
		<div class="container-body">
			<form id="form">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<span>Name&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="name" class="form-control" placeholder="Enter name">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<span>Code&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="code" class="form-control" placeholder="Enter code">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<span>Type&nbsp;<span class="text-danger">*</span></span>
							<select class="form-control" name="type">
		                    	<option value="">Please select</option>
		                    	<option value="Percentage">Percentage</option>
		                    	<option value="Amount">Amount</option>
		                    </select>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<span>Value&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="value" class="form-control float-only" placeholder="Enter value">
							<span class="value-warning"></span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">Okay</button>
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="<?= base_url();?>assets/js/discount/discount-add.js"></script>
<?php endif ?>