<?php 
	require("event_header.php");
	if($volunteer_sign_in) {
		require("vol_sign_in.php");
	} else if($volunteer_edit) {
		require("vol_edit.php");
	} else if(isset($task_id)) {
		require("task_sign_up.php");
	} else {
		require("event_tasks.php");
	}
?>