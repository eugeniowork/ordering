$(document).ready(function(){
	var transactions = [];

	get_recent_transactions();
	function get_recent_transactions(){
		createProcessLoading('.process-loading-container', '', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "wallet/walletTransaction",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();

				if(response.transactions.length > 0){
					$.each(response.transactions, function(key, data){
						var amount = 0;
						if(data.debit > 0){
							amount = '+&nbsp;'+moneyConvertion(parseFloat(data.debit))
						}
						else if(data.credit > 0){
							amount = '-&nbsp;'+moneyConvertion(parseFloat(data.credit))
						}

						var transaction_details_container = $("<div class='transaction-details-container'>");
						transaction_details_container.append('<div class="description-container"><span>'+data.description+'</span><br><span class="date">'+data.created_date+'</span></div>')
						transaction_details_container.append('<div class="amount-container">'+amount+'<br><button class="btn btn-sm btn-link btn-view-details" data-key="'+key+'">View details</button></div>')

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
			transaction_details.append('<div class="form-group"><span>Amount</span><br><span>'+moneyConvertion(parseFloat(details.debit))+'</span></div>')
		}
		else if (details.credit > 0){
			transaction_details.append('<div class="form-group"><span>Amount</span><br><span>'+moneyConvertion(parseFloat(details.credit))+'</span></div>')
		}
		
		transaction_details.append('<div class="form-group"><span>Ending Balance</span><br><span>'+moneyConvertion(parseFloat(details.balance))+'</span></div>')

		$("#transaction_details_modal").modal("show")
	})

	$(".btn-cash-in").on("click", function(){
		$("#cash_in_modal").modal("show")
		$(".cash-in-details-container").empty();
		createProcessLoading('.cash-in-process-loading-container', '', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "wallet/getCashInRequest",
			type: 'POST',
			dataType: 'json',
			data:{
				status: 'PENDING'
			},
			success: function(response){
				$('.cash-in-process-loading-container').empty();
				var cash_in_details_container = $(".cash-in-details-container");
				if(response.results){
					cash_in_details_container.append('<span>Your pending cash in will expire on <strong>'+response.results.date_expiration+'</strong></span><br><br>')
					cash_in_details_container.append('<div class="form-group"><span>Reference No.</span><br><span>'+response.results.reference_no+'</span></div>')
					cash_in_details_container.append('<div class="form-group"><span>Amount</span><br><span>'+moneyConvertion(parseFloat(response.results.request_amount))+'</span></div>')
					cash_in_details_container.append('<div class="cash-in-warning"></div>')
					cash_in_details_container.append('<button class="btn btn-sm btn-danger btn-cancel-cash-in" data-id="'+response.results.encrypted_id+'">Cancel</button>')
				}
				else{
					cash_in_details_container.append('<div class="form-group"><span>Amount&nbsp;<span class="text-danger">*</span></span><input type="text" class="form-control float-only cash-in-amount" placeholder="Enter amount"></div>')
					cash_in_details_container.append('<div class="cash-in-warning"></div>')
					cash_in_details_container.append('<button class="btn btn-sm btn-primary btn-submit-cash-in">Submit</button>');
				}
				$(".cash-in-details-container").append(cash_in_details_container)
			},
			error: function(error){
				$('.cash-in-process-loading-container').empty();
				var cash_in_details_container = $(".cash-in-details-container");
				cash_in_details_container.append('<div class="form-group"><span>Amount&nbsp;<span class="text-danger">*</span></span><input type="text" class="form-control float-only cash-in-amount" placeholder="Enter amount"></div>')
				cash_in_details_container.append('<div class="cash-in-warning"></div>')
				cash_in_details_container.append('<button class="btn btn-sm btn-primary btn-submit-cash-in">Submit</button>');
				$(".cash-in-details-container").append(cash_in_details_container)
			}
		})
	})

	var loading_submit_cash_in = false;
	$(document).on("click", ".btn-submit-cash-in", function(){
		if(!loading_submit_cash_in){
			loading_submit_cash_in = true;
		
			$(".btn-submit-cash-in").prop("disabled", true).html("Loading....")
			$(".cash-in-warning").empty();

			$(".global-loading").css({
	            "display": "flex"
	        })
	        createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

	        $.ajax({
	        	url: base_url + "wallet/submitCashIn",
	        	type: 'POST',
	        	dataType: 'json',
	        	data:{
	        		amount: $(".cash-in-amount").val(),
	        	},
	        	success: function(response){
	        		$(".global-loading").css({"display": "none"})

	                if(response.is_error){
	                	$(".btn-submit-cash-in").prop("disabled", false).html("Submit")
	        			loading_submit_cash_in = false;
	                	renderResponse('.cash-in-warning',response.error_msg, "danger")
	                }
	                else{
	                	toastOptions(4000);
	                    toastr.success("Cash in successful");
	                    $("#cash_in_modal").modal("hide")
	                    $(".btn-cash-in").click();
	                }
	        	},
	        	error: function(error){
	        		$(".global-loading").css({"display": "none"})
	        		$(".btn-submit-cash-in").prop("disabled", false).html("Submit")
        			loading_submit_cash_in = false;
                	renderResponse('.cash-in-warning',"Unable to request cash in, please try again.", "danger")
	        	}
	        })
        }
	})

	var cash_in_id;
	$(document).on("click", ".btn-cancel-cash-in", function(){
		cash_in_id = $(this).data("id")
		$("#confirm_cash_in_cancel").modal("show")
	})

	var loading_cancel_cash_in = false;
	$(".btn-confirm-cancel-cash-in").on("click", function(){
		if(!loading_cancel_cash_in){
			loading_cancel_cash_in = true;
			$(".global-loading").css({
	            "display": "flex"
	        })
	        $(".cash-in-warning").empty();
	        createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

	        $.ajax({
	        	url: base_url + "wallet/cancelMyCashIn",
	        	type: 'POST',
	        	dataType: 'json',
	        	data:{
	        		id: cash_in_id
	        	},
	        	success: function(response){
	        		window.location.reload();
	        	},
	        	error: function(error){
	        		$(".global-loading").css({"display": "none"})
	        		loading_cancel_cash_in = false;
	        		renderResponse('.cash-in-warning',"Unable to cancel cash in, please try again.", "danger")
	        		$("#confirm_cash_in_cancel").modal("hide")
	        	}
	        })
		}
	})
})