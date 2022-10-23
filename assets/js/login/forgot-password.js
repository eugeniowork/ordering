$(document).ready(function(){
	$(".btn-submit-email").on("click", function(){
		$.ajax({
			url: base_url + "login/sendPasswordCode",
			type: 'POST',
			dataType: 'json',
			data: {
				email: $(".email").val()
			},
			beforeSend: function(){
				$(".btn-submit-email").prop("disabled", true).html("Please wait...")
				$(".forgot-password-form .warning").html("");
			},
			success: function(response){
				$(".btn-submit-email").prop("disabled", false).html("Submit")
				if(response.success){
					$(".success-modal").modal("show")
					$(".success-msg").html("We've sent password reset instructions to your email.");
				}
				else{
					renderResponse('.forgot-password-form .warning',response.msg, "danger")
				}
			},
			error: function(error){
				$(".btn-submit-email").prop("disabled", false).html("Submit")
				renderResponse('.forgot-password-form .warning',"Something went wrong, please try again.", "danger")
			}
		})
	});

	$(".success-modal").on("hidden.bs.modal", function(){
		window.location.href = base_url+"login";
	});
});