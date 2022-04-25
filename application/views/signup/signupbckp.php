<div class="page-container">
	<div class="container-header">
		<span class="header-title">SIGN UP</span><br>
		<div class="buttons">
            <button class="btn btn-sm btn-primary save-create-user">Save</button>
        </div>
	</div>
	<div class="container-body">
		<div class="basic-info-container">
            <span style="font-size: 20px; font-weight:bold;">Basic Information</span>
            <div class="row">
                <div class="col-12 col-lg-3">
                    <span>Lastname <span class="text-danger">*</span></span>
                    <input type="text" class="form-control lastname text-only" placeholder="Enter lastname" />
                </div>
                <div class="col-12 col-lg-3">
                    <span>Firstname <span class="text-danger">*</span></span>
                    <input type="text" class="form-control firstname text-only" placeholder="Enter firstname" />
                </div>
                <div class="col-12 col-lg-3">
                    <span>Middlename</span>
                    <input type="text" class="form-control middlename text-only" placeholder="Enter middlename" />
                </div>
                
            </div>
        </div>
        <div class="credential-container">
        	<span style="font-size: 20px; font-weight:bold;">Credential</span>
            <div class="row">
				<div class="col-12 col-lg-3">
	                <span>Email Address<span class="text-danger">*</span></span>
	                <input type="text" class="form-control email" placeholder="Enter email" />
	            </div>
	            <div class="col-12 col-lg-3">
	                <span>Password<span class="text-danger">*</span></span>
	                <input type="password" class="form-control password" placeholder="Enter password" />
	            </div>
	            <div class="col-12 col-lg-3">
	                <span>Confirm Password<span class="text-danger">*</span></span>
	                <input type="password" class="form-control password" placeholder="Enter password" />
	            </div>
	        </div>
		</div>
		<div class="face-container">
			<span style="font-size: 20px; font-weight:bold;">Fa</span>
			<main>
            <div class="container mt-1">
                <div class="row">
                    <div class="col-12 col-md-4 col-xl-3 align-top">
                        <div class="row mb-3">
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch">
                                        <input type="checkbox" id="webcam-switch">
                                        <i></i> Webcam </label>  
                                        <button id="cameraFlip" class="btn d-none"></button>     
                                </div> 
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch disabled">
                                        <input type="checkbox" disabled id="detection-switch">
                                        <i></i> Detect Face </label>      
                                </div>   
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch disabled">
                                        <input type="checkbox" disabled id="box-switch">
                                        <i></i> Bounding Box </label>      
                                </div>
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch disabled">
                                        <input type="checkbox" disabled id="landmarks-switch">
                                        <i></i> Landmarks </label>      
                                </div>
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch disabled">
                                        <input type="checkbox" disabled id="expression-switch">
                                        <i></i> Expression </label>      
                                </div>    
                                <div class="col-md-10 col-6 form-control">
                                        <label class="form-switch disabled">
                                        <input type="checkbox" disabled id="age-gender-switch">
                                        <i></i> Age & Gender </label>      
                                </div>      
                                <div class="col-md-10 col-6 mt-2">
                                     More on  <a href="https://bensonruan.com" target="_blank">bensonruan.com</a>    
                                </div>               
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-9 align-top" id="webcam-container">
                        <div class="loading d-none">
                                Loading Model
                                <div class="spinner-border" role="status">
                                        <span class="sr-only"></span>
                                </div>
                        </div>
                        
                        <div id="video-container">
                                <video id="webcam" autoplay muted playsinline></video>
                        </div>  
                        <div id="errorMsg" class="col-12 alert-danger d-none">
                        Fail to start camera <br>
                        1. Please allow permission to access camera. <br>
                        2. If you are browsing through social media built in browsers, look for the ... or browser icon on the right top/bottom corner, and open the page in Sarafi (iPhone)/ Chrome (Android)
                        </div>
                    </div>
                </div>
            </div>
        </main>   
		</div>

		<button class="btn-save">Save Face</button>
		<button class="btn-save2">Save Face2</button>
		<button class="btn-compare">Compare</button>

		<img id="myImg1" src="https://cdn.nba.com/headshots/nba/latest/1040x760/2544.png" />
        <img id="myImg2" src="https://deseret.brightspotcdn.com/dims4/default/c0b8f62/2147483647/strip/true/crop/1200x800+0+0/resize/840x560!/quality/90/?url=https%3A%2F%2Fcdn.vox-cdn.com%2Fthumbor%2FmD0y8VqnowSS9PBFjREbEBVlemM%3D%2F0x0%3A1200x800%2F1200x800%2Ffilters%3Afocal%28600x400%3A601x401%29%2Fcdn.vox-cdn.com%2Fuploads%2Fchorus_asset%2Ffile%2F17884774%2F1634809.jpg" />
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/register/register.js"></script>
<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/external/face-api.min.js"></script>

<script type="text/javascript">
	
	
	$(document).ready(function(){


		const webcamElement = document.getElementById('webcam');
const webcam = new Webcam(webcamElement, 'user');
const modelPath = '<?= base_url();?>assets/uploads/models';
let currentStream;
let displaySize;
let convas;
let faceDetection;

$("#webcam-switch").change(function () {
  if(this.checked){
      webcam.start()
          .then(result =>{
             cameraStarted();
             webcamElement.style.transform = "";
             console.log("webcam started");
          })
          .catch(err => {
              displayError();
          });
  }
  else {        
      cameraStopped();
      webcam.stop();
      console.log("webcam stopped");
  }        
});

$('#cameraFlip').click(function() {
    webcam.flip();
    webcam.start()
    .then(result =>{ 
      webcamElement.style.transform = "";
    });
});

$("#webcam").bind("loadedmetadata", function () {
  displaySize = { width:this.scrollWidth, height: this.scrollHeight }
});

$("#detection-switch").change(function () {
  if(this.checked){
    toggleContrl("box-switch", true);
    toggleContrl("landmarks-switch", true);
    toggleContrl("expression-switch", true);
    toggleContrl("age-gender-switch", true);
    $("#box-switch").prop('checked', true);
    $(".loading").removeClass('d-none');
    Promise.all([
      faceapi.nets.tinyFaceDetector.load(modelPath),
      faceapi.nets.faceLandmark68TinyNet.load(modelPath),
      faceapi.nets.faceRecognitionNet.load(modelPath),
      faceapi.nets.faceExpressionNet.load(modelPath),
      faceapi.nets.ageGenderNet.load(modelPath)
    ]).then(function(){
      createCanvas();
      startDetection();
    })
  }
  else {
    clearInterval(faceDetection);
    toggleContrl("box-switch", false);
    toggleContrl("landmarks-switch", false);
    toggleContrl("expression-switch", false);
    toggleContrl("age-gender-switch", false);
    if(typeof canvas !== "undefined"){
      setTimeout(function() {
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
      }, 1000);
    }
  }        
});

function createCanvas(){
  if( document.getElementsByTagName("canvas").length == 0 )
  {
    canvas = faceapi.createCanvasFromMedia(webcamElement)
    document.getElementById('webcam-container').append(canvas)
    faceapi.matchDimensions(canvas, displaySize)
  }
}

function toggleContrl(id, show){
  if(show){
    $("#"+id).prop('disabled', false);
    $("#"+id).parent().removeClass('disabled');
  }else{
    $("#"+id).prop('checked', false).change();
    $("#"+id).prop('disabled', true);
    $("#"+id).parent().addClass('disabled');
  }
}
var face_one;

var face_two;

let encoding = {};
		let vecEnco = [];

function startDetection(){
  faceDetection = setInterval(async () => {
    const detections = await faceapi.detectSingleFace(webcamElement, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks(true).withFaceDescriptor()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    if($("#box-switch").is(":checked")){
      faceapi.draw.drawDetections(canvas, resizedDetections)
    }
    if($("#landmarks-switch").is(":checked")){
      faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    }
    if($("#expression-switch").is(":checked")){
      faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
    }
    if($("#age-gender-switch").is(":checked")){
      resizedDetections.forEach(result => {
        const { age, gender, genderProbability } = result
        new faceapi.draw.DrawTextField(
          [
            `${faceapi.round(age, 0)} years`,
            `${gender} (${faceapi.round(genderProbability)})`
          ],
          result.detection.box.bottomRight
        ).draw(canvas)
      })
    }
    if (detections) {
		

		// for (var i = 0; i < detections.descriptor.length; i++)
		// 	vecEnco.push(detections.descriptor[i]);

		// encoding.Encoding = "[" + vecEnco.toString() + "]";

		
	}
    vecEnco = detections.descriptor
    if(!$(".loading").hasClass('d-none')){
      $(".loading").addClass('d-none')
    }
  }, 300)
}

$(".btn-save").on("click", function(){
		face_one = vecEnco
		console.log(face_one)
})
$(".btn-save2").on("click", function(){
		face_two = vecEnco
		console.log(face_two)
})
$(".btn-compare").on("click", function(){
	const distance = faceapi.euclideanDistance(face_one, face_two);
    console.log(distance)
    if(distance < 0.4){
    	alert("match")
    }

})
function cameraStarted(){
  toggleContrl("detection-switch", true);
  $("#errorMsg").addClass("d-none");
  if( webcam.webcamList.length > 1){
    $("#cameraFlip").removeClass('d-none');
  }
}

function cameraStopped(){
  toggleContrl("detection-switch", false);
  $("#errorMsg").addClass("d-none");
  $("#cameraFlip").addClass('d-none');
}

function displayError(err = ''){
  if(err!=''){
      $("#errorMsg").html(err);
  }
  $("#errorMsg").removeClass("d-none");
}
	})
</script>