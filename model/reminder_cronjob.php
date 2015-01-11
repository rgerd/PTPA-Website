<?php
// ADDED PLIVO CODE, THIS WON'T WORK UNTIL WE INSTALL IT
include "database.php";
include "mysql.php";
include "mailer.php";
//include "PDFGenerator.php";

//incude "plivo.php";

/*
$auth_id = "XXXXXXXXXXXXXXXXXXXXXXXXXXX";
$auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$plivo = new RestAPI($auth_id, $auth_token);
*/

// REMOVE EVENTS AFTER THEIR DATE
cleanup_events();


$reminders = get_reminders_for_today();

foreach($reminders as $reminder) {
	$event_id = $reminder['eventID'];
	$type = $reminder['type'];
	send_reminder_to_volunteers($event_id, $reminder['date_type']);
	send_reminder_to_creator($event_id, $reminder['date_type']);
	delete_reminder($reminder['ID']);
}


echo "Reminders sent.";


function send_reminder_to_volunteers($event_id, $date_type) {
	$general_message = "Hello %s, this is a reminder that you signed up for the event <u>%s</u>, 
	which is occuring %son %s. You signed up for the following task%s:<br /><br />%s";
	$event = get_event($event_id);
	$tasks = get_tasks_for_event($event_id);
	$volunteers = array();
	foreach($tasks as $task) {
		$signups = get_users_signed_up($task['ID']);
		foreach($signups as $signup) {
			$accountID = $signup['accountID'];
			$volunteer_exists = false;
			$num_volunteers = count($volunteers);
			for($i = 0; $i < $num_volunteers; $i++) {
				if($volunteers[$i]['id'] == $accountID) {
					$volunteer = &$volunteers[$i];
					$volunteer_exists = true;
					break;
				}
			}
			if(!$volunteer_exists)
				$volunteer = array( 'id' => $accountID, 'multi_task' => ' ', 'tasks' => '' );
			$t = &$volunteer['tasks'];
			$t .= "<b>".sanitizeHTML($task['description'])."</b><br />";
			if($task['comments'])
				$t .= "<tab style='width: 2em; display: inline-block'></tab>Comment: \"".sanitizeHTML($signup['comment'])."\"<br />";
			$t .= "<br />";
			if($volunteer['multi_task'] == ' ')
				$volunteer['multi_task'] = ''; 
			else if($volunteer['multi_task'] == '')
				$volunteer['multi_task'] = 's';
			if(!$volunteer_exists)
				array_push($volunteers, $volunteer);
		}
	}
	switch($date_type) {
		case 0:
		$date_modifier = '';
		break;
		case 1:
		$date_modifier = 'tomorrow ';
		break;
		case 2:
		$date_modifier = 'a week from now ';
		break;
	}
	foreach($volunteers as $volunteer) {
		$account = get_user($volunteer['id']);	
		$message = sprintf($general_message, $account['fname'], sanitizeHTML($event['title']), $date_modifier, convert_date($event['event_date'], "m/d/y"), $volunteer['multi_task'], $volunteer['tasks']);
		$message .= "<br />Thanks!<br />PT Volunteer";
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
	}
}

function send_reminder_to_creator($event_id, $date_type) {
	$message_data = "<style type='text/css'>tab {display:inline-block; width: 2em;}</style>";
	$event = get_event($event_id);
	$tasks = get_tasks_for_event($event_id);
	foreach($tasks as $task) {
		$message_data .= "<b>".sanitizeHTML($task['description'])."</b><br />";
		$signups = get_users_signed_up($task['ID']);
		foreach($signups as $signup) {
			$account = get_user($signup['accountID']);
			$message_data .= "<tab></tab>- ".sanitizeTXT($account['fname'])." ".sanitizeHTML($account['lname'])."<br />";
			$message_data .= "<tab></tab><tab></tab>- ".$account['email']."<br />";
			$message_data .= "<tab></tab><tab></tab>- ".format_number($account['phone'])."<br />";

			if($task['comments'])
				$message_data .= "<tab></tab><tab></tab>- \"".sanitizeHTML($signup['comment'])."\"<br />";
		}
		$message_data .= "<br />";
	}
	switch($date_type) {
		case 0:
		$date_modifier = '';
		break;
		case 1:
		$date_modifier = 'tomorrow ';
		break;
		case 2:
		$date_modifier = 'a week from now ';
		break;
	}
	$general_message = "Hello %s, this is an update for your event <u>%s</u>, which is occuring %son %s.<br />The link for to access and edit this event is %s<br />Here is the current sign up list:<br /><br /> %s";
	$account = get_user($event['accountID']);
	$message = sprintf($general_message, $account['fname'], sanitizeTXT($event['title']), $date_modifier, convert_date($event['event_date'], "m/d/y"), "http://192.185.4.11/~ptcs/ptpa/?e=".$event_id, $message_data);
	$message .= "<br /><br />Thanks!</br >PT Volunteer";
	sendMail($account['email'], $account['fname'].' '.$account['lname'], "PTVolunteer Reminder", $message);	
}