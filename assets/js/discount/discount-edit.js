$(document).ready(function(){
	var loading_update
	$(".btn-update").on("click", function(){
		if(!loading_update){
			loading_update = true;

			$(".btn-update").prop("disabled", true);

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            var formData = new FormData($("#form")[0])
            formData.append('encrypted_id', encrypted_id)

            $.ajax({
            	url: base_url + "discount/discount-save",
            	type: 'POST',
            	dataType: 'json',
            	contentType: false,
			    cache: false,
			   	processData:false,
            	data: formData,
            	success: function(response){
            		if(response.success){
            			window.location.reload()
            		}
            		else{
            			$(".btn-update").prop("disabled", false);
            			loading_update = false;
            			$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $("#message_modal").modal("show")
	                    $("#message_modal .modal-body").html('<div class="text-danger">'+response.msg+'</div>');
            		}
            	},
            	error: function(error){
            		$(".btn-update").prop("disabled", false);
            		loading_update = false;
            		$(".global-loading").css({
                        "display": "none"
                    })
                    $("#message_modal").modal("show")
	                $("#message_modal .modal-body").html('<div class="text-danger">Unable to update discount, please try again.</div>');
            	}
            })
		}
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-update").click();
        }
    });
});