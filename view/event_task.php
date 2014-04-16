<?php
function echoEventTask($title, $slots_full, $total_slots, $signed_up_list) {
	echo <<<END
		<div class="event_task">
			<div class="event_task_header">
				<div class="event_task_title">$title</div>
				<div class="event_task_expander" expanded="false"></div>
			</div>
			<br />
			<div class="event_task_details" style="display: none;">
				<div class="event_signup_info">
					<div class="slots_full">
						$slots_full/$total_slots Slots Full
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
END;
}
?>