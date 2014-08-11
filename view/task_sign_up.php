<?php
	if(isset($_SESSION['task'])) {
		$task_id = $_SESSION['task'];
		unset($_SESSION['task']);
	} else {
		$task_id = $_POST['task'];
	}
	$task = get_task($task_id);

	if($volunteer_id != -1) {
		$signup = get_signup($task_id, $volunteer_id);
	}
	$comments_enabled = $task['comments'];


	$data = isset($volunteer) ? $volunteer : $_POST;

	$editing = $volunteer_id != -1 && $signup['accountID'] == $volunteer_id;

	if($comments_enabled) {
		if(isset($signup["comment"]))
			$comment = $signup["comment"];
		if(isset($_POST["comment"]))
			$comment = $_POST["comment"];
	}

	$event = get_event($_POST['event']);
?>
<div id="event_container">
	<div id="task_sign_up_title"><?php echo sanitizeHTML($task['description']); ?></div>
	<br />
	<div id="task_sign_up_fields">
		<form action=".?e=<?php echo $event_id; ?>" method="POST">
			<input type="hidden" name="action" value="task_sign_up"/>
			<input type="hidden" name="task" value="<?php echo $_POST['task']; ?>"/>
			<input type="hidden" name="event" value="<?php echo $_POST['event']; ?>"/>
			<?php if(isset($signup)): ?>
				<input type="hidden" name="signup" value="<?php echo $signup['ID']; ?>"/>
			<?php endif; ?>
			<input class="form_text_field sign_up_field focus_field" type="text" name="fname" placeholder="First Name" value="<?php if(isset($data['fname'])) echo sanitizeHTML($data['fname']); ?>" autofocus/>
			<input class="form_text_field sign_up_field" type="text" name="lname" placeholder="Last Name" value="<?php if(isset($data['lname'])) echo sanitizeHTML($data['lname']); ?>"/>
			<?php if(!user_exists($data['email'])): ?>
				<input class="form_text_field sign_up_field" type="text" name="email" placeholder="Email" value="<?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?>"/>
			<?php else: ?>
				<div class="form_text_field sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px"><?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?></div>
			<?php endif; ?>
			<input class="form_text_field sign_up_field phone_number" maxlength="10" type="text" name="phone" placeholder="Phone Number"  value="<?php if(isset($data['phone'])) echo $data['phone']; ?>"/>
			<?php if($comments_enabled): ?>
			<textarea class="form_text_field sign_up_field" type="text" name="comment" rows="4" placeholder="Comment"><?php if(isset($comment)) echo sanitizeTXT($comment); ?></textarea>
			<?php endif; ?>
			<br />
			<?php if(isset($sign_up_error_message)):
				echo "<span style='color:#f00'>".$sign_up_error_message."</span><br /><br />";
			endif; ?>
			<br />
			<?php if($editing):?> 
				<input type="hidden" name="editing" value="true"/>
			<?php endif; ?>
			<input class="button submit_button sign_up_field" type="submit" value="<?php echo $editing ? "Edit" : "Sign Up!"; ?>"/>
			<a class="button submit_button sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px" href=".?e=<?php echo $event_id; ?>">Cancel</a>
			<?php if($volunteer_id != -1): ?>
			<br /><br /><input class="button submit_button sign_up_field" style="background-color: #e66;" type="submit" name="action" value="Remove"/>
			<?php endif; ?>
			<br />
		</form>
	</div>
</div>