<?php
	$preview = true;

	$event = array(
		"title" => $_POST['event_title'],
		"event_date" => $_POST['event_date'],
		"description" => $_POST['event_desc']
	);

	$tasks = parse_tasks($_POST, HTML);

	$_SESSION['preview_data'] = $_POST;


	include "view/event.php";
	$footer = "view/event_preview_footer.php";