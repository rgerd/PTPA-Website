<div id="event_container">
	<div id="task_sign_up_title">Please enter your email to sign in as a volunteer.</div>
	<br />
	<form action="." method="post">
		<input class="form_text_field sign_up_field" type="text" name="email" placeholder="Email" value=""/>
		<input class="button submit_button sign_up_field" type="submit" value="Sign In"/>
		<input type="hidden" name="action" value="vol_sign_in"/>
		<input type="hidden" name="event" value="<?php echo $event_id; ?>"/>
	</form>
</div>