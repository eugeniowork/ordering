$(document).ready(function(){
	var loading_login = false;
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
						var msg = "<div class='spinner-border text-primary' role='status' style='color:#155724 !important;height:15px;width:15px;'></div>"+"&nbsp;Login successful, you'll be redirected to the page."
	     				renderResponseNotClosable('.warning',msg, "success")
	     				setTimeout(function(){
	     					window.location.href = "dashboard";
	     				},1000)
					}
				},
				error: function(error){
					$(".btn-login").prop("disabled", false).html("LOGIN")
					loading_login = false;
				}
			})
		}
	})
})