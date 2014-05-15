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


	$event_id = isset($_GET['e']) ? $_GET['e'] : -1;
	$event_id = $event_id == -1 ? (isset($_POST['event']) ? $_POST['event'] : -1) : $event_id;
	switch($action) {
		case "acc":
			$page = "view/account_manager.php";
		break;
		
		case "delete":
			partially_delete_event($event_id);
			$page = "view/home.php";
		break;
		
		case "reminders":
		break;
		
		case "prev":
		break;
		
		case "view_task_sign_up":
			$event_id = $_POST['event'];
			$task_id = $_POST['task'];
			$page = "view/task_sign_up.php";
		break;

		case "task_sign_up":
			$account_id = register_user(sanitize($_POST['fname']), sanitize($_POST['lname']), sanitize($_POST['email']), sanitize($_POST['phone']), ' ', 0);
			$task_id = $_POST['task'];

			if(isset($_POST['comment'])) {
				sign_up_for_task($task_id, $account_id, sanitize($_POST['comment']));
			} else {
				sign_up_for_task($task_id, $account_id);
			}

			$event = get_event($event_id);
			$page_title = $event['title'];
			$page = "view/event.php";
		break;

		case "save_event":
			$event_title = sanitize($_POST['event_title']);
			$event_date = sanitize($_POST['event_date']);
			$event_desc = sanitize($_POST['event_desc']);
			$event_id = add_event($user_id, $event_title, $event_date, $event_desc);
			$event_task_index = 0;
			while(true) {
				$v = 'event_task_'.$event_task_index;
				if(isset($_POST[$v])) {
					$title = sanitize($_POST[$v."_title"]);
					$slots = sanitize($_POST[$v."_slots"]);
					$comments = isset($_POST[$v."_comments"]) ? 1 : 0;
					add_task($event_id, $event_task_index, $title, $slots, $comments);
				} else {
					break;
				}
				$event_task_index++;
			}
		break;
		
		case "create_event":
			$page = "view/event_creator.php";
		break;
		
		case "none":
			if(isset($_GET['e'])) {
				$event_id = sanitize($_GET['e']);
				$event = get_event($event_id);
				$page_title = $event['title'];
				$page = "view/event.php";
			}
		break;
	}

	$page = isset($page) ? $page : "view/front.php";

	$page_title = "PT Volunteer";
?>
<?php include 'view/header.php'; ?>
<?php include "$page";?>
<?php include 'view/footer.php'; ?>
