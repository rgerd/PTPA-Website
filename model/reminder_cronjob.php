<?php
include "database.php";
include "mysql.php";

$today = date('Y-m-d');
$reminders = get_reminders_for_date($today);
#remove_reminders($reminders);
foreach($reminders as $reminder) {
	$event_id = $reminder['eventID'];
	$type = $reminder['type'];
	$dest = $reminder['dest'];
	$data = $reminder['data'];
}