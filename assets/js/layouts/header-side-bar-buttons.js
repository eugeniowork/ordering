$(document).ready(function(){
	$(".btn-menu").on("click", function(e){
		var sub_menu_name = $(this).data("id");
		var button_id = e.target.id;
		if($("#"+sub_menu_name).is(":visible")){
			$("#"+sub_menu_name).slideToggle('fast')
			$("#"+button_id+" .caret").addClass("fa-caret-down")
            $("#"+button_id+" .caret").removeClass("fa-caret-up")
		}
		else{
			$("#"+sub_menu_name).slideToggle('fast')
			$("#"+button_id+" .caret").removeClass("fa-caret-down")
            $("#"+button_id+" .caret").addClass("fa-caret-up")
		}
		console.log(this)
	})
})