<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container product-view-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container product-view-container">
		<div class="container-header">
    		<span class="header-title">Product Details</span>
    		<div class="buttons">
	            <a href="<?= base_url();?>product" class="btn btn-sm btn-primary">Back</a>
	        </div>
    	</div>
		<div class="container-body">
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Name</span>
						<input type="text" class="form-control" readonly value="<?= $product_details['name'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Code</span>
						<input type="text" class="form-control" readonly value="<?= $product_details['code'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Price</span>
						<input type="text" class="form-control" readonly value="Php <?= $product_details['price'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Stock</span>
						<input type="text" class="form-control" readonly value="<?= $product_details['stock'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="form-group">
						<span>Category</span>
						<input type="text" class="form-control" readonly value="<?= $product_details['category_name'] ?>">
					</div>
				</div>
				<div class="col-12 col-lg-12">
					<div class="form-group">
						<span>Image</span><br>
						<img src="<?= base_url().$product_details['image_path']?>">
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>