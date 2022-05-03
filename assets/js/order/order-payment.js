$(document).ready(function(){
	var payment_method = "";
	var loading_confirm_payment = false;
	var is_successful_payment = false;

	$("input[type=radio]").change(function () {
		$("input[type=radio]").not(this).prop('checked', false);

		$(".cash-amount").val("")

		if($(this).val() == "face_pay"){
			$(".face-pay-container").removeClass("d-none")
			$(".cash-container").addClass("d-none")
			payment_method = "FACE PAY"
		}
		else{
			$(".cash-container").removeClass("d-none")
			$(".face-pay-container").addClass("d-none")
			payment_method = "CASH"
		}
	});

	$(".cash-amount").on("keyup", function(){
		var cash_amount = parseFloat($(this).val())
		if(cash_amount >= total_order_amount){
			$(".btn-open-payment-confirmation").removeClass("d-none")
			$(".cash-change").text((cash_amount - total_order_amount).toFixed(2))
			$(".cash-amount-warning").html("")
		}
		else{
			$(".btn-open-payment-confirmation").addClass("d-none")
			$(".cash-change").text("")
			$(".cash-amount-warning").html("<small class='text-danger'>Please enter amount that is equal or greater than "+moneyConvertion(parseFloat(total_order_amount))+".</small>")
		}
	})

	$(".btn-open-payment-confirmation").on("click", function(){
		$("#confirm_payment_modal").modal("show")
	})

	$(".btn-code").on("click", function(){
		
	})
	$(".btn-facial-recognition").on("click", function(){

	})
	
	$(".btn-confirm-payment").on("click", function(){
		if(!loading_confirm_payment){
			loading_confirm_payment = true;

			$(".btn-confirm-payment").prop("disabled", true).html("Loading....")

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            var url = "";
            if(payment_method == "CASH"){
            	var url = "order/saveCashOrderPayment";
            }
            else if(payment_method == "FACE PAY"){
            	var url = "order/saveFacePayOrderPayment";
            }
            $.ajax({
            	url: base_url + url,
            	type: 'POST',
            	dataType: 'json',
            	data:{
            		order_id: order_id,
            		cash_amount: $(".cash-amount").val(),
            	},
            	success: function(response){
            		if(response.is_error){
            			loading_confirm_payment = false;
            			$(".modal").modal("hide")
            			$("#message_modal").modal("show")
            			$("#message_modal .modal-body").html("<span class='text-danger'>"+response.error_msg+"</span>")
						$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $(".btn-confirm-payment").prop("disabled", false).html("Submit")
            		}
            		else{
	              		window.location.href = base_url + "order-payment-successful/"+order_id;
            		}
            	},
            	error: function(error){
            		loading_confirm_payment = false;
            		$(".modal").modal("hide")
            		$("#message_modal").modal("show")
					$("#message_modal .modal-body").html("<span class='text-danger'>Unable to confirm payment, please try again.</span>")
					$(".global-loading").css({
                        "display": "none"
                    })
                    $(".btn-confirm-payment").prop("disabled", false).html("Submit")
            	}
            })
		}
	})
})