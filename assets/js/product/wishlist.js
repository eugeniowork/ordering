$(document).ready(function(){
	get_all_wishlist();
	function get_all_wishlist(){
		createProcessLoading('.process-loading-container', 'Loading...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
		$(".wishlist-content").hide()

		$.ajax({
			url: base_url + "product/wishlistData",
			type: 'GET',
			dataType: 'json',
			success: function(response){
				$('.process-loading-container').empty();
				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load wishlist', "30px", "15px");
				}
				else{
					$(".wishlist-content").show()
					$('.wishlist-table').DataTable({
						"data": response.wishlist,
						"columns": [
				            {"data":"fullname"},
				            {"data":"name"},
				            {"data":"stock"},
				            {"data":"price"},
						],
						"ordering": true,
					    "aaSorting": [],
					    "bDestroy": true
					})
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load wishlist.', "30px", "15px");
			}
		})
	}
});