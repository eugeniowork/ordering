$(document).ready(function(){
	get_product_category_list();
	function get_product_category_list(){
		$.ajax({
			url: base_url + "product/productCategoryList",
			type: 'POST',
			dataType: 'json',
			data:{

			},
			success: function(response){
				$("select[name=category]").append("<option disabled selected>Please select</option>")
				$.each(response.categories, function(key, data){
					if(data.id == category_id){
						$("select[name=category]").append("<option selected value='"+data.id+"'>"+data.name+"</option>")
					}
					else{
						$("select[name=category]").append("<option value='"+data.id+"'>"+data.name+"</option>")
					}
				})
			},
			error: function(error){

			}
		})
	}

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
            	url: base_url + "product/productSave",
            	type: 'POST',
            	dataType: 'json',
            	contentType: false,
			    cache: false,
			   	processData:false,
            	data: formData,
            	success: function(response){
            		if(response.is_error){
            			$(".btn-update").prop("disabled", false);
            			loading_update = false;
            			$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $("#message_modal").modal("show")
	                    $("#message_modal .modal-body").html('<div class="text-danger">'+response.error_msg+'</div>');
            		}
            		else{
            			window.location.reload()
            		}
            	},
            	error: function(error){
            		$(".btn-update").prop("disabled", false);
            		loading_update = false;
            		$(".global-loading").css({
                        "display": "none"
                    })
                    $("#message_modal").modal("show")
	                $("#message_modal .modal-body").html('<div class="text-danger">Unable to update product, please try again.</div>');
            	}
            })
		}
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-update").click();
        }
    });
})