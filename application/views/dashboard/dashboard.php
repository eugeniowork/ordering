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