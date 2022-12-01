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
            else if($("#terms_for_order_modal").has(e.target).length > 0){
                
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

    var total_cart_product_amount = 0;
    //get_cart_item()
    function get_cart_item(){
        is_loaded_cart_products = true;
        createProcessLoading('.loading-cart-product-container', 'Loading cart products...', base_url + 'assets/uploads/preloader/preloader_logo.gif', '40px', '40px', '14px')

        $(".cart-content").remove()
        $(".cart-footer").remove()
        $(".cart-footer-points").remove();
        $(".cart-footer-terms").remove();
        total_cart_product_amount = 0;

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
                        var cart_content = $('<div class="cart-content"></div>')
                        $.each(response.products, function(key, data){
                            var cart_product = $('<div class="cart-product '+data.encrypted_product_id+' "></div>')

                            var quantity = parseInt(data.quantity) > parseInt(data.stock)? data.stock: data.quantity
                            var total_product_price = parseInt(quantity) * parseFloat(data.price);
                            total_cart_product_amount += total_product_price;

                            var flex_row = $('<div class="d-flex flex-row"></div>')
                            flex_row.append('<img src="'+base_url+data.image_path+'">')
                            flex_row.append('<div class="cart-product-details"><div class="cart-product-details-name">'+data.name+'</div><div class="cart-product-details-price">'+moneyConvertion(parseFloat(total_product_price))+'</span></div>')

                            var flex_row2 = $('<div class="d-flex flex-row"></div>')
                            flex_row2.append('<div class="cart-product-quantity"><button class="btn-remove-to-cart" data-id="'+data.encrypted_product_id+'"><i class="fa fa-minus"></i></button><span>'+quantity+'</span><button class="btn-add-to-cart" data-id="'+data.encrypted_product_id+'"><i class="fa fa-plus"></i></button></div>')
                            cart_product.append(flex_row)
                            cart_product.append(flex_row2)
                            cart_content.append(cart_product)
                            $(".header-dropdown-cart").append(cart_content)
                        })

                        var redeemable_points = response.points_balance;
                        if(redeemable_points > total_cart_product_amount){
                            redeemable_points = total_cart_product_amount;
                        }
                        if(redeemable_points > 0){
                            var cart_footer_points = $('<div class="cart-footer-points"></div>')
                            cart_footer_points.append('<div class="cart-footer-points-details"><span>Redeemable points is '+redeemable_points+' points</span><input style="position: relative;bottom: 20px;" type="range" min="0" max="'+redeemable_points+'" value="0" /></div>')
                            cart_footer_points.append('<div class="cart-footer-points-details"><span class="points-to-redeem-value"></span><button class="btn btn-sm btn-success btn-apply-redeem-points">Apply</button></div>')
                            $(".header-dropdown-cart").append(cart_footer_points)
                        }

                        $(".cart-footer").remove();
                        var cart_footer = $('<div class="cart-footer"></div>')
                        $(".header-dropdown-cart").append(cart_footer)
                        createProcessLoadingV2({"div_name": ".cart-footer", "loading_text": " ", "font_size": "13px", "font_weight": "600", "height": "30px", "width": "30px"});
                        calculate_total_payment();
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

    var points_redeem = 0;
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
                    date_pickup: $(".date-pickup").val(),
                    instruction: $(".instruction").val(),
                    points_redeem: points_redeem,
                    total_cart_product_amount: total_cart_product_amount,
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
                            var notification_data = $("<div class='notification-data'>");
                            var flex1 = $("<div class='d-flex flex-row'>");
                            flex1.append('<img src="'+data.customer_profile_path+'">')
                            flex1.append('<div class="notification-data-description"><span>'+data.content+'</span></div>')
                            notification_data.append(flex1)

                            var flex2 = $("<div class='d-flex flex-row'>");
                            flex2.append('<div class="notification-data-date"><span>'+data.created_date+'</span></div>')
                            notification_data.append(flex2);

                            $(".header-dropdown-notifications .notification-body .notification-list").append(notification_data)
                        });

                    }
                    else{
                        $(".header-dropdown-notifications .notification-body .notification-list").append("<center><span>No notification(s) yet.</span></center>")
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
                            var flex_row = $('<div class="d-flex flex-row"></div>')
                            flex_row.append('<img src="'+base_url+data.image_path+'">')
                            flex_row.append('<div class="wishlist-product-details"><div class="wishlist-product-details-name">'+data.name+'</div><div class="wishlist-product-details-price">'+moneyConvertion(parseFloat(data.price))+'</span></div>')

                            var flex_row2 = $('<div class="d-flex flex-row"></div>')
                            var buttons = '<button class="btn btn-danger btn-sm btn-remove-to-wishlist" data-id="'+data.encrypted_wishlist_id+'" title="Remove to wishlist"><i class="fas fa-trash-alt"></i></button>';
                            if(data.stock > 0){
                                buttons += '&nbsp;<button class="btn btn-success btn-sm btn-add-to-cart" data-id="'+data.encrypted_product_id+'" title="Add to cart"><i class="fas fa-cart-plus"></i></button>';
                            }
                            flex_row2.append('<div class="wishlist-product-stock"><div class="wishlist-product-stock-value"><span>Stock: '+data.stock+'</span></div><div class="wishlist-product-stock-buttons">'+buttons+'</div></div>')

                            // row_wishlist.append('<div class="col-12 col-lg-3 col-xs-3 col-md-3 col-sm-3"><img src="'+base_url+data.image_path+'"></div>')
                            // row_wishlist.append('<div class="col-12 col-lg-5 col-xs-5 col-md-5 col-sm-5"><span>'+data.name+'</span></div>')
                            // row_wishlist.append('<div class="col-12 col-lg-4 col-xs-4 col-md-4 col-sm-4">'+moneyConvertion(parseFloat(data.price))+'</div>')

                            // var row_wishlist2 = $('<div class="row"></div>')
                            // row_wishlist2.append('<div class="col-12 col-lg-6 col-xs-6 col-md-6 col-sm-6"><span class="wishlisth-product-stock">Stock: '+data.stock+'</span></div>')
                            // var row_wishlist2_buttons = $('<div class="col-12 col-lg-6 col-xs-6 col-md-6 col-sm-6 wishlist-buttons"></div>')
                            // if(data.stock > 0){
                            //     row_wishlist2_buttons.append('<button class="btn btn-success btn-sm btn-add-to-cart" data-id="'+data.encrypted_product_id+'" title="Add to cart"><i class="fas fa-cart-plus"></i></button>')
                            // }
                            // row_wishlist2_buttons.append('&nbsp;<button class="btn btn-danger btn-sm btn-remove-to-wishlist" data-id="'+data.encrypted_wishlist_id+'" title="Remove to wishlist"><i class="fas fa-trash-alt"></i></button>')
                            // row_wishlist2.append(row_wishlist2_buttons);

                            wishlist_product.append(flex_row)
                            wishlist_product.append(flex_row2)
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

    $(document).on('input', 'input[type=range]', function(e){
        var min = e.target.min,
        max = e.target.max,
        val = e.target.value;

        if(val > 0){
            $(".points-to-redeem-value").html("Redeem "+moneyConvertion(parseFloat(val)))
            $(".btn-apply-redeem-points").show();
        }
        else{
            $(".points-to-redeem-value").html("Redeem "+moneyConvertion(parseFloat(val)))
            if(points_redeem == 0){
                $(".btn-apply-redeem-points").hide();
            }
        }
        console.log(val)
        
        $(e.target).css({
            'backgroundSize': (val - min) * 100 / (max - min) + '% 100%'
        });
    }).trigger('input');

    $(document).on("click", ".btn-apply-redeem-points", function(){
        points_redeem = $('input[type=range]').val();
        console.log(points_redeem)

        if(points_redeem == 0){
            $(".points-to-redeem-value").html("")
            $(".btn-apply-redeem-points").hide();
        }

        $(".cart-footer").remove();
        var cart_footer = $('<div class="cart-footer"></div>')
        $(".header-dropdown-cart").append(cart_footer)
        createProcessLoadingV2({"div_name": ".cart-footer", "loading_text": " ", "font_size": "13px", "font_weight": "600", "height": "30px", "width": "30px"});
        calculate_total_payment();
    })

    function calculate_total_payment(){
        $(".cart-footer").remove();

        var amount = total_cart_product_amount - points_redeem;
        var cart_footer = $('<div class="cart-footer"></div>')
        var flex_row = $('<div class="d-flex flex-row"></div>')
        flex_row.append('<div class="cart-footer-details"><div class="cart-footer-details-label">Total Payment</div><div class="cart-footer-details-amount"><span class="bold-title">'+moneyConvertion(parseFloat(amount))+'</span></div></div>')
        cart_footer.append(flex_row)

        var flex_row2 = $('<div class="d-flex flex-row"></div>')
        flex_row2.append('<div class="cart-footer-button"><button class="btn btn-success btn-checkout-cart" style="width: 100%; cursor: not-allowed;" disabled>CHECKOUT</button></div>')
        cart_footer.append(flex_row2)
        $(".header-dropdown-cart").append(cart_footer)

        generate_terms_checkbox();
    }

    function generate_terms_checkbox(){
        $(".cart-footer-terms").remove();

        var cart_footer_points = $('<div class="cart-footer-terms"></div>')
        cart_footer_points.append('<div class="cart-footer-terms-details"><a class="btn-show-terms">View Terms and Condition</a></div>')
        cart_footer_points.append('<div class="cart-footer-terms-details" style="position: relative;bottom: 25px;"><span><input type="checkbox" class="i-agree-checkbox">&nbsp;&nbsp;<span>I agree to the terms and condition.</span></span></div>')
        $(".header-dropdown-cart").append(cart_footer_points)
    }

    $(document).on("click", ".btn-show-terms", function(){
        $("#terms_for_order_modal").modal("show")
    });

     $(document).on("change", ".i-agree-checkbox", function(){
        if($(this).is(":checked")){
            $('.btn-checkout-cart').prop('disabled',false)
            $('.btn-checkout-cart').css({
                'cursor': 'pointer'
            });
        }
        else{
            $('.btn-checkout-cart').prop('disabled',true)
            $('.btn-checkout-cart').css({
                'cursor': 'not-allowed'
            });
        }
    });
})