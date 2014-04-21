
<div id="event_tasks">
	<?php 
	$tasks = get_tasks_for_event($event_id);
	foreach($tasks as $task):
		$signed_up = get_users_signedup($task['ID']);
	?>
	<div class="event_task">
		<div class="event_task_header">
			<div class="event_task_title"><?php echo $task['desc']; ?></div>
			<div class="event_task_expander" expanded="false"></div>
		</div>
		<br />
		<div class="event_task_details" style="display: none;">
			<div class="event_signup_info">
				<div class="slots_full">
					<?php echo count($signed_up)."/".$task["numSlots"]; ?> Slots Full
				</div>
				<div class="signed_up">
					Already Signed Up:
					<div class="sign_up_list">
					<ul>
						<?php 
							foreach($signed_up as $user):
							$user_ = get_user($user['accountID']);
						?>
							<li><?php echo $user_['fname']." ".$user_['lname'].": ".$user['comment']; ?></li>
						<?php
							endfor;
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="event_sign_up_button">Sign Up</div>
		</div>
	</div>
	<?php endfor; ?>
</div>