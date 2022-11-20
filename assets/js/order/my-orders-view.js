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

	$(document).on("click", ".btn-cancel-order", function(){
		$("#cancel_order_modal").modal("show")
	})

	var loading_cancel_order = false;
	$(".btn-confirm-cancel-order").on("click", function(){
		if(!loading_cancel_order){
			loading_cancel_order = true
		
			$(".btn-confirm-cancel-order").prop("disabled", true).html("Cancelling order...")

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Cancelling order...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

			$.ajax({
				url: base_url + "order/updateOrderStatus",
				type: 'POST',
				dataType: 'json',
				data:{
					order_id: order_id,
					remarks: $(".remarks").val(),
					status: "CANCELED",
					user_type: "user"
				},
				success: function(response){
					if(response.is_error){
						loading_cancel_order = false;
						$("#cancel_order_modal .warning").html(response.error_msg)
						$(".global-loading").css({
                            "display": "none"
                        })
                        $(".btn-confirm-cancel-order").prop("disabled", false).html("Submit")
					}
					else{
						window.location.reload();
					}
				},
				error: function(error){
					loading_cancel_order = false;
					$("#cancel_order_modal .warning").html("Unable to cancel order, please try again.")
					$(".global-loading").css({
                        "display": "none"
                    })
                    $(".btn-confirm-cancel-order").prop("disabled", false).html("Submit")
				}
			})
		}
	})

	var date_pickup = "";
	$(document).on("click", ".btn-resched-pickup", function(){
		$(".resched-date-pickup").val(date_pickup)
		$("#resched_pickup_modal").modal("show");
	});

	var loading_resched_pickup = false;
	$(".btn-confirm-resched").on("click", function(){
		console.log($(".resched-date-pickup").val())
		if(!loading_resched_pickup){
			loading_resched_pickup = true
		
			$(".btn-confirm-resched").prop("disabled", true).html("Loading...")

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

			$.ajax({
				url: base_url + "order/reschedOrderPickup",
				type: 'POST',
				dataType: 'json',
				data:{
					order_id: order_id,
					date_pickup: $(".resched-date-pickup").val()
				},
				success: function(response){
					if(response.success){
						window.location.reload();
					}
					else{
						loading_resched_pickup = false;
						$(".resched_pickup_modal .warning").html(response.error_msg)
						$(".global-loading").css({
                            "display": "none"
                        })
                        $(".btn-confirm-resched").prop("disabled", false).html("Submit")
					}
				},
				error: function(error){
					loading_resched_pickup = false;
					$(".resched_pickup_modal .warning").html("Something went wrong, please try again.")
					$(".global-loading").css({
                        "display": "none"
                    })
                    $(".btn-confirm-resched").prop("disabled", false).html("Submit")
				}
			})
		}
	})
});