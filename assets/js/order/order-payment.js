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

	//FOR FACIAL RECOGNITION
	var webcam_element = document.getElementById('webcam');
	var webcam = new Webcam(webcam_element, 'user');
	var model_path = base_url+'assets/uploads/face_recognition_models';
	var display_size, face_detection, canvas, face_descriptor;

	$(".btn-facial-recognition").on("click", function(){
		$("#face_modal").modal("show")
		init_web_cam();
	})

	$('#face_modal').on('hidden.bs.modal', function () {
		camera_stopped();
		
		console.log("webcam stopped");
	});

	$("#webcam").bind("loadedmetadata", function () {
		display_size = { width:this.scrollWidth, height: this.scrollHeight }
	});

	function init_web_cam(){
		webcam.start()
			.then(result =>{
				camera_started();
				webcam_element.style.transform = "";
				console.log("webcam started");
			})
		  	.catch(err => {
				display_error();
			});
	}

	function camera_started(){
		$("#error_msg").addClass("d-none");
		$(".btn-submit-face").prop("disabled", true)
		
		if( webcam.webcamList.length >= 1){
			$(".loading").removeClass('d-none');

			Promise.all([
				faceapi.nets.tinyFaceDetector.load(model_path),
				faceapi.nets.faceLandmark68TinyNet.load(model_path),
				faceapi.nets.faceRecognitionNet.load(model_path)
			]).then(function(){
				create_canvas();
				start_detection();
			})
		}
	}

	function camera_stopped(){
		$("#error_msg").addClass("d-none");

		clearInterval(face_detection);
		webcam.stop();
		if(typeof canvas !== "undefined"){
			setTimeout(function() {
				canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
				$('canvas').remove();
			}, 1000);
	    }
	}

	function display_error(err = ''){
		if(err!=''){
		  $("#error_msg").html(err);
		}
		$("#error_msg").removeClass("d-none");
	}

	function create_canvas(){
		if( document.getElementsByTagName("canvas").length == 0 ){
			canvas = faceapi.createCanvasFromMedia(webcam_element)
			document.getElementById('webcam-container').append(canvas)
			faceapi.matchDimensions(canvas, display_size)
		}
	}
	
	function start_detection(){
		face_detection = setInterval(async () => {
			const detections = await faceapi.detectSingleFace(webcam_element, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks(true).withFaceDescriptor()
			const resized_detections = faceapi.resizeResults(detections, display_size)
			canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

			faceapi.draw.drawDetections(canvas, resized_detections)
			faceapi.draw.drawFaceLandmarks(canvas, resized_detections)

			face_descriptor = detections.descriptor
			
			if(detections.descriptor){
				$(".btn-submit-face").prop("disabled", false)
			}

			if(!$(".loading").hasClass('d-none')){
				$(".loading").addClass('d-none')
		    }
		}, 300)
	}

	$(".btn-submit-face").on("click", function(){
		const distance = faceapi.euclideanDistance(face_descriptor, face1_value);
		if(distance < 0.5){
	    	console.log("match")
	    }
		// var fd = new FormData()
		// fd.append('test', JSON.stringify(test))
		// $.ajax({
		// 	url: base_url + "order/saveFacePayOrderPayment",
		// 	type: 'POST',
		// 	dataType: 'json',
		// 	data:fd,
		// 	contentType: false,
		//     cache: false,
		//    	processData:false,
		// 	success: function(response){
		// 		var newfloat = new Float32Array(response.test_encode)
		// 		new_float = newfloat;
		// 		// console.log(newfloat)
		// 		// console.log(response.test_encode)
		// 		// console.log(test)
		// 		// const distance = faceapi.euclideanDistance(newfloat, test);
		//   //   	console.log(distance)
		// 	},
		// 	error: function(error){

		// 	}
		// })
	})
})