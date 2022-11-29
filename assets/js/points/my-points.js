$(document).ready(function(){
	var transactions = [];

	get_recent_transactions();
	function get_recent_transactions(){
		createProcessLoading('.process-loading-container', '', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "points/points-transaction",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();

				if(response.transactions.length > 0){
					$.each(response.transactions, function(key, data){
						var points = 0;
						if(data.debit > 0){
							points = '+'+(data.debit)+' points'
						}
						else if(data.credit > 0){
							points = '-'+(data.credit)+' points'
						}

						var transaction_details_container = $("<div class='transaction-details-container'>");
						transaction_details_container.append('<div class="description-container"><span>'+data.description+'</span><br><span class="date">'+data.created_date+'</span></div>')
						transaction_details_container.append('<div class="amount-container">'+points+'<br><button class="btn btn-sm btn-link btn-view-details" data-key="'+key+'">View details</button></div>')

						$(".transaction-container").append(transaction_details_container)
						$(".transaction-container").append("<br>")
					})
				}
				else{
					$(".transaction-container").append("<br><span>No transacion(s) yet.</span>")
				}
				transactions = response.transactions
			},
			error: function(){
				createProcessError('.process-loading-container', 'Failed.', "30px", "15px");
			}
		})
	}

	$(document).on("click", ".btn-view-details", function(){
		var key = $(this).data("key");
		var details = transactions[key];

		$("#transaction_details_modal .modal-body").empty();
		var transaction_details = $("#transaction_details_modal .modal-body");
		transaction_details.append('<div class="form-group"><span>Reference No.</span><br><span>'+details.reference_no+'</span></div>')
		transaction_details.append('<div class="form-group"><span>Transaction Date</span><br><span>'+details.created_date+'</span></div>')
		transaction_details.append('<div class="form-group"><span>Description</span><br><span>'+details.description+'</span></div>')
		if(details.debit > 0){
			transaction_details.append('<div class="form-group"><span>Points</span><br><span>'+details.debit+'</span></div>')
		}
		else if (details.credit > 0){
			transaction_details.append('<div class="form-group"><span>Points</span><br><span>'+details.credit+'</span></div>')
		}
		
		transaction_details.append('<div class="form-group"><span>Ending Balance</span><br><span>'+details.balance+'</span></div>')

		$("#transaction_details_modal").modal("show")
	})
});