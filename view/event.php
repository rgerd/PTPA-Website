<?php 
	require("event_header.php");
	
	if(isset($event_success_message)):
?>
	<div id="event_success_message" class="success_message"><?php echo $event_success_message; ?></div>
<?php
	endif;


	if($volunteer_sign_in) {
		require("vol_sign_in.php");
	} else if($contact_creator) {
		require("contact_creator.php");
	} else if($volunteer_edit) {
		require("vol_edit.php");
	} else if(isset($task_id)) {
		require("task_sign_up.php");
	} else {
		require("event_tasks.php");
	}
?>