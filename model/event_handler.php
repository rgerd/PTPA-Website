<?php
	define("HTML", "html");
	define("JS", "js");
	define("NONE", "none");

	function save_event($data) {
		global $user_id;
		$event_title = $data['event_title'];
		$event_date = $data['event_date'];
		$event_desc = $data['event_desc'];
		$event_id = add_event($user_id, $event_title, $event_date, $event_desc);

		$tasks = parse_tasks($data);
		foreach($tasks as $task) {
			add_task($event_id, $task['internalID'], $task['description'], $task['numSlots'], $task['comments']);
		}
	}

	function save_existing_event($event_id, $data) {
		global $user_id;
		if(!user_owns_event($user_id, $event_id))
			return;

		$event_title = $data['event_title'];
		$event_date = $data['event_date'];
		$event_desc = $data['event_desc'];
		update_event($event_id, $event_title, $event_date, $event_desc);

		if(isset($data['deleted_tasks'])) {
			$deleted_tasks = explode(",", $data['deleted_tasks']);
			foreach($deleted_tasks as $task) {
				delete_task($task);
			}
		}

		$tasks = parse_tasks($data);
		foreach($tasks as $task) {
			if($task['ID'] == '-1') {
				add_task($event_id, $task['internalID'], $task['description'], $task['numSlots'], $task['comments']);
			} else {
				update_task($task['ID'], $task['internalID'], $task['description'], $task['numSlots'], $task['comments']);
			}
		}
	}

	function save_event_reminders($event_id, $data) {
		global $user_id;
		if(!user_owns_event($user_id, $event_id))
			return;

		if(isset($data['deleted_reminders'])) {
			$deleted_reminders = explode(",", $data['deleted_reminders']);
			foreach($deleted_reminders as $reminder) {
				delete_reminder($reminder);
			}
		}

		$reminders = parse_reminders($data);

		foreach($reminders as $reminder) {
			if($reminder['ID'] == '-1')
				add_reminder($event_id, 0, $reminder['date']);
		}

		if(isset($data['day_before']) && !isset($data['day_before_id'])) {
			add_reminder($event_id, 1, "");	
		} else if(!isset($data['day_before']) && isset($data['day_before_id'])) {
			delete_reminder($data['day_before_id']);
		}

		if(isset($data['week_before']) && !isset($data['week_before_id'])) {
			add_reminder($event_id, 2, "");	
		} else if(!isset($data['week_before']) && isset($data['week_before_id'])) {
			delete_reminder($data['week_before_id']);
		}
	}

	function parse_tasks($task_data, $target = NONE) {
		$tasks = array();

		$event_task_index = 0;
		while(true) {
			$v = 'event_task_'.$event_task_index;
			if(isset($task_data[$v])) {
				$id = $task_data[$v."_id"];
				$title = $task_data[$v."_title"];
				$slots = $task_data[$v."_slots"];
				$comments = isset($task_data[$v."_comments"]) ? 1 : 0;

				if($target == HTML) {
					$title = sanitizeHTML($title);
				} else if($target == JS) {
					$title = sanitizeJS($title);
				}

				$task = array(
					"ID" => $id,
					"internalID" => $event_task_index,
					"description" => $title,
					"numSlots" => $slots,
					"comments" => $comments
				);
				array_push($tasks, $task);
			} else {
				break;
			}
			$event_task_index++;
		}
		return $tasks;
	}

	function parse_reminders($reminder_data) {
		$reminders = array();

		$reminder_index = 0;
		while(true) {
			$v = 'reminder_'.$reminder_index;
			if(isset($reminder_data[$v])) {
				$id = $reminder_data[$v."_id"];
				$date = $reminder_data[$v."_date"];

				$reminder = array(
					"ID" => $id,
					"date" => $date,
				);
				array_push($reminders, $reminder);
			} else {
				break;
			}
			$reminder_index++;
		}
		return $reminders;
	}