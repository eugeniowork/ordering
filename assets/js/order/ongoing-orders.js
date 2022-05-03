$(document).ready(function(){
	var ongoingOrdersTable;

	get_ongoing_orders();
	function get_ongoing_orders(){
		createProcessLoading('.process-loading-container', 'Getting orders...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "order/ongoingOrdersList",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
				}
				else{
					$(".ongoing-orders-content").removeClass('d-none')
					ongoingOrdersTable = $('.ongoing-orders-table').DataTable({
						"data": response.orders,
						"columns": [
							{
				            	"data":"fullname",
				            },
				            {
				            	"data":"order_number",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.total_amount), "PHP")
				                    return html;
				                }
				            },
				            {
				            	"data":"date_pickup",
				            },
				            {
				            	"data":"status",
				            },
				            {
				            	"data":"created_date",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<a href="'+base_url+'ongoing-orders-view/'+full.encrypted_id+'" class="btn btn-sm btn-outline-success btn-view" title="View"><i class="fas fa-eye"></i></a>'
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
				createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
			}
		})
	}
})