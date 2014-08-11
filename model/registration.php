<?php
$email = isset($_POST['email']) ? $_POST['email'] : "none";
$entered_password = isset($_POST['password']) && strlen($_POST['password']) != 0;
$password = md5(isset($_POST['password']) ? $_POST['password'] : ""); // encrypted for security

if($action == "sign_in") {
	$top_tab = "sign_in";
	if(!$email || !$entered_password) {
		$sign_in_error_message = "Please fill in all fields!";
	} else {
		$user_id = auth_user($email, $password);
		if($user_id == -1) {
			$sign_in_error_message = "This email is already registered!<br /><a href='.?a=fp&b=".get_id_by_email($email)."'>Forgot your password?</a>";
			$error_message_return = false;
		} else {
			set_cookie_for_user($user_id, false);
			$_SESSION['USER_ID'] = $user_id;
			$page = "view/home.php";
		}
	}
} else if($action == "sign_up") {
	$top_tab =  "sign_up";

	$sign_up_error_message = validate($_POST, array('fname', 'lname', 'email', 'pnum'));
	
	if(user_exists($email)) {
		$sign_up_error_message = "This email is already registered!<br /><a href='.?a=fp&b=".get_id_by_email($email)."'>Forgot your password?</a>";
		$error_message_return = false;
	}

	if($sign_up_error_message == "none")
		unset($sign_up_error_message);

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$pnum = unformat_number($_POST['pnum']);

	if(!isset($sign_up_error_message)) {
		$user_id = register_user($fname, $lname, $email, unformat_number($pnum), $password, 1);
		set_cookie_for_user($user_id, false);
		$page = "view/home.php";
	}
}