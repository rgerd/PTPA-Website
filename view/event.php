<div id="event_tasks">
	<?php for($i = 0; $i < 10; $i++): ?>
	<div class="event_task">
		<div class="event_task_header">
			<div class="event_task_title"><?php echo "Event Task ".($i + 1); ?></div>
			<div class="event_task_expander" expanded="false"></div>
		</div>
		<br />
		<div class="event_task_details" style="display: none;">
			<div class="event_signup_info">
				<div class="slots_full">
					<?php echo /*"$slots_full/$total_slots"*/ "4/5"; ?> Slots Full
				</div>
				<div class="signed_up">
					Already Signed Up:
					<div class="sign_up_list">
					<ul>
						<li>Person: comment</li>
						<li>Person: comment</li>
						<li>Person: comment</li>
						<li>Person: comment</li>
						<li>Person: comment</li>
						<li>Person: comment</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="event_sign_up_button">Sign Up</div>
		</div>
	</div>
	<?php endfor; ?>
</div>