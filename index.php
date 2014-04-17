<?php
	//include "model/database.php";
	//include "model/mysql.php";


	if(isset($_GET['event_id'])) {
		$event_id = $_GET['event_id'];
		$page_title = "Event!";
		$page = "view/event.php";
	}

	$page = "view/front.php";

?>
<?php include 'view/header.php'; ?>
<?php include "$page"; ?>
<?php include 'view/footer.php'; ?>
