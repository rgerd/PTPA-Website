<?php
	function save_event($data) {
		global $user_id;
		$event_title = sanitize($data['event_title']);
		$event_date = sanitize($data['event_date']);
		$event_desc = sanitize($data['event_desc']);
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

		$event_title = sanitize($data['event_title']);
		$event_date = sanitize($data['event_date']);
		$event_desc = sanitize($data['event_desc']);
		update_event($event_id, $event_title, $event_date, $event_desc);

		$last_internalID = 0;
		if(isset($data['deleted_tasks'])) {
			$deleted_tasks = explode(",", sanitize($data['deleted_tasks']));
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

		//delete_extra_tasks($event_id, $last_internalID);
	}

	function parse_tasks($task_data) {
		$tasks = array();

		$event_task_index = 0;
		while(true) {
			$v = 'event_task_'.$event_task_index;
			if(isset($task_data[$v])) {
				$id = sanitize($task_data[$v."_id"]);
				$title = sanitize($task_data[$v."_title"]);
				$slots = sanitize($task_data[$v."_slots"]);
				$comments = isset($task_data[$v."_comments"]) ? 1 : 0;

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