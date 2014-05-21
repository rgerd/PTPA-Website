<?php
	function save_event($data) {
		global $user_id;
		$event_title = sanitize($data['event_title']);
		$event_date = sanitize($data['event_date']);
		$event_desc = sanitize($data['event_desc']);
		$event_id = add_event($user_id, $event_title, $event_date, $event_desc);

		$tasks = parse_tasks($data);
		foreach($tasks as $task) {
			add_task($event_id, $task['internalID'], $task['title'], $task['numSlots'], $task['comments']);
		}
	}

	function parse_tasks($task_data) {
		$tasks = array();

		$event_task_index = 0;
		while(true) {
			$v = 'event_task_'.$event_task_index;
			if(isset($task_data[$v])) {
				$title = sanitize($task_data[$v."_title"]);
				$slots = sanitize($task_data[$v."_slots"]);
				$comments = isset($task_data[$v."_comments"]) ? 1 : 0;

				$task = array(
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
?>