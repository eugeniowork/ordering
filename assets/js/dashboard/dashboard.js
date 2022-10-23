$(document).ready(function(){
	var product_limit = 12;
	var product_limit_start = 0;
	var loading_load_more = false;
	var is_reached_product_end = false;

	get_products("search");
	function get_products(action){
		createProcessLoading('.process-loading-container', 'Getting products...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "product/productList",
			type: 'POST',
			dataType: 'json',
			data:{
				product_limit: product_limit,
				product_limit_start: product_limit_start,
				category: $(".category").val(),
				search_name: $(".input-search-name").val()
			},
			success: function(response){
				loading_load_more = false;
				$('.process-loading-container').empty();

				if(response.is_error){
					createProcessError('.process-loading-container', 'Unable to load products.', "30px", "15px");
				}
				else{
					if(response.products.length > 0){
						if(action == "search"){
							$('.products-container-row').empty();
						}
						display_product(response.products)
					}
					else{
						is_reached_product_end = true;
						if(action == "search"){
							$('.process-loading-container').html("No available product(s).");
						}
					}
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load products.', "30px", "15px");
			}
		})
	}

	get_category();
	function get_category(){
		$(".category").empty();
		$.ajax({
			url: base_url + "product/productCategoryList",
			type: 'POST',
			dataType: 'json',
			success: function(response){
				var category = $(".category")
				category.append('<option value="0" >No Category</option>')
				$.each(response.categories, function(key, data){
					category.append('<option value='+data.id+' >'+data.name+'</option>')
				})
			},
			error: function(error){

			}
		})
	}

	$(".btn-submit-filter").on("click", function(){
		$('.products-container-row').empty();
		is_reached_product_end = false;
		product_limit_start = 0;
		get_products("search");
	})

	$(".input-search-name").on("keyup", function(){
		setTimeout(function(){
			$('.products-container-row').empty();
			is_reached_product_end = false;
			product_limit_start = 0;
			get_products("search");
		},200)
	})

	//SCROLL FOR DESKTOP
	$(document).on("scroll", function() {
        scroll()
    });
    //SCROLL FOR MOBILE
    $(document).on("touchmove", function() {
        scroll()
    });

    function scroll(){
        if(!loading_load_more && !is_reached_product_end){
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
            	product_limit_start+=12;
				loading_load_more = true;
		       get_products("load_more")
		   	}
        }
    }

	function display_product(products){
		var products_container_row = $(".products-container-row");
		$.each(products, function(key, data){
			var col_lg_3 = $('<div class="col-12 col-lg-3"></div>')
			var item_container = $('<div class="item-container"></div>')
			var btn_add_to_wishlist_top_px = data.stock > 0? '43px': '10px';
			if(data.is_in_wishlist){
				item_container.append('<button class="btn btn-sm btn-primary" data-id="'+data.encrypted_id+'" style="position: absolute;z-index: 2;right: 36px; top: '+btn_add_to_wishlist_top_px+'"><i class="fa fa-heart active-on-wishlist"></i></button>')
			}
			else{
				item_container.append('<button class="btn btn-sm btn-primary btn-add-to-wishlist" title="Add to Wishlist" data-id="'+data.encrypted_id+'" style="position: absolute;z-index: 2;right: 36px; top: '+btn_add_to_wishlist_top_px+'"><i class="fa fa-heart fa-heart-'+data.encrypted_id+'"></i></button>')
			}
			
			if(data.stock > 0){
				if (session_user_type == "user") {
					item_container.append('<button class="btn btn-sm btn-success btn-add-to-cart" title="Add to Cart" data-id="'+data.encrypted_id+'" style="position: absolute;z-index: 2;right: 35px;"><i class="fa fa-plus-circle"></i></button>')
				}
			}
			else{
				item_container.append('<div class="out-of-stock"><span>Out of Stock</span></div>')
			}
			var opacity = data.stock > 0? 1: 0.4;
			
			item_container.append('<div class="row"><div class="col-12 col-lg-12 image-container"><img style="opacity:'+opacity+'" src="'+base_url+data.image_path+'"></div></div><br>')
			item_container.append('<div class="row product-name-container"><div class="col-12 col-lg-12"><strong>'+data.name+'</strong></div></div>')
			item_container.append('<div class="row product-category-container"><div class="col-12 col-lg-12"><small>'+data.category_name+'</small></div></div>')
			item_container.append('<div class="row additional-product-details-container"><div class="col-12 col-lg-6">'+moneyConvertion(parseFloat(data.price))+'</div><div class="col-12 col-lg-6">Stock: '+data.stock+'</div></div>')
			
			col_lg_3.append(item_container)
			products_container_row.append(col_lg_3)
		})
	}
})