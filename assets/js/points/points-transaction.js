$(document).ready(function(){
	var transactionTable;

	get_recent_transactions();
	function get_recent_transactions(){
		createProcessLoading('.process-loading-container', 'Getting transactions', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "points/points-transaction",
			type: 'POST',
			dataType: 'json',
			data:{},
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load transactions.', "30px", "15px");
				}
				else{
					$(".transaction-content").removeClass("d-none")
					transactionTable = $('.transaction-table').DataTable({
						"data": response.transactions,
						"columns": [
							{
				            	"data":"fullname",
				            },
				            {
				            	"data":"reference_no",
				            },
				            {
				            	"data":"description",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.debit))
				                    return html;
				                }
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.credit))
				                    return html;
				                }
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = moneyConvertion(parseFloat(full.balance))
				                    return html;
				                }
				            },
				            {
				            	"data":"created_date",
				            },
				            {
				            	"data":"",
				                "render": function(data, type, full, meta) {
				                    var html = "";
				                    html = '<button class="btn btn-outline-success btn-sm btn-view-transaction"><i class="fa-solid fa-eye"></i></button>'
				                    return html;
				                }
				            },
						],
						"ordering": true,
					    "aaSorting": [],
					    "bDestroy": true
					})
				}
			},
			error: function(){
				createProcessError('.process-loading-container', 'Unable to load transactions.', "30px", "15px");
			}
		})
	}

	$(document).on("click", ".btn-view-transaction", function(){
		var data = transactionTable.row( $(this).parents('tr') ).data();
		$("#transaction_details_modal .modal-body").empty();
		var transaction_details = $("#transaction_details_modal .modal-body");
		transaction_details.append('<div class="form-group"><span>Customer Name.</span><br><span>'+data.fullname+'</span></div>')
		transaction_details.append('<div class="form-group"><span>Reference No.</span><br><span>'+data.reference_no+'</span></div>')
		transaction_details.append('<div class="form-group"><span>Transaction Date</span><br><span>'+data.created_date+'</span></div>')
		transaction_details.append('<div class="form-group"><span>Description</span><br><span>'+data.description+'</span></div>')
		if(data.debit > 0){
			transaction_details.append('<div class="form-group"><span>Amount</span><br><span>'+moneyConvertion(parseFloat(data.debit))+'</span></div>')
		}
		else if (data.credit > 0){
			transaction_details.append('<div class="form-group"><span>Amount</span><br><span>'+moneyConvertion(parseFloat(data.credit))+'</span></div>')
		}
		
		transaction_details.append('<div class="form-group"><span>Ending Balance</span><br><span>'+moneyConvertion(parseFloat(data.balance))+'</span></div>')

		$("#transaction_details_modal").modal("show")
	})
});