<?php
$host = "127.0.0.1";
$db_name = "ptcs_ptpa_db";
$db_user = "ptcs_user";
$db_pass = ",;[./']";

connect($db_user);

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
