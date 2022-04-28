$(document).ready(function(){
	var product_limit = 12;
	var product_limit_start = 0;
	var loading_load_more = false;
	var is_reached_product_end = false;

	get_products();
	function get_products(){
		createProcessLoading('.process-loading-container', 'Getting products...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

		$.ajax({
			url: base_url + "product/productList",
			type: 'POST',
			dataType: 'json',
			data:{
				product_limit: product_limit,
				product_limit_start: product_limit_start,
			},
			success: function(response){
				loading_load_more = false;
				$('.process-loading-container').empty();

				if(response.is_error){
					alert("error")
				}
				else{
					if(response.products.length > 0){
						display_product(response.products)
					}
					else{
						is_reached_product_end = true;
					}
				}
			},
			error: function(error){
				createProcessError('.process-loading-container', 'Unable to load products.', "30px", "15px");
			}
		})
	}

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
		       get_products()
		   	}
        }
    }

	function display_product(products){
		var products_container_row = $(".products-container-row");
		$.each(products, function(key, data){
			var col_lg_3 = $('<div class="col-12 col-lg-3"></div>')
			var item_container = $('<div class="item-container"></div>')
			item_container.append('<button class="btn btn-sm btn-success" style="position: absolute;z-index: 2;right: 35px;"><i class="fa fa-plus-circle"></i></button>')
			item_container.append('<div class="row"><div class="col-12 col-lg-12 image-container"><img src="'+base_url+data.image_path+'"></div></div>')
			item_container.append('<div class="row product-name-container"><div class="col-12 col-lg-12"><strong>'+data.name+'</strong></div></div>')
			item_container.append('<div class="row additional-product-details-container"><div class="col-12 col-lg-6"><span>&#8369;&nbsp;</span>'+data.price+'</div><div class="col-12 col-lg-6">'+data.stock+'</div></div>')
			
			col_lg_3.append(item_container)
			products_container_row.append(col_lg_3)
		})
	}
})