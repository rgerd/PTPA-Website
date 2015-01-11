<?php
session_start();
include "model/database.php";
include "model/mysql.php";
include "model/cookie.php";
$action = isset($_POST['action']) ? $_POST['action'] : "none";
$action = isset($_GET['a']) ? $_GET['a'] : $action;
include "model/mailer.php";
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
		if($user_id == -1)
				break;

		$page = "view/account_manager.php";
	break;

	case "update_acc":
		if($user_id == -1)
			break;

		if($_POST['change_password'] == "yes" && isset($_POST['pword']) && strlen($_POST['pword']) > 0) {
			$new_password = md5($_POST['pword']);
		} else {
			$new_password = "";
		}

		edit_account($user_id, $_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), $new_password);
	break;
	
	case "delete":
		if($user_id == -1)
			break;

		partially_delete_event($event_id);
		$page = "view/home.php";
	break;
	
	case "Reminders":
		if($user_id == -1)
				break;

		$event_id = $_POST['event_id'];
		$event = get_event($event_id);
		$reminders = get_reminders_for_event($event_id);
		$page = "view/reminders.php";
	break;
	
	case "view_task_sign_up":
		$event = get_event($event_id);
		$task_id = $_POST['task'];
		$page = "view/event.php";
	break;

	case "task_sign_up":
		$task_id = $_POST['task'];
		$email = isset($_POST['email']) ? $_POST['email'] : get_user($volunteer_id)['email'];
		$_POST['email'] = $email;
		$sign_up_error_message = validate($_POST, array('fname', 'lname', 'phone', 'email'));
		if(isset($_POST["comment"]) && strlen(str_replace(" ", "", $_POST['comment'])) == 0)
			$sign_up_error_message = "Please leave a comment!";

		if($sign_up_error_message == "none")
			unset($sign_up_error_message);

		if(!isset($sign_up_error_message)) {
			$task_action = "none";

			if($volunteer_id != -1) {
				if(isset($_POST['editing'])) {
					$success = "Edit successful!"; // We are predicting great success at 100%
					edit_account($volunteer_id, $_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), '');
					$signup_id = $_POST['signup'];
					$task_action = ($signup_id == -1) ? "sign_up" : "edit";
				} else {
					$account_id = $volunteer_id;
					edit_account($volunteer_id, $_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), '');
					$task_action = "sign_up";
				}
			} else {
				$volunteer_id = auth_volunteer($_POST['email']);
				if($volunteer_id != -1) {
					$account_id = $volunteer_id;
					edit_account($account_id, $_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), '');
					$signup_id = get_signup($task_id, $account_id)['ID'];

					$task_action = ($signup_id == -1) ? "sign_up" : "edit";
				} else {
					$account_id = register_user($_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), '', 0);
					$task_action = "sign_up";
				}
				
				set_cookie_for_user($account_id, true);
				$_SESSION['VOL_ID'] = $account_id;
				$volunteer_id = $account_id;
				$volunteer = get_user($account_id);
			}

			if($task_action == "sign_up") {
				if(isset($_POST['comment'])) {
					$success = sign_up_for_task($task_id, $account_id, $_POST['comment']);
				} else {
					$success = sign_up_for_task($task_id, $account_id);
				}
				if($success)
					$event_success_message = "Sign up successful!";
			} else if($task_action == "edit") {
				if(isset($_POST["comment"]))
					$success = edit_signup_comment($signup_id, $_POST['comment']);
				if($success)
					$event_success_message = "Edit successful!";
			}
		}

		if(isset($sign_up_error_message)) {
			$_SESSION['task'] = $task_id;
		} else {
			unset($task_id);
		}

		$event = get_event($event_id);
		$page_title = $event['title'];
		$page = "view/event.php";
	break;

	case "Remove":
		$event = get_event($event_id);
		$signup_id = $_POST['signup'];
		delete_signup($signup_id);
		unset($task_id);
		$event_success_message = "Removal successful!";
		$page = "view/event.php";
	break;

	case "save_event_reminders":
		if($user_id == -1)
				break;

		$event_id = $_POST['event_id'];
		save_event_reminders($event_id, $_POST);

		$event = get_event($event_id);
		$reminders = get_reminders_for_event($event_id);
		$page = "view/reminders.php";
	break;

	case "preview_save":
		if($user_id == -1)
				break;

		if(isset($_POST['event_id']) && $_POST['event_id'] != -1)
			save_existing_event($_POST['event_id'], $_SESSION['preview_data']);
		else
			save_event($_SESSION['preview_data']);
	break;

	case "Save":
		if($user_id == -1)
			break;

		if(isset($_POST['event_id']) && $_POST['event_id'] != -1)
			save_existing_event($_POST['event_id'], $_POST);
		else
			save_event($_POST);
	break;

	case "preview_edit":
		if($user_id == -1)
			break;

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
		if($user_id == -1)
			break;

		$page = "view/event_preview.php";
	break;
	
	case "create_event":
		if($user_id == -1)
			break;

		$page = "view/event_creator.php";
	break;

	case "v1":
		$volunteer_sign_in = true;
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "v0":
		clear_cookie_for_volunteer();
		unset($volunteer);
		$volunteer_id = -1;
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "ve":
		$volunteer_edit = true; 
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "edit_volunteer":
		$volunteer_edit_error = validate($_POST, array('fname', 'lname', 'phone'));
		if($volunteer_edit_error == "none")
			unset($volunteer_edit_error);

		$email = isset($_POST['email']) ? $_POST['email'] : get_user($volunteer_id)['email'];

		if(!isset($volunteer_edit_error))
			edit_account($volunteer_id, $_POST['fname'], $_POST['lname'], $email, unformat_number($_POST['phone']), '');
		else
			$volunteer_edit = true;

		$volunteer = get_user($volunteer_id);
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "vol_sign_in":
		$email = $_POST['email'];
		$volunteer_id = auth_volunteer($email);
		if($volunteer_id != -1) {
			set_cookie_for_user($volunteer_id, true);
		} else {
			$volunteer_sign_in = true;
			if(str_replace(" ", "", $email) != 0)
				$vol_sign_in_error = "This email is not registered!"; 
			echo $vol_sign_in_error;
		}
		$volunteer = get_user($volunteer_id);
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "cc":
		$contact_creator = true;
		$event = get_event($event_id);
		$page = "view/event.php";
	break;

	case "send_message":
		$contact_creator_error = validate($_POST, array('fname', 'lname', 'phone'));
		if($contact_creator_error == "none")
			unset($contact_creator_error);
		$message = sanitizeHTML($_POST['message']);
		if(strlen(str_replace(" ", "", $message)) == 0)
			$contact_creator_error = "You must include a message!";
		$contact_creator = true;

		if(!$contact_creator_error) {
			include "model/mailer.php";
			$event = get_event($event_id);
			$creator = get_user($event['accountID']);
			$email = isset($_POST['email']) ? $_POST['email'] : get_user($volunteer_id)['email'];
			$_POST['email'] = $email;
			$phone_number = unformat_number($_POST['phone']);
			$phone_number = format_number($phone_number);
			edit_account($volunteer_id, $_POST['fname'], $_POST['lname'], $_POST['email'], unformat_number($_POST['phone']), '');

			$message = "Hello %s,<br /><br />%s %s has sent you a message regarding your event <u>%s</u> :<br /><br />%s<br /><br />If you wish to respond, you may contact him or her by email at %s or by phone: %s";
			$message = sprintf($message, $creator['fname'], $_POST['fname'], $_POST['lname'], $event['title'], $_POST['message'], $email, $phone_number);
			sendMail($creator['email'], $creator['fname']." ".$creator['lname'], $event['title']." - Message", $message);
			$event_success_message = "Message sent!";
			$contact_creator = false;
			$page = "view/event.php";
		}
		$event = get_event($event_id);
	break;

	case "fp":
		$account_id = $_GET['b'];
		send_password_reset($account_id);
		$password_changed = true;
	break;
	
	case "none":
		if(isset($_GET['e'])) {
			$event_id = $_GET['e'];
			$event = get_event($event_id);
			$event_exists = $event;
			$tasks = get_tasks_for_event($event_id);
			$page_title = $event['title'];
			if($event_exists)
				$page = $user_id == $event['accountID'] ? "view/event_creator.php" : "view/event.php";
		}
		$home_link = ".";
	break;
}

$page = isset($page) ? $page : "view/front.php";

$page_title = "PT Volunteer";

if(!isset($home_link)) {
	if($event_id != -1)
		$home_link = ".?e=".$event_id;
	else
		$home_link = "."; 
}

include 'view/header.php';
include "$page";
include isset($footer) ? $footer : 'view/footer.php';