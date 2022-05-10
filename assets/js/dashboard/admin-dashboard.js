$(document).ready(function(){
	sales_graph_data();
	function sales_graph_data(){
		createProcessLoading('.process-loading-container', 'Generating graphs...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		var order_graph_canvas = document.getElementById("order_graph_canvas");
		var revenue_graph_canvas = document.getElementById("revenue_graph_canvas");
		$.ajax({
			url: base_url + "dashboard/salesGraphData",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				$(".grap-content").removeClass("d-none")

				new Chart(order_graph_canvas, {
		            type: 'bar',
		            data: {
		                labels: response.list_label_orders,
		                datasets: [
		                    {
		                        label: "Orders",
		                        backgroundColor: ["#3e95cd"],
		                        data: response.list_data_orders
		                    }
		                ]
		            },
		        });

		        new Chart(revenue_graph_canvas, {
		            type: 'bar',
		            data: {
		                labels: response.list_label_revenue,
		                datasets: [
		                    {
		                        label: "Revenue",
		                        backgroundColor: ["#3e95cd"],
		                        data: response.list_data_revenue
		                    }
		                ]
		            },
		        });
			},
			error: function(error){

			}
		})
	}
})