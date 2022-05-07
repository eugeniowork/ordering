<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container product-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container order-payment-container">
		<div class="container-header">
    		<span class="header-title">Product</span>
    		<div class="buttons">
	            <a href="<?= base_url();?>product-add" class="btn btn-sm btn-primary">Add New</a>
	        </div>
    	</div>
		<div class="container-body">
			<div class="table-responsive-sm product-content d-none">
	            <table class="table table-bordered table-striped product-table">
	                <thead>
	                    <tr>
	                        <th class="th-name">Name</th>
	                        <th class="th-code">Code</th>
	                        <th class="th-price">Price</th>
	                        <th class="th-stock">Stock</th>
	                        <th class="th-category">Category</th>
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
	<script type="text/javascript" src="<?= base_url();?>assets/js/product/product.js"></script>
<?php endif ?>