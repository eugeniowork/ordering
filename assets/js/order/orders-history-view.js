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
})