$(document).ready(function(){

	$('.header-btn-account').on('click', function() {
		$('.header-dropdown-account').toggle();
        toggle_caret('.header-dropdown-account', this)
    })

    $(document).mouseup(function(e) {
    	var account_dropdown_container = $(".account-dropdown");
    	if (!account_dropdown_container.is(e.target) && account_dropdown_container.has(e.target).length === 0) {
    		$('.header-dropdown-account').hide();
	    	toggle_caret('.header-dropdown-account', '.header-btn-account')
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