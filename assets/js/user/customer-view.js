$(document).ready(function(){
	var approval_status = "";
	var selected_user_id_for_approval = null;

	$(document).on("click", ".btn-approve", function(){
		approval_status = $(this).data("name");
		$(".customer-approval-modal").modal("show");
	});

	$(document).on("click", ".btn-disapprove", function(){
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
					user_id: user_id,
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
});