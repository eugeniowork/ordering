<?php if ($this->session->userdata('user_type') == "user"): ?>
	<div class="page-container product-container">
		<div class="container-body" style="top: 0px;">	
			<span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
		</div>
	</div>
<?php else: ?>
	<div class="page-container product-container">
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

	<div class="modal fade" id="add_stock_modal" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title">Add Stock</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
	                	<span>Product Name</span>
	                	<input type="text" class="form-control product-name" readonly>
	                </div>
	                <div class="form-group">
	                	<span>Stock&nbsp;<span class='text-danger'>*</span></span>
	                	<input type="text" class="form-control float-only stock" placeholder="Enter stock">
	                </div>
	                <div class="add-stock-warning"></div>
	            </div>
	            <div class="modal-footer">
	            	<button class="btn btn-primary btn-sm btn-submit-stock">Submit</button>
                    <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
	        </div>
	    </div>
	</div>


	<script type="text/javascript" src="<?= base_url();?>assets/js/product/product.js"></script>
<?php endif ?>