</body>
</html>

<!-- FOR PRELOADER JS -->
<script type="text/javascript" src="<?= base_url();?>assets/js/preloader/preloader.js"></script>

<script type="text/javascript">
	var base_url = '<?= base_url();?>'

	$(document).ready(function(){
		$(".btn-logout").on("click", function(){
			window.location.href = base_url + "dashboard/logout"
		})
	})

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
</script>