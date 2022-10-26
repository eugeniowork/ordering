$(document).ready(function(){
	$(".btn-filter").on("click", function(){
		get_user_activity_log();
	}).click();

	function get_user_activity_log(){
		createProcessLoading('.process-loading-container', 'Loading...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		$(".user-activity-log-content").addClass("d-none")

		$.ajax({
			url: base_url + "user/getUserActivityLog",
			type: 'POST',
			dataType: 'json',
			data:{
				date_from: $(".date-from").val(),
				date_to: $(".date-to").val()
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load log list', "30px", "15px");
				}
				else{
					$(".user-activity-log-content").removeClass("d-none")
					$('.user-activity-log-table').DataTable({
						"data": response.activity_log_list,
						"columns": [
							{
				            	"data":"id",
				            },
				            {
				            	"data":"created_date",
				            	"render": function(data, type, full, meta) {
				                    return full.created_date_text;
				                }
				            },
				            {
				            	"data":"description",
				            },
						],
						"ordering": true,
					    "aaSorting": [],
					    "bDestroy": true
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load log list.', "30px", "15px");
			}
		})
	}
});