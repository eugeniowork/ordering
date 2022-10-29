$(document).ready(function(){
	get_history();
	function get_history(){
		createProcessLoading('.process-loading-container', '', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "product/productHistory",
			type: 'POST',
			dataType: 'json',
			data:{
				product_id: product_id
			},
			success: function(response){
				$('.process-loading-container').empty();

				$(".history-content").removeClass("d-none")

				$('.history-table').DataTable({
						"data": response.products,
						"columns": [
							{
				            	"data":"description",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    if(full.action_type == "add"){
				                    	html = "+ "+full.stock;
				                    }
				                    else{
				                    	html = "- "+full.stock;
				                    }
				                    return html;
				                }
				            },
				            {
				            	"data":"new_stock",
				            },
				            {
				            	"data":"created_date",
				            }
						],
						"ordering": true,
					    "aaSorting": [],
					    "bDestroy": true
					})
			},
			error: function(){
				createProcessError('.process-loading-container', 'Failed.', "30px", "15px");
			}
		})
	}
})