<?php
	if(isset($_SESSION['task'])) {
		$task_id = $_SESSION['task'];
		unset($_SESSION['task']);
	} else {
		$task_id = $_POST['task'];
	}
	$task = get_task($task_id);

	if($volunteer_id != -1) {
		$vol = get_user($volunteer_id);
		$signup = get_signup($task_id, $volunteer_id);
	}
	$comments_enabled = $task['comments'];


	$data = isset($vol) ? $vol : $_POST;

	$editing = $volunteer_id != -1 && $signup['accountID'] == $volunteer_id;


	if($comments_enabled) {
		if(isset($signup["comment"]))
			$comment = $signup["comment"];
		if(isset($_POST["comment"]))
			$comment = $_POST["comment"];
	}
?>
<div id="page_title" style="font-size: 1.5em; margin-top: -10px"><?php echo $task['description']; ?></div>
<br />
<form action="." method="POST">
	<input type="hidden" name="action" value="task_sign_up"/>
	<input type="hidden" name="task" value="<?php echo $_POST['task']; ?>"/>
	<input type="hidden" name="event" value="<?php echo $_POST['event']; ?>"/>
	<?php if(isset($signup)): ?>
		<input type="hidden" name="signup" value="<?php echo $signup['ID']; ?>"/>
	<?php endif; ?>
	<input class="form_text_field" type="text" name="fname" placeholder="First Name" value="<?php if(isset($data['fname'])) echo $data['fname']; ?>" autofocus/>
	<input class="form_text_field" type="text" name="lname" placeholder="Last Name" value="<?php if(isset($data['lname'])) echo $data['lname']; ?>"/>
	<input class="form_text_field" type="text" name="email" placeholder="Email" value="<?php if(isset($data['email'])) echo $data['email']; ?>"/>
	<input class="form_text_field phone_number" maxlength="10" type="text" name="phone" placeholder="Phone Number"  value="<?php if(isset($data['phone'])) echo $data['phone']; ?>"/>
	<?php if($comments_enabled): ?>
	<textarea class="form_text_field" type="text" name="comment" rows="4" placeholder="Comment"><?php if(isset($comment)) echo $comment; ?></textarea>
	<?php endif; ?>
	<br />
	<?php if(isset($sign_up_error_message)):
		echo "<span style='color:#f00'>".$sign_up_error_message."</span><br /><br />";
	endif; ?>
	<?php if($editing):?>
		<input type="hidden" name="editing" value="true"/>
	<?php endif; ?>
	<input class="button submit_button" type="submit" value="<?php echo $editing ? "Edit!" : "Sign Up!"; ?>"/>
	<a class="button submit_button" href=".?e=<?php echo $event_id; ?>">Cancel</a>
	<br />
</form>