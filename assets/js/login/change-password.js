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

	//PASSWORD CHECKER REQUIREMENT
	$(".password").on("keyup", function(){
		$(".password-requirement-container").show();

		var password = $(this).val();
		$.ajax({
			url: base_url + "signup/checkPassword",
			type: 'POST',
			dataType: 'json',
			data: {
				password: password
			},
			success: function(response){
				$(".one-lower").css({"color": (response.lower_case? "green": "#333")})
				$(".one-upper").css({"color": (response.upper_case? "green": "#333")})
				$(".one-number").css({"color": (response.number? "green": "#333")})
				$(".six-char-long").css({"color": (response.six_char_long? "green": "#333")})
				$(".one-special-char").css({"color": (response.special_chars? "green": "#333")})
			}
		})
	})
})