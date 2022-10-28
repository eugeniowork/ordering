$(document).ready(function(){
    var is_loaded_cart_products = false;
    var is_loaded_notifications = false;
    var is_loaded_wish_list = false;

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

        //FOR WISHLIST DROPDOWN
        if ($(".header-btn-wishlist").is(e.target) || $(".header-btn-wishlist i").is(e.target)) {
            $('.header-dropdown-wishlist').toggle();
            if(!is_loaded_wish_list){
                get_wishlist();
            }
        }
        else if (!$(".header-dropdown-wishlist").is(e.target) && $(".header-dropdown-wishlist").has(e.target).length === 0) {
            $('.header-dropdown-wishlist').hide();
        }

        //FOR NOTIFICATIONS DROPDOWN
        if ($(".header-btn-notifications").is(e.target) || $(".header-btn-notifications i").is(e.target) || $(".header-btn-notifications span").is(e.target)) {
            $('.header-dropdown-notifications').toggle();
            if(!is_loaded_notifications){
                get_nofitications();
                read_notifications();
            }
        }
        else if (!$(".header-dropdown-notifications").is(e.target) && $(".header-dropdown-notifications").has(e.target).length === 0) {
            $('.header-dropdown-notifications').hide();
        }
        
        if($(".btn-toggle-menu").is(e.target) || $(".btn-toggle-menu i").is(e.target)){
            $(".side-navbar-container").toggle("slide", { direction: "left" }, 1000);
            $(".btn-show-menu").toggle();
        }
        else if (!$(".side-navbar-container").is(e.target) && $(".side-navbar-container").has(e.target).length === 0) {
            $(".side-navbar-container").hide("slide", { direction: "left" }, 1000);
            $(".btn-show-menu").show();
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

    if(session_user_type == "user"){
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

        get_wishlist_total_item();
        function get_wishlist_total_item(){
            $.ajax({
                url: base_url + "product/wishListTotalItem",
                type: 'POST',
                dataType: 'json',
                data:{},
                success: function(response){
                    if(response.total > 0){
                        $('.span-wishlist-total-product').removeClass('d-none')
                        $('.span-wishlist-total-product').text(response.total)
                    }
                },
                error: function(error){

                }
            })
        }
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
                if(cart_total_item > 1){
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

    $(".btn-my-profile").on("click", function(){
        window.location.href = base_url + "my-profile";
    })

    $(".btn-change-password").on("click", function(){
        window.location.href = base_url + "change-my-password";
    })

    $(".btn-activity-log").on("click", function(){
        window.location.href = base_url + "user-activity-log";
    })

    get_total_unread_notifications();
    function get_total_unread_notifications(){
        $.ajax({
            url: base_url + "notification/totalUnreadNotifications",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                if(response.notifications > 0){
                    $('.span-total-notif').removeClass('d-none')
                    $('.span-total-notif').text(response.notifications)
                }
            },
            error: function(error){

            }
        })
    }


    function get_nofitications(){
        is_loaded_notifications = true;
        createProcessLoading('.loading-notifications-container', 'Loading notifcations...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')
        //$(".notification-content-body").empty();
        $(".header-dropdown-notifications .notification-body .notification-list").empty();

        $.ajax({
            url: base_url + "notification/getNotifications",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                if(response.is_error){
                    createProcessError('.loading-notifications-container', 'Unable to load notifications.', "30px", "15px");
                }
                else{
                    $(".loading-notifications-container").empty();

                    if(response.notifications.length > 0){
                        $.each(response.notifications, function(key, data) {
                            // var row = $("<div class='row'>")
                            // row.append('<div class="col-12 col-lg-2"><img src="'+data.customer_profile_path+'"></div>')
                            // row.append('<div class="col-12 col-lg-10"><span class="description">'+data.content+'</span></div>')
                            // row.append('<div class="col-12 col-lg-2"></div>');
                            // row.append('<div class="col-12 col-lg-10 date"><span>'+data.created_date+'</span></div>')

                            var append = "";
                            append += '<div class="notification-data">'
                                append += '<div class="d-flex flex-row">'
                                    append += '<img src="'+data.customer_profile_path+'">'
                                    append += '<div class="notification-data-description">'
                                        append += '<span>'+data.content+'</span>'
                                    append += '</div>'
                                append += '</div>'

                                append += '<div class="d-flex flex-row">'
                                    append += '<div class="notification-data-date">'
                                        append += '<span>'+data.created_date+'</span>'
                                    append += '</div>'
                                append += '</div>'
                            append += '</div>';

                            $(".header-dropdown-notifications .notification-body .notification-list").append(append)
                        });

                    }
                    else{
                        $(".notification-content-body").append("<span>No notification(s) yet.</span>")
                    }
                }
            },
            error: function(error){
                createProcessError('.loading-notifications-container', 'Unable to load notifications.', "30px", "15px");
            }
        })
    }

    function read_notifications(){
        $.ajax({
            url: base_url + "notification/readNotifications",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                $('.span-total-notif').addClass('d-none')
                $('.span-total-notif').text(0)
            },
            error: function(error){
            }
        })
    }

    //GET WISHLIST
    function get_wishlist(){
        is_loaded_wish_list = true;
        createProcessLoading('.loading-wishlist-container', 'Loading wish list...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

        $(".wishlist-content").remove()

        $.ajax({
            url: base_url + "product/wishListItem",
            type: 'POST',
            dataType: 'json',
            data:{},
            success: function(response){
                if(response.is_error){
                    createProcessError('.loading-wishlist-container', 'Unable to load wish list.', "30px", "15px");
                }
                else{
                    $('.loading-wishlist-container').empty();

                    if(response.wishlist.length > 0){
                        var wishlist_content = $('<div class="wishlist-content"></div>')
                        $.each(response.wishlist, function(key, data){
                            var wishlist_product = $('<div class="wishlist-product '+data.encrypted_product_id+' "></div>')
                            var row_wishlist = $('<div class="row"></div>')

                            row_wishlist.append('<div class="col-12 col-lg-3"><img src="'+base_url+data.image_path+'"></div>')
                            row_wishlist.append('<div class="col-12 col-lg-5"><span>'+data.name+'</span></div>')
                            row_wishlist.append('<div class="col-12 col-lg-4">'+moneyConvertion(parseFloat(data.price))+'</div>')

                            var row_wishlist2 = $('<div class="row"></div>')
                            row_wishlist2.append('<div class="col-12 col-lg-6"><span class="wishlisth-product-stock">Stock: '+data.stock+'</span></div>')
                            var row_wishlist2_buttons = $('<div class="col-12 col-lg-6 wishlist-buttons"></div>')
                            if(data.stock > 0){
                                row_wishlist2_buttons.append('<button class="btn btn-success btn-sm btn-add-to-cart" data-id="'+data.encrypted_product_id+'" title="Add to cart"><i class="fas fa-cart-plus"></i></button>')
                            }
                            row_wishlist2_buttons.append('&nbsp;<button class="btn btn-danger btn-sm btn-remove-to-wishlist" data-id="'+data.encrypted_wishlist_id+'" title="Remove to wishlist"><i class="fas fa-trash-alt"></i></button>')
                            row_wishlist2.append(row_wishlist2_buttons);

                            wishlist_product.append(row_wishlist)
                            wishlist_product.append(row_wishlist2)
                            wishlist_content.append(wishlist_product)
                            wishlist_content.append('<hr>')

                            $(".header-dropdown-wishlist").append(wishlist_content)
                        })
                    }
                    else{
                        $(".header-dropdown-wishlist").append("<span>No item(s) on wishlist yet.</span>")
                    }

                }
            },
            error: function(error){
                createProcessError('.loading-wishlist-container', 'Unable to load wish list.', "30px", "15px");
            }
        })
    }

    $(document).on("click", ".btn-remove-to-wishlist", function(e){
        var id = $(this).data("id");

        $.ajax({
            url: base_url + "product/removeToWishList",
            type: 'POST',
            dataType: 'json',
            data:{
                id: id,
            },
            success: function(response){
                var wishlist_total_item = parseInt($('.span-wishlist-total-product').text());
                if(wishlist_total_item > 1){
                    $('.span-wishlist-total-product').removeClass('d-none')
                    wishlist_total_item--;
                }
                else{
                    $('.span-wishlist-total-product').addClass('d-none')
                    wishlist_total_item = 0;
                }
                $('.span-wishlist-total-product').text(wishlist_total_item)

                get_wishlist();
            },
            error: function(error){

            }
        })
    });

    $(document).on("click", ".btn-add-to-wishlist", function(){
        var id = $(this).data("id");
        $.ajax({
            url: base_url + "product/addToWishList",
            type: 'POST',
            dataType: 'json',
            data:{
                id: id,
            },
            beforeSend: function(){
                $(".fa-heart-"+id).addClass("active-on-wishlist")
            },
            success: function(response){
                if(!response.success){
                    toastOptions(4000);
                    toastr.warning(response.error_msg);
                }
                else{
                    var wishlist_total_item = parseInt($('.span-wishlist-total-product').text());
                    wishlist_total_item++;
                    if(wishlist_total_item > 0){
                        $('.span-wishlist-total-product').removeClass('d-none')
                    }
                    $('.span-wishlist-total-product').text(wishlist_total_item)
                    get_wishlist();
                }
            },
            error: function(error){

            }
        })
    })
})