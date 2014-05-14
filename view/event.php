<div class="event_details">
    <div class="details_element" id="details_title"><?php echo $event['title']; ?></div>
    <div class="details_element"><?php echo date_format(date_create($event['event_date']), 'm/d/Y'); ?></div>
    <div class="details_element"><?php echo $event['description']; ?></div>
</div>
<div id="event_tasks">
	<?php
	$tasks = get_tasks_for_event($event_id);
	foreach($tasks as $task):
		$signed_up = get_users_signedup($task['ID']);
		$num_signed_up = count($signed_up);
	?>
	<div class="event_task">
		<div class="event_task_header">
			<div class="event_task_title"><?php echo $task['description']; ?></div>
			<div class="event_task_expander" expanded="false"></div>
		</div>
		<br />
		<div class="event_task_details" style="display: none;">
			<div class="event_signup_info">
				<div class="slots_full">
					<?php echo $num_signed_up."/".$task["numSlots"]; ?> Slots Full
				</div>
				<?php if($num_signed_up != 0): ?>
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
							endforeach;
						?>
					</ul>
					</div>
				</div>
				<?php endif; ?>
		</div>
		<form action="." method="POST">
			<input type="submit" class="event_sign_up_button" value="Sign Up"/>
			<input type="hidden" name="action" value="task_sign_up"/>
			<input type="hidden" name="event" value="<?php echo $event_id; ?>"/>
			<input type="hidden" name="task" value="<?php echo $task['ID']; ?>"/>
		</form>
		</div>
	</div>
	<?php endforeach; ?>
</div>