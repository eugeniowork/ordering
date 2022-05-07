$(document).ready(function(){
	var cashInTable;
	get_cash_in_request();
	function get_cash_in_request(){
		createProcessLoading('.process-loading-container', 'Getting list...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "wallet/getCashInRequest",
			type: 'POST',
			dataType: 'json',
			data: {
				status: 'PENDING'
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load cash in request.', "30px", "15px");
				}
				else{
					$(".cash-in-content").removeClass('d-none')
					cashInTable = $('.cash-in-table').DataTable({
						"data": response.results,
						"columns": [
							{
				            	"data":"fullname",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.request_amount))
				                    return html;
				                }
				            },
				            {
				            	"data":"created_date",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<a href="'+base_url+'cash-in-view/'+full.encrypted_id+'" class="btn btn-sm btn-outline-success btn-view" title="View"><i class="fas fa-eye"></i></a>'
				                    return html;
				                }
				            },
						],
						"ordering": true,
						columnDefs: [{
							orderable: false,
							targets: "no-sort"
					    }],
					    "aaSorting": [],
					    "bDestroy": true
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load cash in request.', "30px", "15px");
			}
		})
	}
})