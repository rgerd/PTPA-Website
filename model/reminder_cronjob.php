<?php
// ADDED PLIVO CODE, THIS WON'T WORK UNTIL WE INSTALL IT

include "database.php";
include "mysql.php";
include "mailer.php";
include "PDFGenerator.php";
//incude "plivo.php";

/*
$auth_id = "XXXXXXXXXXXXXXXXXXXXXXXXXXX";
$auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$plivo = new RestAPI($auth_id, $auth_token);
*/

$reminders = get_reminders_for_today();
#remove_reminders($reminders);
foreach($reminders as $reminder) {
	$event_id = $reminder['eventID'];
	$type = $reminder['type'];

	switch(type) {
		case 0: # Volunteers
		send_reminder_to_volunteers($event_id);
		break;
		case 1: # Creator
		send_reminder_to_creator($event_id);
		break;
	}
	echo "Reminders sent.";
}

function send_reminder_to_volunteers($event_id) {
	$general_message = "Hello %s %s, this is a reminder that you signed up for %s, which is occuring on %s. You signed up for the following task: \"%s\".";
	$comment_message = " Your comment was: \"%s\"";


	$event = get_event($event_id);
	$tasks = get_tasks_for_event($event_id);
	$volunteers = array();

	foreach($tasks as $task) {
		$signups = get_users_signed_up($task['ID']);
		foreach($signups as $signup) {
			$account = get_user($signup['accountID']);
			
			$message = sprintf($general_message, $account['fname'], $account['lname'], $event['title'], $event['event_date'], $task['description']);
			if($task['comments']) 
				$message .= sprintf($comment_message, $signup['comment']);
			
			sendMail($account['email'], $account['fname'].' '.$account['lname'], "PTVolunteer Reminder", $message);

			/*
			$params = array(
		        'src' => '1202XXXXXX',
		        'dst' => $account['phone'],
		        'text' => $message,
		        'type' => 'sms',
		    );
		    $response = $plivo->send_message($params);
			*/
			# echo $message."<br />";
		}
	}
}

function send_reminder_to_creator($event_id) {

}



