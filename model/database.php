<?php
$host = "localhost";
$db_name = "PTPA_DB";
$db_user = "root";
$db_pass = "root";
try {
	$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
	echo "PDO ERROR: ".($e ->getMessage())."<br />";
	die();
}
?>
