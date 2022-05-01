<div class="page-container dashboard-container">
	<div class="container-header">
		<span class="header-title">Order Something</span><br>
		<div class="inputs">
            <div class="form-group">
            	<button class="btn" data-toggle="modal" data-target="#filter_modal" style="border: 1px solid #ced4da;color: #495057;"><i class="fa fa-filter" style="color: orange;"></i>&nbsp;Filter</button>
            	<input type="text" class="form-control input-search-name" placeholder="Search product" style="display: inline-block; width: 400px;">
            	<i class="fa fa-search" style="color: orange;"></i>
            </div>
        </div>
	</div>
	<div class="container-body">
		<div class="products-container">
			<div class="row products-container-row">
				<div class="col-12 col-lg-3">
					<div class="item-container">
						<!-- <button class="btn btn-sm btn-success btn-add-to-cart" data-id="'+data.encrypted_id+'" style="position: absolute;z-index: 2;right: 35px;"><i class="fa fa-plus-circle"></i></button> -->
						<!-- <div class="row">
							<div class="col-12 col-lg-5 image-container">
								<img src="https://m.media-amazon.com/images/I/71Yp6aZx1QL.jpg" style="width: 110px;height: 110px;border-radius: 10px;">
							</div>
							<div class="col-12 col-lg-3">
								<span>&#8369;</span>125
							</div>
							<div class="col-12 col-lg-4">
								<span>Stock: 125</span>
							</div>
						</div><br> -->
						<!-- <div class="row product-name-container">
							<div class="col-12 col-lg-12">
								<strong>Product65</strong>
							</div>
						</div>
						<div class="row product-category-container">
							<div class="col-12 col-lg-12">
								<small>Food</small>
							</div>
						</div>
						<div class="row additional-product-details-container">
							<div class="col-12 col-lg-6">
								<span>&#8369;</span>125
							</div>
							<div class="col-12 col-lg-6">
								Stock: 125
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
		<div class="process-loading-container"></div>
	</div>
</div>

<div class="modal fade" id="filter_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Filter</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<span>Category</span>
					<select class="form-control select2 category" multiple>
						
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary btn-submit-filter">Filter</button>
				<button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="warning_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Warning</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">Okay</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/dashboard/dashboard.js"></script>