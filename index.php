<?php
	include "model/database.php";
	include "model/mysql.php";

	$action = $_POST['action'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$entered_password = !(!$_POST['password']);
	echo $entered_password;
	$password = md5($_POST['password']); // encrypted for security
	$pnum = $_POST['pnum'];

	if($action == "sign_in") {
		$top_tab = "sign_in";
		if(!$email || !$entered_password) {
			$sign_in_error_message = "Please fill in all fields!";
		} else if(!auth_user($email, $password)) {
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
