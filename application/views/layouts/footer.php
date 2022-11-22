
<!-- <div class="alert text-center cookiealert" role="alert">
    <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        I agree
    </button>
</div> -->

<div class="cookies-container">
	<div class="d-flex justify-content-center mt-5 h-100">
	    <div class="d-flex align-items-center align-self-center card p-3 text-center cookies">
	    	<span style="font-size: 30px;">&#x1F36A;</span>
	    	<span class="mt-2">This website uses cookies and similar technologies (together "cookies") that are essential for the operations of this website and its core functions. Other cookies will only be placed with your consent.</span>
	    	<a class="d-flex align-items-center" href="https://cookiesandyou.com/" target="_blank">Learn more<i class="fa fa-angle-right ml-2"></i></a>
	    	<button class="btn btn-primary mt-3 px-4 btn-accept-cookies" type="button">Okay</button>
	    </div>
	</div>
</div>

<footer class="footer">
	<br/>
	<div class="row m-0">
		<div class="col-sm-8">
			<div class="row">
				<div class="col-12 col-sm-10"><strong>COMPANY</strong></div>
			</div>
			<a href="<?= base_url(); ?>company/about-us" class="about">About Us</a><br/>
			<a href="<?= base_url(); ?>company/terms-and-condition">Terms and Condition</a>
		</div>
		<div class="col-sm-4">
			<div class="row">
				<div class="col-12 col-sm-10"><strong>FOLLOW US</strong></div>
			</div>
			<a href="https://facebook.com" target="_blank" class="social-media facebook fab fa-facebook-f"></a>
			<a href="https://instagram.com" target="_blank" class="social-media instagram fab fa-instagram"></a>
			<a href="https://twitter.com" target="_blank" class="social-media twitter fab fa-twitter"></a>
			<a href="https://linkedin.com" target="_blank" class="social-media linkedin fab fa-linkedin"></a>
		</div>
	</div>
	<br/>
	<div class="footer-all-rights-container">© <?= date('Y').' '.APPNAME; ?>. All rights reserved.</div>
</footer>
</body>
</html>

<script type="text/javascript" src="<?= base_url();?>assets/js/layouts/cookie.js"></script>

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
			height: '100%',
			allowClear: true,
			placeholder: 'Please select'
		});

		$(document).on('keydown',".float-only",function (e) {
			if (e.keyCode == "190") {
				if ($(this).val().replace(/[0-9]/g, "") == ".") {
					return false;  
				}
			}

			if ($.inArray(e.keyCode, [46,8, 9, 27, 13, 110,116,190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
				return;
			}
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
	    });

	    $(document).on("paste",".float-only", function(){
	        return false;
	    });

	    // $(".float-only").on('input', function(){
	    //     if ($(this).attr("maxlength") != 9){
	    //         if ($(this).val().length > 9){
	    //             $(this).val($(this).val().slice(0,-1));
	    //         }
	    //         $(this).attr("maxlength","9");
	    //     }

	    // });
	})
</script>

<!-- FOR PRELOADER JS -->
<script type="text/javascript" src="<?= base_url();?>assets/js/preloader/preloader.js"></script>

