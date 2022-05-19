$(document).ready(function(){
	get_employees();
	function get_employees(){
		createProcessLoading('.process-loading-container', 'Getting employees', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "user/getUsers",
			type: 'POST',
			dataType: 'json',
			data:{
				user_type: 'admin,staff'
			},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load employees.', "30px", "15px");
				}
				else{
					$(".employee-content").removeClass("d-none")
					userTable = $('.employee-table').DataTable({
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
				            	"data":"email",
				            },
				            {
				            	"data":"user_type",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    if(full.is_active == "1"){
				                    	html = '<center><span class="status-active">Active</span></center>';
				                    }
				                    else{
				                    	html = '<center><span class="status-inactive">Inactive</span></center>';
				                    }
				                    
				                    return html;
				                }
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<a href='+base_url+"employee-view/"+full.encrypted_id+' class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye"></i></a>'
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
				createProcessError('.process-loading-container', 'Unable to load employees.', "30px", "15px");
			}
		})
	}
})