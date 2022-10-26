$(document).ready(function(){
    //PASSWORD CHECKER REQUIREMENT
    $("input[name=password]").on("keyup", function(){
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
	$(".btn-save").on("click", function(){
		if(!loading_save){
			loading_save = true;
			$(".btn-save").prop("disabled", true);

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            var formData = new FormData($("#form")[0])

            $.ajax({
            	url: base_url + "user/employeeSave",
            	type: 'POST',
            	dataType: 'json',
            	contentType: false,
			    cache: false,
			   	processData:false,
            	data: formData,
            	success: function(response){
            		if(response.is_error){
            			$(".btn-save").prop("disabled", false);
            			loading_save = false;
            			$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $("#message_modal").modal("show")
	                    $("#message_modal .modal-body").html('<div class="text-danger">'+response.error_msg+'</div>');
            		}
            		else{
            			window.location.href = base_url + 'employee'
            		}
            	},
            	error: function(error){
            		$(".btn-save").prop("disabled", false);
            		loading_save = false;
            		$(".global-loading").css({
                        "display": "none"
                    })
                    $("#message_modal").modal("show")
	                $("#message_modal .modal-body").html('<div class="text-danger">Unable to create employee, please try again.</div>');
            	}
            })
		}
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-save").click();
        }
    });
})