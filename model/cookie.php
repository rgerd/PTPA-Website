<?php
if(!isset($_SESSION['USER_ID']) && isset($_COOKIE['user'])) {
	$data = $_COOKIE['user'];
	$user_id = get_user_id_by_cookie_data($data);
	$_SESSION['USER_ID'] = $user_id;
}

function set_cookie_for_user($user_id) {
	$_user_id = str_split($user_id);
	$chars = count($_user_id);
	$data = "";
	for($i = 0; $i < $chars; $i++) {
		$data .= $_user_id[$i];
		$data .= 8;
	}
	$data = md5($data);
	set_cookie_data($user_id, $data);
}