<?php
	$preview = true;

	$event = array(
		"title" => sanitize($_POST['event_title']),
		"event_date" => sanitize($_POST['event_date']),
		"description" => sanitize($_POST['event_desc'])
	);

	$tasks = parse_tasks($_POST);

	$_SESSION['preview_data'] = $_POST;


	include "view/event.php";

	include "view/event_preview_footer.php";