$(document).ready(function(){
	get_my_orders();
	function get_my_orders(){
		createProcessLoading('.process-loading-container', 'Getting orders...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "order/myOrdersList",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();

				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
				}
				else{
					var active_orders_container = $(".active-orders-container")
					var past_orders_container = $(".past-orders-container")

					$.each(response.orders, function(key, data){
						var row = $("<div class='row'>")
						var col_12_order_buttons = $("<div class='col-12 col-lg-12' style='margin-bottom: -10px !important;z-index:1'>")
						var col_12_order_details = $("<div class='col-12 col-lg-4 col-xs-4 col-md-4 col-sm-4'>")
						var col_12_order_amount = $("<div class='col-12 col-lg-3 col-xs-3 col-md-3 col-sm-3'>")
						var col_12_order_status = $("<div class='col-12 col-lg-5 col-xs-5 col-md-5 col-sm-5'>")

						if(data.status == "FOR PROCESS"){
							col_12_order_buttons.append('<br><button class="btn btn-sm btn-resched-pickup btn-outline-success" data-id="'+data.encrypted_id+'" data-date-pickup="'+data.date_pickup+'">Resched pickup</button>')
							col_12_order_buttons.append('&nbsp;<button class="btn btn-sm btn-cancel-order btn-outline-danger" data-id="'+data.encrypted_id+'">Cancel Order</button>')
						}

						col_12_order_details.append('<br><span style="font-weight: 600; color: #333" class="order-number">Order <a href="#" data-id="'+data.encrypted_id+'" style="font-style:italic;" class="btn-order-view-details">#'+data.order_number+'</a></span>')
						
						$.each(data.products, function(key, data_products){
							col_12_order_details.append('<div class="" style="position:relative;right: -5px;"><span>'+data_products.quantity+'</span>x&nbsp;<span>'+data_products.name+'</span></div>')
						})

						col_12_order_amount.append('<br><strong>'+moneyConvertion(parseFloat(data.total_amount))+'</strong>')

						//col_12_order_status.append('<br><br><span style="font-weight: 600;">'+data.status+'</span>')
						var col_12_order_status_row = $("<div class='row'>");

						if(data.status == "FOR PROCESS"){
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container status-container-active"><span>For Process</span></div></div>')
						}
						else{
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container"><span>For Process</span></div></div>')
						}

						if(data.status == "FOR PICKUP"){
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container status-container-active"><span>For Pickup</span></div></div>')
						}
						else{
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container"><span>For Pickup</span></div></div>')
						}

						if(data.status == "CANCELED"){
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container status-container-active"><span>Canceled</span></div></div>')
						}
						else{
							if(data.status == "PICKED UP"){
								col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container status-container-active"><span>Picked Up</span></div></div>')
							}
							else{
								col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container"><span>Picked Up</span></div></div>')
							}
						}

						col_12_order_status.append(col_12_order_status_row)

						row.append(col_12_order_buttons)
						row.append(col_12_order_details)
						row.append(col_12_order_amount)
						row.append(col_12_order_status)

						if(data.status == "CANCELED" || data.status == "PICKED UP"){
							past_orders_container.append(row)
						}
						else{
							active_orders_container.append(row)
						}
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
			}
		})
	}
	var order_id;
	$(document).on("click", ".btn-cancel-order", function(){
		order_id = $(this).data("id");
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

	$(document).on("click", ".btn-order-view-details", function(){
		order_id = $(this).data("id");
		$("#details_modal").modal("show")

		$.ajax({
			url: base_url + "order/myOrderDetails",
			type: 'POST',
			dataType: 'json',
			data:{
				order_id: order_id
			},
			beforeSend: function(){
				createProcessLoading('.order-details-loading-container', '', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
				$(".order-details-container").empty();
			},
			success: function(response){
				$(".order-details-loading-container").empty();

				$("#details_modal .order-number-title").html(response.order_number)
				var row = $("<div class='row'>")
				row.append("<div class='col-12 col-lg-12'><span><span style='font-weight: 600'>Date Ordered</span>: "+response.created_date+"</span></div>")
				row.append("<div class='col-12 col-lg-12'><span style='font-weight: 600'>Scheduled Date Pickup</span>: "+response.date_pickup+"</div>")
				if(response.order_status == "PICKED UP"){
					row.append("<div class='col-12 col-lg-12'><span style='font-weight: 600'>Actual Date Pickup</span>: "+response.actual_date_pickup+"</div>")
				}

				$(".order-details-container").append(row)
			},
			error: function(error){

			}
		})

		get_order_tracking();
	})

	var date_pickup = "";
	$(document).on("click", ".btn-resched-pickup", function(){
		order_id = $(this).data("id");
		date_pickup = $(this).data("date-pickup");
		$(".resched-date-pickup").val(date_pickup)
		$("#resched_pickup_modal").modal("show");
	});

	$("#resched_pickup_modal").on("hidden.bs.modal", function(){
		date_pickup = "";
		order_id = "";
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
})