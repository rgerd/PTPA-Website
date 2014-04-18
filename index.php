<?php
	session_start();
	include "model/database.php";
	include "model/mysql.php";
	include "model/cookie.php";

	set_cookie_for_user("hello_world");

	if(isset($_SESSION['USER_ID'])) {
		$user_id = $_SESSION['USER_ID'];
		$page = "view/home.php";
	}


	$action = $_POST['action'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$entered_password = !(!$_POST['password']);
	$password = md5($_POST['password']); // encrypted for security
	$pnum = $_POST['pnum'];

	if($action == "sign_in") {
		$top_tab = "sign_in";
		if(!$email || !$entered_password) {
			$sign_in_error_message = "Please fill in all fields!";
		} else {
			$user_id = auth_user($email, $password);
			if($user_id == -1) {
				$sign_in_error_message = "Incorrect username or password!";
			} else {
				$_SESSION['USER_ID'] = $user_id;
				$page = "view/home.php";
			}
		}
	} else if($action == "sign_up") {
		$top_tab =  "sign_up";
		if(!$fname || !$lname || !$email || !$entered_password || !$pnum) {
			$sign_up_error_message = "Please fill in all fields!";
		} else {
			//register_user($fname, $lname, $email, $pnum, $password);
		}
	}

	if(isset($_GET['event_id'])) {
		$event_id = $_GET['event_id'];
		$page_title = "Event!";
		$page = "view/event.php";
	}

	if(!$page) {
		$page = "view/front.php";
	}
?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
