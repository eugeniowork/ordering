$(document).ready(function(){
	get_order_tracking();
	function get_order_tracking(){
		createProcessLoadingV2({"div_name": ".order-tracking-widget-container", "loading_text": " ", "position": "left", "font_size": "13px", "font_weight": "600", "height": "30px", "width": "30px"});
		$.ajax({
			url: base_url + "order/orderTrackingWidget",
			type: 'POST',
			data:{
				id: order_id
			},
			success: function(data){
				$(".order-tracking-widget-container").html(data);
			}
		})
	}

	$(".btn-edit-status").on("click", function(){
		$("#change_order_status_modal").modal("show")
	})

	var loading_change_status = false;
	$(".btn-confirm-change-order-status").on("click", function(){
		if(!loading_change_status){
			loading_change_status = true;

			$(".btn-confirm-change-order-status").prop("disabled", true).html("Submitting....")

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            $.ajax({
				url: base_url + "order/updateOrderStatus",
				type: 'POST',
				dataType: 'json',
				data:{
					order_id: order_id,
					remarks: $(".remarks").val(),
					status: $(".status").val(),
					user_type: user_type
				},
				success: function(response){
					if(response.is_error){
						loading_change_status = false;
						$(".warning").html(response.error_msg)
						$(".global-loading").css({
                            "display": "none"
                        })
                        $(".btn-confirm-change-order-status").prop("disabled", false).html("Submit")
					}
					else{
						window.location.reload();
					}
				},
				error: function(error){
					loading_change_status = false;
					$(".warning").html("Unable to change order status, please try again.")
					$(".global-loading").css({
                        "display": "none"
                    })
                    $(".btn-confirm-change-order-status").prop("disabled", false).html("Submit")
				}
			})
		}
	})
});