$(document).ready(function(){
	var email = $(".email").val();

	var loading_verify = false;
	$(".btn-verify").on("click", function(){
		$(".warning").empty();

		if(!loading_verify){
			loading_verify = true;

			$(".btn-verify").prop("disabled", true).html("Verifying...")

			$.ajax({
				url: base_url + "user/verifyAccount",
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

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-verify").click();
        }
    });
})