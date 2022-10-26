<div class="page-container user-activity-log-container">
	<div class="container-header">
		<span class="header-title">Activity Log</span>
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
		<div class="table-responsive-sm user-activity-log-content d-none">
            <table class="table table-bordered table-striped user-activity-log-table">
                <thead>
                    <tr>
                    	<th>ID</th>
                        <th>Date and Time</th>
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

<script type="text/javascript" src="<?= base_url();?>assets/js/user/user-activity-log.js"></script>