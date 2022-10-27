$(document).ready(function(){
	var ordersHistoryTable;

	get_orders_history();
	function get_orders_history(){
		createProcessLoading('.process-loading-container', 'Getting orders...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "order/ordersHistoryList",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
				}
				else{
					$(".orders-history-content").removeClass('d-none')
					ordersHistoryTable = $('.orders-history-table').DataTable({
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
				            	"data":"status",
				            },
				            {
				            	"data":"date_pickup",
				            },
				            {
				            	"data":"actual_date_pickup",
				            },
				            {
				            	"data":"created_date",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<a href="'+base_url+'orders-history-view/'+full.encrypted_id+'" class="btn btn-sm btn-outline-success btn-view" title="View"><i class="fas fa-eye"></i></a>'
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