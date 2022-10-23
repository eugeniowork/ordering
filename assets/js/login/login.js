$(document).ready(function(){
	var loading_login = false;
	var email = "";
	$(".login-form").on("submit", function(e){
		e.preventDefault();

		if(!loading_login){
			loading_login = true;
		
			$(".btn-login").prop("disabled", true).html("LOGGING IN...")
			$(".warning").html("");

			$.ajax({
				url: base_url + "login/validateLogin",
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize(),
				success: function(response){
					$(".btn-login").prop("disabled", false).html("LOGIN")

					if(response.is_error){
						renderResponse('.warning',response.error_msg, "danger")
						loading_login = false;
						if(response.is_redirect_to_verification){
							setTimeout(function(){
								window.location.href = 'verify-account/'+response.encrypted_user_id
							}, 1000)
						}
					}
					else{
						email = response.email;
						loading_login = false;
						$(".btn-login").prop("disabled", false).html("LOGIN")
						$(".login-form").hide();
						$(".otp-form").show();
						// var msg = "<div class='spinner-border text-primary' role='status' style='color:#155724 !important;height:15px;width:15px;'></div>"+"&nbsp;Login successful, you'll be redirected to the page."
	     // 				renderResponseNotClosable('.warning',msg, "success")
	     // 				setTimeout(function(){
	     // 					window.location.href = "dashboard";
	     // 				},1000)
					}
				},
				error: function(error){
					$(".btn-login").prop("disabled", false).html("LOGIN")
					loading_login = false;
				}
			})
		}
	})

	var loading_submit_otp = false;
	$(".btn-submit-otp").on("click", function(){
		$(".warning").empty();

		if(!loading_submit_otp){
			loading_submit_otp = true;

			$(".btn-submit-otp").prop("disabled", true).html("Loading...")

			$.ajax({
				url: base_url + "login/verifyOtp",
				type: 'POST',
				dataType: 'json',
				data:{
					email: email,
					code: $(".code").val(),
				},
				success: function(response){
					if(response.is_error){
						$(".btn-submit-otp").prop("disabled", false).html("Submit")
						renderResponse('.warning',response.error_msg, "danger")
						loading_submit_otp = false;
					}
					else{
						setTimeout(function(){
	     					window.location.href = "dashboard";
	     				},1000)
					}
				},
				error: function(error){
					$(".btn-submit-otp").prop("disabled", false).html("Submit")
					loading_submit_otp = false;
				}
			})
		}
	});

	$(".btn-resend").on("click", function(){
		$(".btn-resend").prop("disabled", true).html("Resending...")

		$.ajax({
			url: base_url + 'login/resendOtp',
			type: 'POST',
			dataType: 'json',
			data:{
				email: email
			},
			success: function(response){
				$(".btn-resend").prop("disabled", true).html("Resend it now")
				setTimeout(function(){
                   $(".btn-resend").prop("disabled", false)
                },30000)
			},
			error: function(error){

			}
		})
	});

	$(".btn-forgot-password").on("click", function(){
		window.location.href = base_url + 'forgot-password';
	});
})