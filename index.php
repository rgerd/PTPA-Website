<?php
	session_start();
	include "model/database.php";
	include "model/mysql.php";
	include "model/cookie.php";


	$user_id = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : -1;
	if($user_id != -1)
		$page = "view/home.php";

	$action = isset($_POST['action']) ? $_POST['action'] : "none";

	include "model/registration.php";

	if(isset($_GET['e'])) {
		$event_id = $_GET['e'];
		$event = get_event($event_id);
		$page_title = $event['title'];
		$page = "view/event.php";
	}

	if($action == "task_sign_up") {
		$event_id = $_POST['event'];
		$task_id = $_POST['task'];

		sign_up_for_task($task_id, $user_id);
	}

	$page = isset($page) ? $page : "view/front.php";

	$page_title = "PT Volunteer";
?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
