$(document).ready(function(){
	var webcam_element = document.getElementById('webcam');
	var webcam = new Webcam(webcam_element, 'user');
	var model_path = base_url+'assets/uploads/face_recognition_models';
	var display_size, face_detection, canvas, face_descriptor, face_value, face_value_base64;

	$(".btn-open-camera").on("click", function(){

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

	$("input[name=email]").on("keyup keypress change", function(){
		$(".email-warning").html("");
		$.ajax({
			url: base_url + "signup/checkEmail",
			type: 'POST',
			dataType: 'json',
			data:{
				email: $(this).val(),
			},
			success: function(response){
				console.log(response.is_exist)
				if(response.is_exist){
					$(".email-warning").html("Email already exist.")
					console.log("here")
				}
				else{
					$(".email-warning").html("");
				}
			},
			error: function(error){

			}
		})
	})

	$(".btn-submit-face").on("click", function(){
		webcam = new Webcam(webcam_element, 'user', canvas);
		let picture = webcam.snap();
		$("#face_modal").modal("hide")
		
		face_value = face_descriptor
		face_value_base64 = picture
		$("#img_face").attr('src', picture)
	})

	var loading_save_registration = false;
	$(".btn-save-registration").on("click", function(){
		if(!loading_save_registration){
			loading_save_registration = true;
		
			var fd = new FormData($("#form")[0])
			$(".btn-save-registration").prop("disabled", true).html("Saving...")

			if(face_value){
				var block = face_value_base64.split(";");
				var content_type = block[0].split(":")[1];
				var real_data = block[1].split(",")[1];
				var blob = b64toBlob(real_data, content_type);

				fd.append('face_value', JSON.stringify(face_value))
				fd.append('face_image', blob)
			}

			$.ajax({
				url: base_url + "signup/signupV2Save",
				type: 'POST',
				dataType: 'json',
				data: fd,
				contentType: false,
			    cache: false,
			   	processData:false,
			    success: function(response){
			    	$(".btn-save-registration").prop("disabled", false).html("Save")
			    	if(response.is_error){
			    		$("#warning_modal").modal("show");
			    		renderResponseNotClosable('#warning_modal .modal-body',response.error_msg, "danger")
			    		loading_save_registration = false;
			    	}
			    	else{
			    		window.location.href = base_url + "verify-account/"+response.encrypted_user_id
			    	}
			    },
			    error: function(error){
			    	$(".btn-save-registration").prop("disabled", false).html("Save")
			    	loading_save_registration = false;
			    }
			})
		}
	})

	$('input').on('keypress',function(e) {
        if(e.which == 13) {
            $(".btn-save-registration").click();
        }
    });
})