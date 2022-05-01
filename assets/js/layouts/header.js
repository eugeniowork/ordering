$(document).ready(function(){
    var is_loaded_cart_products = false;

    $(document).mouseup(function(e) {
        //FOR HEADER ACCOUNT DROPDOWN
        if ($(".header-btn-account").is(e.target) || $(".header-btn-account i").is(e.target)) {
            $('.header-dropdown-account').toggle();
            toggle_caret('.header-dropdown-account', '.header-btn-account')
        }
        else if (!$(".header-dropdown-account").is(e.target) && $(".header-dropdown-account").has(e.target).length === 0) {
            $('.header-dropdown-account').hide();
            toggle_caret('.header-dropdown-account', '.header-btn-account')
        }

        //FOR HEADER CHART DROPDOWN
        if($(".header-btn-cart").is(e.target) || $(".header-btn-cart i").is(e.target)){
            $(".header-dropdown-cart").toggle()
            if(!is_loaded_cart_products){
                get_cart_item();
            }
        }
        else{
            if($("#checkout_modal").has(e.target).length > 0){
                
            }
            else if($(".global-loading").has(e.target).length > 0){
                
            }
            else if (!$(".header-dropdown-cart").is(e.target) && $(".header-dropdown-cart").has(e.target).length === 0) {
                $(".header-dropdown-cart").hide();
            }
        }
        
    });

	function toggle_caret(dropdown, button_name) {
        if ($(dropdown).is(':visible')) {
            $(button_name+" .fa").removeClass("fa-caret-down")
            $(button_name+" .fa").addClass("fa-caret-up")
        }
        else {
            $(button_name+" .fa").removeClass("fa-caret-up")
            $(button_name+" .fa").addClass("fa-caret-down")
        }
    }

    get_cart_total_item();
    function get_cart_total_item(){
        $.ajax({
            url: base_url + "product/cartTotalItem",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                if(response.total > 0){
                    $('.span-cart-total-product').removeClass('d-none')
                    $('.span-cart-total-product').text(response.total)
                }
            },
            error: function(error){

            }
        })
    }

    //get_cart_item()
    function get_cart_item(){
        is_loaded_cart_products = true;
        createProcessLoading('.loading-cart-product-container', 'Loading cart products...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

        $(".cart-content").remove()
        $(".cart-footer").remove()

        $.ajax({
            url: base_url + "product/cartItemList",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                if(response.is_error){
                    createProcessError('.loading-cart-product-container', 'Unable to load cart products.', "30px", "15px");
                }
                else{
                    $('.loading-cart-product-container').empty();

                    if(response.products.length > 0){
                        var total_cart_product_amount = 0;
                        var cart_content = $('<div class="cart-content"></div>')
                        $.each(response.products, function(key, data){
                            var cart_product = $('<div class="cart-product '+data.encrypted_product_id+' "></div>')
                            var row_cart = $('<div class="row"></div>')
                            var quantity = parseInt(data.quantity) > parseInt(data.stock)? data.stock: data.quantity
                            var total_product_price = parseInt(quantity) * parseFloat(data.price);

                            total_cart_product_amount += total_product_price;
                            row_cart.append('<div class="col-12 col-lg-3"><img src="'+base_url+data.image_path+'"></div>')
                            row_cart.append('<div class="col-12 col-lg-5"><span>'+data.name+'</span></div>')
                            row_cart.append('<div class="col-12 col-lg-4">'+moneyConvertion(parseFloat(total_product_price))+'</div>')
                            row_cart.append('<div class="col-12 col-lg-12"><button class="btn-remove-to-cart" data-id="'+data.encrypted_product_id+'"><i class="fa fa-minus"></i></button><span class="cart-product-quantity">'+quantity+'</span><button class="btn-add-to-cart" data-id="'+data.encrypted_product_id+'"><i class="fa fa-plus"></i></button></div>')
                           
                            cart_product.append(row_cart)
                            cart_content.append(cart_product)
                            $(".header-dropdown-cart").append(cart_content)
                        })
                        var row_checkout = $('<div class="row cart-footer"></div>')
                        row_checkout.append('<div class="col-12 col-lg-5"><span>Total Amount</span></div>')
                        row_checkout.append('<div class="col-12 col-lg-7"><span class="bold-title pull-right">'+moneyConvertion(parseFloat(total_cart_product_amount))+'</span></div>')
                        row_checkout.append('<div class="col-12 col-lg-12"><button class="btn btn-success btn-checkout-cart" style="width: 100%">CHECKOUT</button></div>')
                        $(".header-dropdown-cart").append(row_checkout)
                    }
                    else{
                        $(".header-dropdown-cart").append("<span>No product(s) on cart yet.</span>")
                    }

                }
            },
            error: function(error){
                createProcessError('.loading-cart-product-container', 'Unable to load cart products.', "30px", "15px");
            }
        })
    }
    $(document).on("click", ".btn-add-to-cart", function(){
        var id = $(this).data("id");
        $.ajax({
            url: base_url + "product/addToCart",
            type: 'POST',
            dataType: 'json',
            data:{
                id: id,
            },
            success: function(response){
                if(response.is_error){
                    toastOptions(4000);
                    toastr.warning(response.error_msg);
                }
                else{
                    var cart_total_item = parseInt($('.span-cart-total-product').text());
                    cart_total_item++;
                    if(cart_total_item > 0){
                        $('.span-cart-total-product').removeClass('d-none')
                    }
                    $('.span-cart-total-product').text(cart_total_item)
                    get_cart_item();
                }
            },
            error: function(error){

            }
        })
    })

    $(document).on("click", ".btn-remove-to-cart", function(){
        var id = $(this).data("id");

        $.ajax({
            url: base_url + "product/removeToCart",
            type: 'POST',
            dataType: 'json',
            data:{
                id: id,
            },
            success: function(response){
                var cart_total_item = parseInt($('.span-cart-total-product').text());
                if(cart_total_item > 0){
                    $('.span-cart-total-product').removeClass('d-none')
                    cart_total_item--;
                }
                else{
                    $('.span-cart-total-product').addClass('d-none')
                    cart_total_item = 0;
                }
                $('.span-cart-total-product').text(cart_total_item)
                
                get_cart_item();
            },
            error: function(error){

            }
        })
    })

    
    $(document).on("click", ".btn-checkout-cart", function(){
        $("#checkout_modal").modal("show");
    })

    $(".btn-place-order").on("click", function(){
        var loading_checkout = false;
        $(".warning").html("")

        if(!loading_checkout){
            loading_checkout = true;

            $(".btn-place-order").prop("disabled", true).html("Placing order...")

            $(".global-loading").css({
                "display": "flex"
            })
            createProcessLoading('.global-loading', '<span style="color:white;">Placing order...</span>', base_url + 'assets/uploads/preloader/preloader_logo.gif', '80px', '80px', '24px')
            
            $.ajax({
                url: base_url + "product/checkOutCart",
                type: 'POST',
                dataType: 'json',
                data:{
                    date_pickup: $(".date-pickup").val()
                },
                success: function(response){
                    if(response.is_error){
                        loading_checkout = false;
                        $(".warning").html(response.error_msg)
                        $(".global-loading").css({
                            "display": "none"
                        })
                        
                        $(".btn-place-order").prop("disabled", false).html("Place Order")
                    }
                    else{
                        window.location.href = base_url + "my-orders"
                    }
                },
                error: function(error){
                    loading_checkout = false;
                    $(".warning").html("Unable to place order, please try again.")
                    $(".global-loading").css({
                        "display": "none"
                    })
                    
                    $(".btn-place-order").prop("disabled", false).html("Place Order")
                }
            })
        }
    })

    $(".btn-my-orders").on("click", function(){
        window.location.href = base_url + "my-orders";
    })
})