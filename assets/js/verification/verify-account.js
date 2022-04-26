$(document).ready(function(){
	var email = $(".email").val();

	var loading_verify = false;
	$(".btn-verify").on("click", function(){
		$(".warning").empty();

		if(!loading_verify){
			loading_verify = true;

			$(".btn-verify").prop("disabled", true).html("Verifying...")

			$.ajax({
				url: base_url + "verification/verifyAccount",
				type: 'POST',
				dataType: 'json',
				data:{
					email: email,
					code: $(".code").val(),
				},
				success: function(response){
					$(".btn-verify").prop("disabled", false).html("Verify")
					if(response.is_error){
						renderResponse('.warning',response.error_msg, "danger")
						loading_verify = false;
					}
					else{
						//window.location.href = base_url + 'login'
						$(".verify-account-div").empty();
						$(".verified-account-div").show()
					}
				},
				error: function(error){
					$(".btn-verify").prop("disabled", false).html("Verify")
					loading_verify = false;
				}
			})
		}
	})

	$(".btn-resend").on("click", function(){
		$(".btn-resend").prop("disabled", true).html("Resending...")

		$.ajax({
			url: base_url + 'verification/resendVerification',
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
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-verify").click();
        }
    });
})