<?php
	function save_event($data) {
		global $user_id;
		$event_title = sanitize($data['event_title']);
		$event_date = sanitize($data['event_date']);
		$event_desc = sanitize($data['event_desc']);
		$event_id = add_event($user_id, $event_title, $event_date, $event_desc);
		$event_task_index = 0;
		while(true) {
			$v = 'event_task_'.$event_task_index;
			if(isset($data[$v])) {
				$title = sanitize($data[$v."_title"]);
				$slots = sanitize($data[$v."_slots"]);
				$comments = isset($data[$v."_comments"]) ? 1 : 0;
				add_task($event_id, $event_task_index, $title, $slots, $comments);
			} else {
				break;
			}
			$event_task_index++;
		}
	}
?>