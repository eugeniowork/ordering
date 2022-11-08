//GLOBAL FUNCTIONS
function b64toBlob(b64Data, contentType, sliceSize) {
	contentType = contentType || '';
	sliceSize = sliceSize || 512;

	var byteCharacters = atob(b64Data);
	var byteArrays = [];

	for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
	    var slice = byteCharacters.slice(offset, offset + sliceSize);

	    var byteNumbers = new Array(slice.length);
	    for (var i = 0; i < slice.length; i++) {
	        byteNumbers[i] = slice.charCodeAt(i);
	    }

	    var byteArray = new Uint8Array(byteNumbers);

	    byteArrays.push(byteArray);
	}

	var blob = new Blob(byteArrays, {type: contentType});
	return blob;
}

function renderResponse(div, msg, status) {
    $(div).empty();
    $(div).append(
        '<div class="alert alert-' + status + ' alert-dismissible fade show">' +
        msg +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        '</div>'
    );
}

function renderResponseNotClosable(div,msg, status){
    $(div).empty();
    $(div).append(
        '<div class="alert alert-'+status+' alert-dismissible fade show">'+
        msg+
        '</div>'
    );
}

function createProcessLoading(div_name, loading_text, image_path, height, width, font_size) {
    $(div_name).empty();
    $(div_name).append(
        '<div class="d-flex flex-column justify-content-center align-items-center">' +
	        '<img class="process-loading-image" src=' + image_path + '></img>' +
	        '<p class="process-loading-text">' + loading_text + '</p>' +
        '</div>'
    );
    $('.process-loading-image').css({
        'height': height,
        'width': width
    })
    $('.process-loading-text').css({
        'font-size': font_size
    })
}

function createProcessLoadingV2(params) {
    var div_name = params.div_name? params.div_name: '';
    var loading_text = params.loading_text? params.loading_text: '';
    var height = params.height? params.height: '40px';
    var width = params.width? params.width: '40px';
    var font_size = params.font_size? params.font_size: '14px';
    var font_weight = params.font_weight? params.font_weight: 0;
    var position = params.position? params.position: 'center';

    $(div_name).empty();
    $(div_name).append(
        '<div class="d-flex flex-column justify-content-center align-items-'+position+'">' +
            '<img class="process-loading-image" src=' + base_url + 'assets/uploads/preloader/preloader_logo.gif' + '></img>' +
            '<p class="process-loading-text">' + loading_text + '</p>' +
        '</div>'
    );
    $('.process-loading-image').css({
        'height': height,
        'width': width
    })
    $('.process-loading-text').css({
        'font-size': font_size,
        'font-weight': font_weight
    })
}

function createProcessError(div_name, error_text, icon_size, text_size) {
    $(div_name).empty();
    $(div_name).append(
        '<div class="process-error">' +
        '<span class="process-error-icon"><i class="fa fa-exclamation-triangle"></i></span>' +
        '<span class="process-error-text">' + error_text + '</span>' +
        '</div>'
    );
    $('.process-error-icon').css({
        "font-size": icon_size
    })
    $('.process-error-text').css({
        "font-size": text_size
    })
}

function toastOptions(timer){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": 4000,
        "extendedTimeOut": timer,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
}

function moneyConvertion(amount, format = "PHP"){
    var formated_amount = (amount).toLocaleString('en-US', {
        style: 'currency',
        currency: format,
    });
    return formated_amount;
}