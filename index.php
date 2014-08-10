<?php
session_start();
include "model/database.php";
include "model/mysql.php";
include "model/cookie.php";
$action = isset($_POST['action']) ? $_POST['action'] : "none";
$action = isset($_GET['a']) ? $_GET['a'] : $action;
include "model/registration.php";
include "model/event_handler.php";

if($action == "sign_out")
	clear_cookie_for_user();	

$user_id = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : -1;
if($user_id != -1)
	$page = "view/home.php";

//unset($_SESSION['VOL_ID']);
$volunteer_id = isset($_SESSION['VOL_ID']) ? $_SESSION['VOL_ID'] : -1;
if($volunteer_id != -1)
	$volunteer = get_user($volunteer_id);

$event_id = isset($_GET['e']) ? $_GET['e'] : -1;
$event_id = $event_id == -1 ? (isset($_POST['event']) ? $_POST['event'] : -1) : $event_id;
switch($action) {
	case "acc":
		$page = "view/account_manager.php";
	break;

	case "update_acc":
		if($_POST['change_password'] == "yes" && isset($_POST['pword']) && strlen($_POST['pword']) > 0) {
			$new_password = md5($_POST['pword']);
		} else {
			$new_password = "";
		}

		edit_account($user_id, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phone'], $new_password);
	break;
	
	case "delete":
		partially_delete_event($event_id);
		$page = "view/home.php";
	break;
	
	case "Reminders":
		$event_id = $_POST['event_id'];
		$event = get_event($event_id);
		$reminders = get_reminders_for_event($event_id);
		$page = "view/reminders.php";
	break;
	
	case "view_task_sign_up":
		$event_id = $_POST['event'];
		$event = get_event($event_id);
		$task_id = $_POST['task'];
		$page = "view/event.php";
	break;

	case "task_sign_up":
		$task_id = $_POST['task'];

		$fields_filled_in = true;
		$fields_filled_in &= isset($_POST['fname']) && strlen($_POST['fname']) > 0;
		$fields_filled_in &= isset($_POST['lname']) && strlen($_POST['lname']) > 0;
		$fields_filled_in &= isset($_POST['email']) && strlen($_POST['email']) > 0;
		$fields_filled_in &= isset($_POST['phone']) && strlen($_POST['phone']) > 0;

		$email = isset($_POST['email']) ? $_POST['email'] : "none";
		$pnum = isset($_POST['phone']) ? $_POST['phone'] : "none";

		if(!$fields_filled_in) {
			$sign_up_error_message = "Please fill in all fields!";
		} else if(strpos($email, "@") === false || strpos($email, ".") === false) {
			$sign_up_error_message = "Please enter a valid <br /> email address!";
		} else if (strlen($pnum) < 10) {
			$sign_up_error_message = "Please provide all digits in <br /> your phone number,<br /> including the area code!";
		} else if(strlen($pnum) > 10) {
			$sign_up_error_message = "Please provide a <br /><u><b>real</b></u> phone number.";
		} else {
			if($volunteer_id != -1 && isset($_POST['editing'])) {
				$signup_id = $_POST['signup'];
				edit_account($volunteer_id, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phone'], ' ');
				if(isset($_POST["comment"]))
					edit_signup_comment($signup_id, $_POST['comment']);
			} else {
				if($volunteer_id == -1) {
					$account_id = register_user($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phone'], ' ', 0);
				} else {
					$account_id = $volunteer_id;
				}
				set_cookie_for_user($account_id, true);
				$_SESSION['VOL_ID'] = $account_id;
				$volunteer_id = $account_id;
				if(isset($_POST['comment'])) {
					sign_up_for_task($task_id, $account_id, $_POST['comment']);
				} else {
					sign_up_for_task($task_id, $account_id);
				}
			}
		}

		if(isset($sign_up_error_message)) {
			$_SESSION['task'] = $task_id;
			$page = "view/task_sign_up.php";
		} else {
			$event = get_event($event_id);
			$page_title = $event['title'];
			unset($task_id);
			$page = "view/event.php";
		}
	break;

	case "Remove":
		$event = get_event($_POST['event']);
		$signup_id = $_POST['signup'];
		delete_signup($signup_id);
		$page = "view/event.php";

		unset($task_id);
	break;

	case "save_event_reminders":
		$event_id = $_POST['event_id'];
		save_event_reminders($event_id, $_POST);

		$event = get_event($event_id);
		$reminders = get_reminders_for_event($event_id);
		$page = "view/reminders.php";
	break;

	case "preview_save":
		if(isset($_POST['event_id']) && $_POST['event_id'] != -1)
			save_existing_event($_POST['event_id'], $_SESSION['preview_data']);
		else
			save_event($_SESSION['preview_data']);
	break;

	case "Save":
		if(isset($_POST['event_id']) && $_POST['event_id'] != -1)
			save_existing_event($_POST['event_id'], $_POST);
		else
			save_event($_POST);
	break;

	case "preview_edit":
		$preview_data = $_SESSION['preview_data'];
		$event = array(
			"title" => $preview_data['event_title'],
			"event_date" => $preview_data['event_date'],
			"description" => $preview_data['event_desc'],
			"deleted_tasks" => $preview_data['deleted_tasks']
		);
		$tasks = parse_tasks($preview_data, JS);
		$page = "view/event_creator.php";
	break;

	case "Preview":
		$page = "view/event_preview.php";
	break;
	
	case "create_event":
		$page = "view/event_creator.php";
	break;

	case "v1":
		$volunteer_sign_in = true;
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "v0":
		unset($_SESSION['VOL_ID']);
		$volunteer_id = -1;
		unset($volunteer);
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "vol_sign_in":
		$email = $_POST['email'];
		$volunteer = auth_volunteer($email);
		if($volunteer != -1) {
			$_SESSION['VOL_ID'] = $volunteer['ID'];
			$volunteer_id = $volunteer['ID'];
		}
		$event = get_event($event_id);
		$page = "view/event.php";
	break;
	
	case "none":
		if(isset($_GET['e'])) {
			$event_id = $_GET['e'];
			$event = get_event($event_id);
			$tasks = get_tasks_for_event($event_id);
			$page_title = $event['title'];
			$page = $user_id == $event['accountID'] ? "view/event_creator.php" : "view/event.php";
		}
	break;
}

$page = isset($page) ? $page : "view/front.php";

$page_title = "PT Volunteer";

include 'view/header.php';
include "$page";
include isset($footer) ? $footer : 'view/footer.php';