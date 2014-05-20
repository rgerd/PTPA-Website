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

		case "preview_save":
			//print_r($_SESSION['preview_data']);
			save_event($_SESSION['preview_data']);
		break;

		case "Save":
			save_event($_POST);
		break;

		case "Preview":
			$page = "view/event_preview.php";
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
