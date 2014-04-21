<?php
	session_start();
	include "model/database.php";
	include "model/mysql.php";

	include "model/cookie.php";

	$user_id = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : -1;
	if($user_id != -1)
		$page = "view/home.php";

	$action = isset($_POST['action']) ? $_POST['action'] : "none";
	$fname = isset($_POST['fname']) ? $_POST['fname'] : "none";
	$lname = isset($_POST['lname']) ? $_POST['lname'] : "none";
	$email = isset($_POST['email']) ? $_POST['email'] : "none";
	$entered_password = isset($_POST['password']);
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
		} else if(user_exists($email)) {
			$sign_up_error_message = "This email is already registered!<br /><a href='.'>Forgot your password?</a>";
		} else {
			$user_id = register_user($fname, $lname, $email, $pnum, $password);
			$_SESSION['USER_ID'] = $user_id;
			$page = "view/home.php";
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
	$page = "view/home.php";

?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
