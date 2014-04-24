<?php
$fname = isset($_POST['fname']) ? $_POST['fname'] : "none";
$lname = isset($_POST['lname']) ? $_POST['lname'] : "none";
$email = isset($_POST['email']) ? $_POST['email'] : "none";
$entered_password = isset($_POST['password']);
$password = md5(isset($_POST['password']) ? $_POST['password'] : ""); // encrypted for security
$pnum = isset($_POST['pnum']) ? $_POST['pnum'] : "none";

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
		$set_cookie_for_user($user_id);
		$_SESSION['USER_ID'] = $user_id;
		$page = "view/home.php";
	}
}