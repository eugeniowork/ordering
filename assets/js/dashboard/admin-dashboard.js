$(document).ready(function(){
	$(".filter-order-graph").on("change", function(){
		order_graph_data();
	}).change();
	
	var order_chart;
	function order_graph_data(){
		createProcessLoading('.order-graph-process-loading-container', 'Generating graph...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		var order_graph_canvas = document.getElementById("order_graph_canvas");
		if(order_chart){
			order_chart.destroy();
		}

		$.ajax({
			url: base_url + "dashboard/salesGraphData",
			type: 'POST',
			dataType: 'json',
			data:{
				"filter": $(".filter-order-graph").val(),
			},
			success: function(response){
				$('.order-graph-process-loading-container').empty();
				$(".order-graph-container").removeClass("d-none")

		  		order_chart = new Chart(order_graph_canvas, {
		            type: 'bar',
		            data: {
		                labels: response.final_label,
		                datasets: [
		                    {
		                        label: "Orders",
		                        backgroundColor: ["#3e95cd"],
		                        data: response.final_data_orders
		                    }
		                ]
		            },
		        });
			},
			error: function(error){

			}
		})
	}

	$(".filter-revenue-graph").on("change", function(){
		revenue_graph_data();
	}).change();

	var revenue_chart;
	function revenue_graph_data(){
		createProcessLoading('.revenue-graph-process-loading-container', 'Generating graph...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		var revenue_graph_canvas = document.getElementById("revenue_graph_canvas");
		if(revenue_chart){
			revenue_chart.destroy();
		}

		$.ajax({
			url: base_url + "dashboard/salesGraphData",
			type: 'POST',
			dataType: 'json',
			data:{
				"filter": $(".filter-revenue-graph").val(),
			},
			success: function(response){
				$('.revenue-graph-process-loading-container').empty();
				$(".revenue-graph-container").removeClass("d-none")

		  		revenue_chart = new Chart(revenue_graph_canvas, {
		            type: 'bar',
		            data: {
		                labels: response.final_label,
		                datasets: [
		                    {
		                        label: "Revenue",
		                        backgroundColor: ["#3e95cd"],
		                        data: response.final_data_revenue
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