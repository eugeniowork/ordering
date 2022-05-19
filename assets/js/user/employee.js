$(document).ready(function(){
	var employeeTable;
	var selected_user_id = null;
	
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
					employeeTable = $('.employee-table').DataTable({
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
				                    html += '<div class="btn-group"><a href='+base_url+"employee-view/"+full.encrypted_id+' class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye"></i></a>'
				                    html += '&nbsp;<button class="btn btn-outline-success btn-sm btn-change-status" title="Change Status"><i class="fa-solid fa-signal"></i></button></div>';
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



	$(document).on("click", ".btn-change-status", function(){
		$("#change_status_modal").modal("show")
		var data = employeeTable.row($(this).parents('tr')).data();

		selected_user_id = data.id;
		$(".status").val(data.is_active).trigger("change");
	})

	var loading_save_change_status = false;
	$(".btn-save-change-status").on("click", function(){
		if(!loading_save_change_status){
			loading_save_change_status = true;

			$(".btn-save-change-status").prop("disabled", true);

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            $.ajax({
            	url: base_url + "user/changeUserStatus",
            	type: 'POST',
            	dataType: 'json',
            	data:{
            		status: $(".status").val(),
            		user_id: selected_user_id
            	},
            	success: function(response){
            		if(response.is_error){
            			$(".btn-save-change-status").prop("disabled", false);
            			loading_save_change_status = false;
            			$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $(".modal").modal("hide")
	                    $("#message_modal").modal("show")
	                    $("#message_modal .modal-body").html('<div class="text-danger">'+response.error_msg+'</div>');
            		}
            		else{
            			window.location.reload()
            		}
            	},
            	error: function(error){
            		$(".btn-save-change-status").prop("disabled", false);
        			loading_save_change_status = false;
        			$(".global-loading").css({
                        "display": "none"
                    })
                    $(".modal").modal("hide")
                    $("#message_modal").modal("show")
                    $("#message_modal .modal-body").html('<div class="text-danger">Unable to change status, please try again.</div>');
            	}
            })
		}
	})
})