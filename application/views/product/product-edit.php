<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container product-edit-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container product-view-container">
		<div class="container-header">
    		<span class="header-title">Product Edit</span>
    		<div class="buttons">
	            <a href="<?= base_url();?>product" class="btn btn-sm btn-primary">Back</a>
	            <button class="btn btn-sm btn-primary btn-update">Update</button>
	        </div>
    	</div>
		<div class="container-body">
			<form id="form">
				<div class="row">
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Name&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="name" class="form-control" placeholder="Enter name" value="<?= $product_details['name'] ?>">
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Price w/out vat&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="price_without_vat" class="form-control float-only" placeholder="Enter price" value="<?= $product_details['price_without_vat'] ?>">
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Price with vat&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="price" class="form-control float-only" placeholder="Enter price" value="<?= $product_details['price'] ?>">
						</div>
					</div>
					<!-- <div class="col-12 col-lg-4">
						<div class="form-group">
							<span>Stock&nbsp;<span class="text-danger">*</span></span>
							<input type="text" name="stock" class="form-control float-only" placeholder="Enter stock" value="<?= $product_details['stock'] ?>">
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
							<a href="<?= base_url().$product_details['image_path'];?>" target="_blank">View Photo</a><br>
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

	<script type="text/javascript">
		var category_id = '<?= $product_details['category_id'] ?>'
		var encrypted_id = '<?= encryptData($product_details['id']) ?>'
	</script>

	<script type="text/javascript" src="<?= base_url();?>assets/js/product/product-edit.js"></script>
<?php endif ?>