<?php
if(!isset($_SESSION['USER_ID']) && isset($_COOKIE['u_id'])) {
	$data = $_COOKIE['u_id'];
	$user_id = get_user_id_by_cookie_data($data);
	$_SESSION['USER_ID'] = $user_id;
}

if(!isset($_SESSION['VOL_ID']) && isset($_COOKIE['v_id'])) {
	$data = $_COOKIE['v_id'];
	$volunteer_id = get_user_id_by_cookie_data($data);
	$_SESSION['VOL_ID'] = $volunteer_id;
}

function set_cookie_for_user($user_id, $volunteer) {
	$_user_id = str_split($user_id);
	$chars = count($_user_id);
	$data = "";
	for($i = 0; $i < $chars; $i++) {
		$data .= $_user_id[$i];
		$data .= 8;
	}
	$data .= time();
	$data = md5($data);
	set_cookie_data($user_id, $data);
	if($volunteer) {
		setcookie("v_id", $data, time() + 60 * 60 * 24 * 30);
	} else {
		setcookie("u_id", $data, time() + 60 * 60 * 24 * 30);
	}
}

function clear_cookie_for_user() {
	setcookie("u_id", time() - 2048);
	unset($_SESSION['USER_ID']);
}

function clear_cookie_for_volunteer() {
	setcookie("v_id", time() - 2048);
	unset($_SESSION['VOL_ID']);
	$volunteer_id = -1;
}