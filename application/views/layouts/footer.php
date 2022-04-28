</body>
</html>
<script type="text/javascript">
	var base_url = '<?= base_url();?>'
	$(document).ready(function(){
		$(".btn-logout").on("click", function(){
			window.location.href = base_url + "dashboard/logout"
		})
	})
</script>

<!-- FOR PRELOADER JS -->
<script type="text/javascript" src="<?= base_url();?>assets/js/preloader/preloader.js"></script>

