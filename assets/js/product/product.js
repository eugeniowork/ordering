$(document).ready(function(){
	var productTable;

	get_product_list();
	function get_product_list(){
		createProcessLoading('.process-loading-container', 'Getting products...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$(".product-table tbody").empty();

		$.ajax({
			url: base_url + "product/productList",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load products.', "30px", "15px");
				}
				else{
					$(".product-content").removeClass("d-none")
					productTable = $('.product-table').DataTable({
						"data": response.products,
						"columns": [
							{
				            	"data":"name",
				            },
				            {
				            	"data":"code",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.price))
				                    return html;
				                }
				            },
				            {
				            	"data":"stock",
				            },
				            {
				            	"data":"category_name",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html += '<a href="'+base_url+'product-view/'+full.encrypted_id+'" class="btn btn-sm btn-outline-primary btn-view" title="View"><i class="fas fa-eye"></i></a>'
				                    html += '&nbsp;<button class="btn btn-sm btn-outline-danger btn-delete" title="Delete"><i class="fas fa-trash"></i></button>'
				                    html += '&nbsp;<a href="'+base_url+'product-edit/'+full.encrypted_id+'" class="btn btn-sm btn-outline-success" title="Edit"><i class="fas fa-pencil"></i></a>'
				                    return html;
				                }
				            },
						],
						"ordering": true,
					    "aaSorting": [],
					    "order": [[ 0, 'asc' ]],
					    "bDestroy": true
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load products.', "30px", "15px");
			}
		})
	}
})