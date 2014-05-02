<?php
	session_start();
	include "model/database.php";
	include "model/mysql.php";
	include "model/cookie.php";
	$action = isset($_POST['action']) ? $_POST['action'] : "none";
	$action = isset($_GET['a']) ? $_GET['a'] : $action;
	include "model/registration.php";

	if($action == "sign_out")
		clear_cookie_for_user();

	$user_id = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : -1;
	
	if($user_id != -1)
		$page = "view/home.php";

	if(isset($_GET['e'])) {
		$event_id = $_GET['e'];
		$event = get_event($event_id);
		$page_title = $event['title'];
		$page = "view/event.php";
	}

	if($action == "save_event") {
		$event_id = add_event($user_id, $_POST['event_title'], $_POST['event_date'], $_POST['event_desc']);
		$event_task_index = 0;
		while(true) {
			$v = 'event_task_'.$event_task_index;
			if(isset($_POST[$v])) {
				$title = $_POST["$v_title"];
				$slots = $_POST["$v_slots"];
				$comments = isset($_POST["$v_comments"]) ? 1 : 0;
				add_task($event_id, $event_task_index, $title, $slots, $comments);
			}
			$event_task_index++;
		}
	}

	if($action == "task_sign_up") {
		$event_id = $_POST['event'];
		$task_id = $_POST['task'];

		$page = "view/task_sign_up.php";
	}

	$page = isset($page) ? $page : "view/front.php";

	$page_title = "PT Volunteer";

	$page = "view/event_creator.php";
?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
