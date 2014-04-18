<?php
	include "model/database.php";
	include "model/mysql.php";

	$action = $_POST['action'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$password = md5($_POST['password']); // encrypted for security
	$pnum = $_POST['pnum'];

	if($action == "sign_in") {
		if(!auth_user($email, $password)) {
			$top_tab = "sign_in";
			$sign_in_error_message = "Incorrect email or password!";
		}
	} else if($action == "sign_up") {
		$top_tab =  "sign_up";
	}

	if(isset($_GET['event_id'])) {
		$event_id = $_GET['event_id'];
		$page_title = "Event!";
		$page = "view/event.php";
	} else {
		$page = "view/front.php";
	}
?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
