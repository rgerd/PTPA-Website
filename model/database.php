<?php
$host = "localhost";
$db_name = "PTPA_DB";
$db_user = "root";
$db_pass = "root";


if(!connect("root")) {
	if(!connect("user")) {
		die();
	}
}

function connect($user) {
	global $db, $host, $db_name, $db_pass;
	try {
		$db = new PDO("mysql:host=$host;dbname=$db_name", $user, $db_pass);
	} catch(PDOException $e) {
		if($user != "root"){
		echo "PDO ERROR: ".($e ->getMessage())."<br />";
		}
		return false;
	}
	return true;
}
?>
