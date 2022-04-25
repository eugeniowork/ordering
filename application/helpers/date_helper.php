<?php
	function getTimeStamp(){
		date_default_timezone_set("Asia/Manila");

    	$current_date_time = date('Y-m-d H:i:s');
    	return $current_date_time;
	}
?>