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
						var col_12_order_details = $("<div class='col-12 col-lg-3 col-xs-3 col-md-3 col-sm-3'>")
						var col_12_order_amount = $("<div class='col-12 col-lg-3 col-xs-3 col-md-3 col-sm-3'>")
						var col_12_order_status = $("<div class='col-12 col-lg-6 col-xs-6 col-md-6 col-sm-6'>")

						col_12_order_details.append('<span style="font-weight: 600; color: #333" class="order-number">Order #'+data.order_number+'<button data-id="'+data.encrypted_id+'" class="btn btn-sm btn-link btn-order-view-details">View details</button></span>')

						if(data.status == "FOR PROCESS"){
							col_12_order_details.append('<button class="btn btn-sm btn-cancel-order" data-id="'+data.encrypted_id+'">Cancel Order</button>')
						}
						
						$.each(data.products, function(key, data_products){
							col_12_order_details.append('<div class=""><span>'+data_products.quantity+'</span>x&nbsp;<span>'+data_products.name+'</span></div>')
						})

						col_12_order_amount.append('<strong>'+moneyConvertion(parseFloat(data.total_amount))+'</strong>')

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
						$(".warning").html(response.error_msg)
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
					$(".warning").html("Unable to cancel order, please try again.")
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
				$(".order-history-container").hide();
				$(".order-history-table tbody").empty();
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

				$(".order-history-container").show();
				if(response.order_logs.length > 0){
					$.each(response.order_logs, function(){
						var tr = $("<tr>");
						tr.append('<td>'+this.created_date+'</td>')
						tr.append('<td>'+this.name+'</td>')
						tr.append('<td>'+this.description+'</td>')
						tr.append('<td>'+this.status+'</td>')

						$(".order-history-container tbody").append(tr)
					})
				}
			},
			error: function(error){

			}
		})
	})
})