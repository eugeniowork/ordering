<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container product-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container order-payment-container">
		<div class="container-header">
    		<span class="header-title">Product Add</span>
    		<div class="buttons">
	            <button class="btn btn-sm btn-primary btn-save">Save</button>
	        </div>
    	</div>
		<div class="container-body">
			<form id="form">
				<div class="row">
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Name&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="name" class="form-control" placeholder="Enter name">
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Code</span>
							<input type="text" name="code" class="form-control" placeholder="Enter code">
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Price w/out vat&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="price_without_vat" class="form-control float-only" placeholder="Enter price">
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Price with vat&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="price" class="form-control float-only" placeholder="Enter price">
						</div>
					</div>
					<!-- <div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Stock&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="stock" class="form-control float-only" placeholder="Enter stock">
						</div>
					</div> -->
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Category&nbsp;<span class="text-danger">*</span></span>
							<select class="form-control test" name="category">
							</select>
						</div>
					</div>
					<div class="col-12 col-lg-12">
						<div class="form-group">
							<span>Image</span><br>
							<input type="file" name="file" accept="image/png, image/gif, image/jpeg">
						</div>
					</div>
				</div>
			</form>
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
	</div>
	<script type="text/javascript" src="<?= base_url();?>assets/js/product/product-add.js"></script>
<?php endif ?>