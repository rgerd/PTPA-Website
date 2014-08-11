<?php
	if(!isset($volunteer) && $volunteer_id != -1)
		$volunteer = get_user($volunteer_id);

	$data = isset($volunteer) ? $volunteer : $_POST;
?>

<div id="event_container">
	<div id="task_sign_up_title">Contact Event Creator</div>
	<div id="task_sign_up_desc">
		To send questions or comments to the creator of this event, you may type your message below and click send.<br />
		So that the event creator can get back to you, please also fill out the following fields:
	</div>
	<br />
	<form action=".?e=<?php echo $event_id; ?>" method="POST">
		<input type="hidden" name="action" value="send_message"/>
		<?php if(isset($signup)): ?>
			<input type="hidden" name="signup" value="<?php echo $signup['ID']; ?>"/>
		<?php endif; ?>
		<input class="form_text_field sign_up_field" type="text" name="fname" placeholder="First Name" value="<?php if(isset($data['fname'])) echo sanitizeHTML($data['fname']); ?>" autofocus/>
		<input class="form_text_field sign_up_field" type="text" name="lname" placeholder="Last Name" value="<?php if(isset($data['lname'])) echo sanitizeHTML($data['lname']); ?>"/>
		<?php if(!user_exists($data['email'])): ?>
				<input class="form_text_field sign_up_field" type="text" name="email" placeholder="Email" value="<?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?>"/>
		<?php else: ?>
			<div class="form_text_field sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px"><?php if(isset($data['email'])) echo sanitizeHTML($data['email']); ?></div>
		<?php endif; ?>
		<input class="form_text_field sign_up_field phone_number" maxlength="10" type="text" name="phone" placeholder="Phone Number"  value="<?php if(isset($data['phone'])) echo format_number($data['phone']); ?>"/>
		
		<textarea class="form_text_field sign_up_field" type="text" name="message" rows="4" placeholder="Message"><?php if(isset($data['comment'])) echo sanitizeTXT($data['comment']); ?></textarea>
		<br />
		<?php if(isset($contact_creator_error)):
			echo "<span style='color:#f00'>".$contact_creator_error."</span><br /><br />";
		endif; ?>
		<br />
		<input class="button submit_button sign_up_field" type="submit" value="Send"/>
		<a class="button submit_button sign_up_field" style="padding: 5px 0px 5px 0px; width: 196px" href=".?e=<?php echo $event_id; ?>">Cancel</a>
		<br />
	</form>
</div>