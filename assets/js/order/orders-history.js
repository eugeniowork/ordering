$(document).ready(function(){
	var ordersHistoryTable;

	$(".btn-filter").on("click", function(){
		get_orders_history();
	}).click();

	function get_orders_history(){
		createProcessLoading('.process-loading-container', 'Getting orders...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		$(".orders-history-content").hide();

		$.ajax({
			url: base_url + "order/ordersHistoryList",
			type: 'POST',
			dataType: 'json',
			data:{
				status: $(".status").val(),
				date_from: $(".date-from").val(),
				date_to: $(".date-to").val()
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
				}
				else{
					$(".orders-history-content").show()
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
				                    html = moneyConvertion(parseFloat(full.grand_total), "PHP")
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