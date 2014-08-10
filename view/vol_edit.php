<?php
	if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']))
		$data = $_POST;
	else
		$data = get_user($volunteer_id);
?>

<div id="event_container">
	<div id="task_sign_up_title">Edit Information</div>
	<br />
	<div id="task_sign_up_fields">
		<form action=".?e=<?php echo $event_id;?>" method="POST">
			<input type="hidden" name="action" value="edit_volunteer"/>
			<input type="hidden" name="event" value="<?php echo $_POST['event']; ?>"/>
			<input class="form_text_field sign_up_field" type="text" name="fname" placeholder="First Name" value="<?php if(isset($data['fname'])) echo sanitizeHTML($data['fname']); ?>" autofocus/>
			<input class="form_text_field sign_up_field" type="text" name="lname" placeholder="Last Name" value="<?php if(isset($data['lname'])) echo sanitizeHTML($data['lname']); ?>"/>
			<?php if(!user_exists($data['email'])): ?>
				<input class="form_text_field sign_up_field" type="text" name="email" placeholder="Email" value="<?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?>"/>
			<?php else: ?>
				<div class="form_text_field sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px"><?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?></div>
			<?php endif; ?>
			<input class="form_text_field sign_up_field phone_number" maxlength="10" type="text" name="phone" placeholder="Phone Number"  value="<?php if(isset($data['phone'])) echo $data['phone']; ?>"/>
			<br />
			<?php if(isset($volunteer_edit_error)):
				echo "<span style='color:#f00'>".$volunteer_edit_error."</span><br /><br />";
			endif; ?>
			<br />
			<input class="button submit_button sign_up_field" type="submit" value="Edit"/>
			<a class="button submit_button sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px" href=".?e=<?php echo $event_id; ?>">Cancel</a>
		</form>
	</div>
</div>