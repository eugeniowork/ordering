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
						<img class="product-image" src="<?= base_url().$product_details['image_path']?>">
					</div>
				</div>
			</div><hr>
			<div class="history-container">
				<span style="font-size: 25px;">History</span><br>
				<div class="table-responsive-sm history-content d-none">
		            <table class="table table-bordered table-striped history-table">
		                <thead>
		                    <tr>
		                    	<th class="th-description">Description</th>
		                    	<th class="th-stock">Stock</th>
		                        <th class="th-new-stock">New Stock</th>
		                        <th class="th-date">Date</th>
		                    </tr>
		                </thead>
		                <tbody>
		                </tbody>
		            </table>
		        </div>
				<div class="process-loading-container" style="width: 50px;"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var product_id = '<?= $product_details['id'] ?>';
	</script>

	<script type="text/javascript" src="<?= base_url();?>assets/js/product/product-view.js"></script>
<?php endif ?>