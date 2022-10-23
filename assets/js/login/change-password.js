$(document).ready(function(){
	var loading_change_password = false
	$(".btn-submit").on("click", function(){
		if(!loading_change_password){
			loading_change_password = true;

			$.ajax({
				url: base_url + "login/changePasswordSave",
				type: 'POST',
				dataType: 'json',
				data: {
					email: email,
					password: $(".password").val(),
					confirm_password: $(".confirm-password").val()
				},
				beforeSend: function(){
					$(".btn-submit").prop("disabled", true).html("Please wait...")
					$(".warning").html("");
				},
				success: function(response){
					if(response.success){
						$(".success-modal").modal("show")
						$(".success-msg").html("Change password successful.");
					}
					else{
						$(".btn-submit").prop("disabled", false).html("Submit")
						renderResponse('.warning',response.msg, "danger")
						loading_change_password = false;
					}
				},
				error: function(error){
					$(".btn-submit").prop("disabled", false).html("Submit")
					renderResponse('.warning',"Something went wrong, please try again.", "danger")
					loading_change_password = false;
				}
			})
		}
	});

	$(".success-modal").on("hidden.bs.modal", function(){
		window.location.href = base_url+"login";
	});
})