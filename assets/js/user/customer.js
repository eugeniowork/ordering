$(document).ready(function(){
	var userTable;

	get_customer();
	function get_customer(){
		createProcessLoading('.process-loading-container', 'Getting customers', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "user/getUsers",
			type: 'POST',
			dataType: 'json',
			data:{
				user_type: 'user'
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load customers.', "30px", "15px");
				}
				else{
					$(".user-content").removeClass("d-none")
					userTable = $('.user-table').DataTable({
						"data": response.users,
						"columns": [
			                {
				            	"data":"",
			                	"render": function(data, type, full, meta) {
				                    var html = "";
				                    if(full.middlename){
				                    	html = full.firstname+" "+full.middlename[0]+". "+full.lastname
				                    }
				                    else{
				                    	html = full.firstname+" "+full.lastname
				                    }
				                    return html;
				                }
				            },
			                {
				            	"data":"phone_number",
				            },
				            {
				            	"data":"email",
				            },
				            {
				            	"data":"",
			                	"render": function(data, type, full, meta) {
				                    var html = full.is_verified == "1"? "Yes":"No";
				                    return html;
				                }
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<a href='+base_url+"customer-view/"+full.encrypted_id+' class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye"></i></a>'
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
				createProcessError('.process-loading-container', 'Unable to load customers.', "30px", "15px");
			}
		})
	}
})