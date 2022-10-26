<?php if ($this->session->userdata('user_type') == "user"): ?>
    <div class="page-container audit-trail-container">
        <div class="container-body" style="top: 0px;">  
            <span><span class="fa fa-exclamation-circle text-warning"></span>&nbsp;You are not allowed to access this page.</span>
        </div>
    </div>
<?php else: ?>
	<div class="page-container audit-trail-container">
		<div class="container-header">
			<span class="header-title">Audit Trail</span>
		</div>
		<div class="container-body">
			<div class="form-group">
				<div class="row">
					<div class="col-12 col-lg-3">
						<span>Date From</span>
						<input type="date" class="form-control date-from" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
					</div>
					<div class="col-12 col-lg-3">
						<span>Date To</span>
						<input type="date" class="form-control date-to" value="<?= date('Y-m-d') ?>">
					</div>
				</div>
				<button class="btn btn-primary btn-filter">Filter</button>
			</div>
			<hr>
			<div class="table-responsive-sm audit-trail-content d-none">
	            <table class="table table-bordered table-striped audit-trail-table">
	                <thead>
	                    <tr>
	                    	<th>Audit ID</th>
	                        <th>Date and Time</th>
	                        <th>Name</th>
	                        <th>Description</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
	        </div>
			<div class="process-loading-container"></div>
		</div>
	</div>

	<script type="text/javascript" src="<?= base_url();?>assets/js/audit/audit-trail.js"></script>
<?php endif ?>