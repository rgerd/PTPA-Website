<?php
	$preview = true;

	$event = array(
		"title" => sanitize($_POST['event_title']),
		"event_date" => sanitize($_POST['event_date']),
		"description" => sanitize($_POST['event_desc'])
	);

	$tasks = array();

	$event_task_index = 0;
	while(true) {
		$v = 'event_task_'.$event_task_index;
		if(isset($_POST[$v])) {
			$title = sanitize($_POST[$v."_title"]);
			$slots = sanitize($_POST[$v."_slots"]);

			$task = array(
				"description" => $title,
				"numSlots" => $slots
			);
			array_push($tasks, $task);
		} else {
			break;
		}
		$event_task_index++;
	}

	$_SESSION['preview_data'] = $_POST;

	include "view/event.php";

	include "view/event_preview_footer.php";
?>