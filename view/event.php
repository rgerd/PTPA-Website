<div class="event_details">
    <div class="details_element" id="details_title"><?php echo sanitizeHTML($event['title']); ?></div>
    <div class="details_element"><?php echo date_format(date_create($event['event_date']), 'm/d/Y'); ?></div>
    <div class="details_element"><?php echo sanitizeHTML($event['description']); ?></div>
</div>
<div id="event_tasks">
	<?php
	if(!$preview)
		$tasks = get_tasks_for_event($event_id);

	foreach($tasks as $task):
		$task_id = $task['ID'];
		$signed_up = $preview ? 0 : get_users_signed_up($task['ID']);
		$num_signed_up = $preview ? 0 : count($signed_up);
		$max_num_signed_up = $task["numSlots"];
		$task_full = $num_signed_up == $max_num_signed_up;
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
					<?php echo $num_signed_up."/".$max_num_signed_up; ?> Slots Full
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
							<li><?php 
								echo "<b>".$user_['fname']." ".$user_['lname']."</b>";
								if($task['comments'])
									echo ": ".$user['comment'];
							?></li>
						<?php
							endforeach;
						?>
					</ul>
					</div>
				</div>
				<?php endif; ?>
		</div>
		<?php if($volunteer_id != -1 && get_signup($task_id, $volunteer_id) !== false): ?>
			<form action="." method="POST">
				<input type="submit" class="button event_sign_up_button" value="Edit"/>
				<input type="hidden" name="action" value="view_task_sign_up"/>
				<input type="hidden" name="event" value="<?php echo $event_id; ?>"/>
				<input type="hidden" name="task" value="<?php echo $task['ID']; ?>"/>
			</form>
		<?php elseif(!$task_full): ?>
			<?php if(!$preview): ?>
				<form action="." method="POST">
					<input type="submit" class="button event_sign_up_button" value="Sign Up"/>
					<input type="hidden" name="action" value="view_task_sign_up"/>
					<input type="hidden" name="event" value="<?php echo $event_id; ?>"/>
					<input type="hidden" name="task" value="<?php echo $task['ID']; ?>"/>
				</form>
			<?php else: ?>
				<div style="display:block;"><button class="button event_sign_up_button">Sign Up</button></div>
			<?php endif; ?>
		<?php else: ?>
			<button type="button" class="button event_sign_up_button task_full_button">Full</button>
		<?php endif; ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>