<?php
function echoEventTask($title, $slots_full, $total_slots, $signed_up_list) {
	echo <<<END
		<div id="event_task">
			<div id="event_task_title">$title</div>
			<div id="event_expander"></div>
			<br />
			<div id="event_signup_info">
				<div id="slots_full">
					$slots_full/$total_slots Slots Full
				</div>
				<div id="signed_up">
					Already Signed Up:
					<div id="sign_up_list">
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
			<div id="event_sign_up_button">Sign Up</div>
		</div>
END;
}
?>