$(document).ready(function(){
	$(".btn-filter").on("click", function(){
		get_audit_trail();
	}).click();

	function get_audit_trail(){
		createProcessLoading('.process-loading-container', 'Loading...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		$(".audit-trail-content").addClass("d-none")

		$.ajax({
			url: base_url + "audit/getAuditTrail",
			type: 'POST',
			dataType: 'json',
			data:{
				date_from: $(".date-from").val(),
				date_to: $(".date-to").val()
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load audit trail list', "30px", "15px");
				}
				else{
					$(".audit-trail-content").removeClass("d-none")
					$('.audit-trail-table').DataTable({
						"data": response.audit_trail_list,
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
				            	"data":"name",
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
				createProcessError('.process-loading-container', 'Unable to load audit trail list.', "30px", "15px");
			}
		})
	}
});