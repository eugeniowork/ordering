<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container wishlist-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container wishlist-container">
		<div class="container-header">
			<span class="header-title">Customer's Wishlist</span>
		</div>
		<div class="container-body">
			<div class="table-responsive-sm wishlist-content" style="display: none;">
	            <table class="table table-bordered table-striped wishlist-table">
	                <thead>
	                    <tr>
	                    	<th>Customer Name</th>
	                        <th>Product Name</th>
	                        <th>Product Stock</th>
	                        <th>Product Price</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url();?>assets/js/product/wishlist.js"></script>
<?php endif ?>