</body>
</html>
<script type="text/javascript">
	var base_url = '<?= base_url();?>';
	var session_user_id = '<?= $this->session->userdata('user_id');?>';
	var session_user_type = '<?= $this->session->userdata('user_type');?>';

	$(document).ready(function(){
		$(".btn-logout").on("click", function(){
			window.location.href = base_url + "dashboard/logout"
		})

		$('.select2').select2({ 
			width: '100%',
			allowClear: true,
			placeholder: 'Please select'
		});

		$(document).on('keydown',".float-only",function (e) {
			// for decimal pint
			if (e.keyCode == "190") {
				if ($(this).val().replace(/[0-9]/g, "") == ".") {
					return false;  
				}
			}

			// Allow: backspace, delete, tab, escape, enter , F5
			if ($.inArray(e.keyCode, [46,8, 9, 27, 13, 110,116,190]) !== -1 ||
				// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				// Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					// let it happen, don't do anything
					return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
	    });

	    $(document).on("paste",".float-only", function(){
	        return false;
	    });

	    $(".float-only").on('input', function(){
	        if ($(this).attr("maxlength") != 9){
	            if ($(this).val().length > 9){
	                $(this).val($(this).val().slice(0,-1));
	            }
	            $(this).attr("maxlength","9");
	        }

	    });
	})
</script>

<!-- FOR PRELOADER JS -->
<script type="text/javascript" src="<?= base_url();?>assets/js/preloader/preloader.js"></script>

