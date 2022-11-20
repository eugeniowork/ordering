$(document).ready(function(){
	var status = "ALL";
	$(".btn-load-orders").on("click", function(){
		$(".btn-load-orders").removeClass("btn-active")
		$(this).addClass("btn-active")

		status = $(this).data("status");
		get_my_orders();
	});

	get_my_orders();
	function get_my_orders(){
		createProcessLoading('.process-loading-container', ' ', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		$(".active-orders-container").empty();

		$.ajax({
			url: base_url + "order/myOrdersList",
			type: 'POST',
			dataType: 'json',
			data:{
				status: status,
			},
			success: function(response){
				$('.process-loading-container').empty();

				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
				}
				else{
					var active_orders_container = $(".active-orders-container")

					if(response.orders.length > 0){
						$.each(response.orders, function(key, data){
							var row = $("<div class='row' style='border-bottom: 1px solid lightgrey; margin-bottom: 15px;'>")
							var col_12_order_buttons = $("<div class='col-12 col-lg-12' style='margin-bottom: -10px !important;z-index:1'>")
							var col_12_order_details = $("<div class='col-12 col-lg-4 col-xs-4 col-md-4 col-sm-4'>")
							var col_12_order_amount = $("<div class='col-12 col-lg-3 col-xs-3 col-md-3 col-sm-3'>")
							var col_12_order_status = $("<div class='col-12 col-lg-5 col-xs-5 col-md-5 col-sm-5'>")

							col_12_order_details.append('<br><span style="font-weight: 600; color: #333" class="order-number">Order <a href="'+base_url+'my-orders-view/'+this.encrypted_id+'" data-id="'+data.encrypted_id+'" style="font-style:italic;" class="btn-order-view-details">#'+data.order_number+'</a></span>')
							
							$.each(data.products, function(key, data_products){
								col_12_order_details.append('<div class="" style="position:relative;right: -5px;"><span>'+data_products.quantity+'</span>x&nbsp;<span>'+data_products.name+'</span></div>')
							})

							col_12_order_amount.append('<br><strong>'+moneyConvertion(parseFloat(data.grand_total))+'</strong>')

							var col_12_order_status_row = $("<div class='row'>");
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container '+(data.status == "FOR PROCESS"? 'status-container-active': '')+'"><span>For Process</span></div></div>')
							col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container '+(data.status == "FOR PICKUP"? 'status-container-active': '')+'"><span>For Pickup</span></div></div>')

							if(data.status == "CANCELED"){
								col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container status-container-active"><span>Canceled</span></div></div>')
							}
							else{
								col_12_order_status_row.append('<div class="col-12 col-lg-2 col-xs-4 col-md-4 col-sm-4"><div class="status-container '+(data.status == "PICKED UP"? 'status-container-active': '')+'"><span>Picked Up</span></div></div>')
							}

							col_12_order_status.append(col_12_order_status_row)

							row.append(col_12_order_buttons)
							row.append(col_12_order_details)
							row.append(col_12_order_amount)
							row.append(col_12_order_status)

							active_orders_container.append(row)
						})
					}
					else{
						active_orders_container.append("<center><span style='font-size: 20px;'>No orders found.</span></center>")
					}
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load orders.', "30px", "15px");
			}
		})
	}
});