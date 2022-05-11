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
				            	"className":"action-buttons",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html += '<a href="'+base_url+'product-view/'+full.encrypted_id+'" class="btn btn-sm btn-success btn-view" title="View"><i class="fas fa-eye"></i></a>'
				                    //html += '&nbsp;<button class="btn btn-sm btn-outline-danger btn-delete" title="Delete"><i class="fas fa-trash"></i></button>'
				                    html += '&nbsp;<a href="'+base_url+'product-edit/'+full.encrypted_id+'" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-pencil"></i></a>'
				                    html += '&nbsp;<button class="btn btn-sm btn-success btn-add-stock" title="Add Stock"><i class="fas fa-dolly-flatbed"></i></button>'
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

	var product_id;
	$(document).on("click", ".btn-add-stock", function(){
		$("#add_stock_modal").modal("show")
		var data = productTable.row( $(this).parents('tr') ).data();
		console.log(data)

		product_id = data.id;
		$(".product-name").val(data.name)
	})

	var loading_submit_stock = false;
	$(".btn-submit-stock").on("click", function(){

		if(!loading_submit_stock){
			loading_submit_stock = true;

			$(".btn-submit-stock").prop("disabled", true)
			$(".add-stock-warning").empty();

			$(".global-loading").css({
		        "display": "flex"
		    })
		    createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

		    $.ajax({
		    	url: base_url + "product/addStock",
		    	type: 'POST',
		    	dataType: 'json',
		    	data:{
		    		product_id: product_id,
		    		stock: $(".stock").val()
		    	},
		    	success: function(response){
		    		if(response.is_error){
		    			$(".global-loading").css({"display": "none"})
		        		$(".btn-submit-stock").prop("disabled", false)
		    			loading_submit_stock = false;
		            	renderResponse('.add-stock-warning',response.error_msg, "danger")
		    		}
		    		else{
		    			window.location.reload();
		    		}
		    	},
		    	error: function(error){
		    		$(".global-loading").css({"display": "none"})
	        		$(".btn-submit-stock").prop("disabled", false)
        			loading_submit_stock = false;
                	renderResponse('.add-stock-warning',"Unable to add stock, please try again.", "danger")
		    	}
		    })
		}
	})
})