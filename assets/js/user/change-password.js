$(document).ready(function(){
	//PASSWORD CHECKER REQUIREMENT
	$("input[name=new_password]").on("keyup", function(){
		$(".password-requirement-container").show();

		var password = $(this).val();
		$.ajax({
			url: base_url + "user/checkPassword",
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

	var loading_save = false;
	$(".btn-save").on("click", function(e){
		e.preventDefault();

		if(!loading_save){
			loading_save = true;
		
			var fd = new FormData($("#form")[0])
			
			$.ajax({
				url: base_url + "user/changePasswordSave",
				type: 'POST',
				dataType: 'json',
				data: fd,
				contentType: false,
			    cache: false,
			   	processData:false,
			   	beforeSend: function(){
					$(".btn-save").prop("disabled", true).html("Saving...")
				},
			    success: function(response){
			    	$(".btn-save").prop("disabled", false).html("Save")
			    	if(response.success){
			    		$(".success-modal").modal("show")
						$(".success-msg").html("Change password successful.");
			    	}
			    	else{
			    		$("#warning_modal").modal("show");
			    		renderResponseNotClosable('#warning_modal .modal-body',response.msg, "danger")
			    		loading_save = false;
			    	}
			    },
			    error: function(error){
			    	$(".btn-save").prop("disabled", false).html("Save")
			    	loading_save = false;
			    }
			})
		}
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-save").click();
        }
    });

    $(".success-modal").on("hidden.bs.modal", function(){
		window.location.reload();
	});
});