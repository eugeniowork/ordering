$(document).ready(function(){
    $(document).mouseup(function(e) {
        //FOR HEADER ACCOUNT DROPDOWN
        if ($(".header-btn-account").is(e.target)) {
            $('.header-dropdown-account').toggle();
            toggle_caret('.header-dropdown-account', '.header-btn-account')
        }
        else if (!$(".header-dropdown-account").is(e.target) && $(".header-dropdown-account").has(e.target).length === 0) {
            $('.header-dropdown-account').hide();
            toggle_caret('.header-dropdown-account', '.header-btn-account')
        }

        //FOR HEADER CHART DROPDOWN
        if($(".header-btn-cart").is(e.target)){
            $(".header-dropdown-cart").toggle()
        }
        else if (!$(".header-dropdown-cart").is(e.target) && $(".header-dropdown-cart").has(e.target).length === 0) {
            $(".header-dropdown-cart").hide();
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
})