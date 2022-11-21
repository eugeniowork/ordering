$(document).ready(function(){
	//FOR FACIAL RECOGNITION
	var webcam_element = document.getElementById('webcam');
	var webcam = new Webcam(webcam_element, 'user');
	var model_path = base_url+'assets/uploads/face_recognition_models';
	var display_size, face_detection, canvas, face_descriptor;
	var user_details = {};
	var is_face_recog_success = false;
	var no_face_detected;

	$(".btn-scan-face").on("click", function(){
		init_web_cam();
		reset_cashin();
		$("#face_modal").modal("show")
	});
	

	//FOR FACIAL RECOGNITION
	$('#face_modal').on('hidden.bs.modal', function () {
		camera_stopped();
		
		console.log("webcam stopped");

		//STOP INTERVAL FOR NO FACE DETECTED
		clearInterval(no_face_detected);
		no_face_detected = null;

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

		//REMOVE PREVIOUS INTERVAL ON NO FACE DETECTED
		no_face_detected = null;
	}

	function camera_stopped(){
		$("#error_msg").addClass("d-none");

		clearInterval(face_detection);
		face_detection = null;
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
			if(detections){
				const resized_detections = faceapi.resizeResults(detections, display_size)
				canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

				faceapi.draw.drawDetections(canvas, resized_detections)
				faceapi.draw.drawFaceLandmarks(canvas, resized_detections)

				face_descriptor = detections.descriptor

				if(face_descriptor){
					camera_stopped();
					$("#face_modal").modal("hide")
					verify_face();

					console.log('face detected')
					//STOP INTERVAL FOR NO FACE DETECTED
					clearInterval(no_face_detected);
					//REMOVE PREVIOUS INTERVAL ON NO FACE DETECTED
					no_face_detected = null;
				}

				if(!$(".loading").hasClass('d-none')){
					$(".loading").addClass('d-none')
			    }
			}
			else{
				$(".btn-submit-face").prop("disabled", true)

				//CHECK IF INTERVAL IS ALREADY SET
				if(!no_face_detected){
					no_face_detected = setInterval(function() { 
				        generate_error();
				        //13000 = 13 sec
				    }, 13000);
				}
			}
			
		}, 300)
	}

	function verify_face(){
		$.each(users, function(key, data){
			if(data.face1_value){
				var face1_value = new Float32Array(Object.values(data.face1_value));
				const distance = faceapi.euclideanDistance(face_descriptor, face1_value);
				
				if(distance < 0.5){
					user_details = data;
					is_face_recog_success = true;
					$(".cutomer-name-val").text(data.firstname+" "+data.middlename+" "+data.lastname)
					$(".cutomer-email-val").text(data.email)
					$(".cash-in-details-container").removeClass("d-none")
					return false;
				}
			}
		})

		$("#message_modal").modal("show")
		if(is_face_recog_success){
			$("#message_modal .modal-body").html("<span class='text-primary'>Registered face matched.</span>")
		}
		else{
			$("#message_modal .modal-body").html("<span class='text-danger'>Face does not exist. Make sure to face the camera properly.</span>")
		}
	}

	$(document).on("keyup", ".cash-amount", function(){
		var cash_amount = parseFloat($(this).val())
		var request_amount = parseFloat($(".request-amount").val())
		$(".cash-amount-warning").html("")
		if(cash_amount >= request_amount){
			$(".cash-change").val((cash_amount - request_amount).toFixed(2))
			if(Object.keys(user_details).length === 0){
				$(".btn-confirm-cash-in").addClass("d-none")
			}
			else{
				$(".btn-confirm-cash-in").removeClass("d-none")
			}
		}
		else{
			$(".cash-change").val("")
			$(".cash-amount-warning").html("<small class='text-danger'>Please enter amount that is equal or greater than "+moneyConvertion(parseFloat(request_amount))+".</small>")
			$(".btn-confirm-cash-in").addClass("d-none")
		}
	})

	$(".btn-confirm-cash-in").on("click", function(){
		$("#confirm_cash_in_modal").modal("show")
	})

	var loading_save_cash_in = false;
	$(".btn-save-cash-in").on("click", function(){
		if(!loading_save_cash_in){
			loading_save_cash_in = true;

			$(".btn-save-cash-in").prop("disabled", true).html("Loading....")

			$(".modal").modal("hide")

			$(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Loading...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')

            $.ajax({
            	url: base_url + "wallet/confirmCashInV2",
            	type: 'POST',
            	dataType: 'json',
            	data:{
            		user_details: user_details,
            		request_amount: $(".request-amount").val(),
            		cash_amount: $(".cash-amount").val(),
            		is_face_recog_success: is_face_recog_success
            	},
            	success: function(response){
            		if(response.is_error){
            			loading_save_cash_in = false;
            			$("#message_modal").modal("show")
						$("#message_modal .modal-body").html("<span class='text-danger'>"+response.error_msg+"</span>")
            			$(".global-loading").css({
	                        "display": "none"
	                    })
	                    $(".btn-save-cash-in").prop("disabled", false).html("Yes")
            		}
            		else{
            			// window.location.href = base_url + "cash-in-successful/"+response.cash_in_id;
            			$("#message_modal").modal("show")
						$("#message_modal .modal-body").html("<span class='text-primary'>Cash in successful</span>")

            			reset_cashin();
            		}
            	},
            	error: function(error){
            		loading_save_cash_in = false;
            		$("#message_modal").modal("show")
					$("#message_modal .modal-body").html("<span class='text-danger'>Unable to confirm cash in, please try again.</span>")
        			$(".global-loading").css({
                        "display": "none"
                    })
                    $(".btn-save-cash-in").prop("disabled", false).html("Yes")
            	}
            })
		}
	})

	function generate_error(){
		console.log("no face detected")
        $("#face_modal").modal("hide")
        $("#message_modal").modal("show")
		$("#message_modal .modal-body").html("<span class='text-danger'>No face detected, please make sure to face the camera properly.</span>")
        camera_stopped();
        reset_cashin();
        $(".btn-submit-face").prop("disabled", true)

		//STOP INTERVAL FOR NO FACE DETECTED
		clearInterval(no_face_detected);
	}

	function reset_cashin(){
		loading_save_cash_in = false;
		$(".global-loading").css({
            "display": "none"
        })
        $(".btn-save-cash-in").prop("disabled", false).html("Yes")
        $(".btn-confirm-cash-in").addClass("d-none")

		$(".cash-in-details-container").addClass("d-none")
		user_details = {};
		$(".cutomer-name-val").text("N/A")
		$(".cutomer-email-val").text("N/A")
		is_face_recog_success = false;

		$(".request-amount").val("");
		$(".cash-amount").val("");
		$(".cash-amount").val("");
	}

    prepare_face_detector();
	function prepare_face_detector() {
		Promise.all([
			faceapi.nets.tinyFaceDetector.load(model_path),
			faceapi.nets.faceLandmark68TinyNet.load(model_path),
			faceapi.nets.faceRecognitionNet.load(model_path)
		]).then(function(){
			let base_image = new Image();
			base_image.src = model_path+'/face.jpg';
			base_image.onload = function() {
				const useTinyModel = true;
				const fullFaceDescription = faceapi
				.detectSingleFace(base_image, new faceapi.TinyFaceDetectorOptions())
				.withFaceLandmarks(useTinyModel)
				.withFaceDescriptor()
				.run()
				.then(res => {
					//console.log("--------> " + JSON.stringify(res));
					$(".btn-scan-face").click();
				});
			};
		})
	}
})