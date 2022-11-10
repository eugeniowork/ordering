$(document).ready(function(){
	var discountsTable;

	get_discount();
	function get_discount(){
		createProcessLoading('.process-loading-container', 'Getting discounts', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "discount/get-discounts",
			type: 'GET',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load discounts.', "30px", "15px");
				}
				else{
					$(".discount-content").removeClass("d-none")
					discountsTable = $('.discount-table').DataTable({
						"data": response.discounts,
						"columns": [
			                {
				            	"data":"name"
				            },
				            {
				            	"data":"code"
				            },
				            {
				            	"data":"percentage",
				            },
				            {
				            	"data":"",
				            	"className":"action-buttons",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html += '<a href="'+base_url+'discount/discount-view/'+full.encrypted_id+'" class="btn btn-sm btn-success btn-view" title="View"><i class="fas fa-eye"></i></a>'
				                    html += '&nbsp;<a href="'+base_url+'discount/discount-edit/'+full.encrypted_id+'" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-pencil"></i></a>'
				                    html += '&nbsp;<button class="btn btn-sm btn-success btn-remove" title="Remove"><i class="fas fa-trash"></i></button>'
				                    return html;
				                }
				            },
						],
						"ordering": true,
					    "aaSorting": [],
					    "bDestroy": true
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load discounts.', "30px", "15px");
			}
		})
	}
});