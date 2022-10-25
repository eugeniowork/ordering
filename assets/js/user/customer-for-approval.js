$(document).ready(function(){
	var userTableForApproval;
	var selected_user_id = null;

	get_customer_for_approval();
	function get_customer_for_approval(){
		createProcessLoading('.process-loading-container-for-approval', 'Getting customers', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "user/getUsers",
			type: 'POST',
			dataType: 'json',
			data:{
				user_type: 'user',
				approval_status: 'FOR APPROVAL'
			},
			success: function(response){
				$('.process-loading-container-for-approval').empty();
				if(response.is_error){
					createProcessError('.process-loading-container-for-approval', 'Unable to load customers.', "30px", "15px");
				}
				else{
					$(".user-for-approval-content").removeClass("d-none")
					userTableForApproval = $('.user-for-approval-table').DataTable({
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
				                    html += '<div class="btn-group"><a href='+base_url+"customer-view/"+full.encrypted_id+' class="btn btn-outline-success btn-sm"><i class="fa-solid fa-eye"></i></a>'
				                    html += '&nbsp;<button class="btn btn-outline-primary btn-sm btn-approve" data-name="APPROVED" title="Approve"><i class="fas fa-check"></i></button>';
				                    html += '&nbsp;<button class="btn btn-outline-danger btn-sm btn-disapprove" data-name="DISAPPROVED" title="Disapprove"><i class="fas fa-close"></i></button></div>';
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
				createProcessError('.process-loading-container-for-approval', 'Unable to load customers.', "30px", "15px");
			}
		})
	}

	var approval_status = "";
	var selected_user_id_for_approval = null;

	$(document).on("click", ".btn-approve", function(){
		var data = userTableForApproval.row($(this).parents('tr')).data();
		selected_user_id_for_approval = data.id;

		approval_status = $(this).data("name");
		$(".customer-approval-modal").modal("show");
	});

	$(document).on("click", ".btn-disapprove", function(){
		var data = userTableForApproval.row($(this).parents('tr')).data();
		selected_user_id_for_approval = data.id;

		approval_status = $(this).data("name");
		$(".customer-approval-modal").modal("show");
	});

	var loading_submit_approval = false;
	$(".btn-submit-approval").on("click", function(){
		if(!loading_submit_approval){
			loading_submit_approval = true;

			$.ajax({
				url: base_url + "user/customerApproval",
				type: 'post',
				dataType: 'json',
				data:{
					user_id: selected_user_id_for_approval,
					approval_status: approval_status,
					approval_remarks: $(".approval-remarks").val()
				},
				beforeSend: function(){
					$(".btn-submit-approval").prop("disabled", true).html("Please wait....")
					$(".global-loading").css({
		                "display": "flex"
		            })
		            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')
				},
				success: function(response){
					$(".btn-submit-approval").prop("disabled", false).html("Submit")
					$(".global-loading").css({
                        "display": "none"
                    })
                    $(".customer-approval-modal").modal("hide");
					if(response.success){
						$(".success-modal").modal("show")
						$(".success-msg").html(response.msg);
					}
					else{
						loading_submit_approval = false;
	            		$("#message_modal").modal("show")
						$("#message_modal .modal-body").html("<span class='text-danger'>"+response.msg+"</span>")
					}
				},
				error: function(error){
					loading_submit_approval = false;
					$(".customer-approval-modal").modal("hide");
            		$("#message_modal").modal("show")
					$("#message_modal .modal-body").html("<span class='text-danger'>Something went wrong, please try again.</span>")
					$(".global-loading").css({
                        "display": "none"
                    })
				}
			})
		}
	});

	$(".success-modal").on("hidden.bs.modal", function(){
		window.location.reload();
	});
})