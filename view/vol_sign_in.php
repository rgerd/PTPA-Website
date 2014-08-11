<div id="event_container">
	<div id="task_sign_up_title">Please enter your email to sign in as a volunteer.</div>
	<br />
	<form action=".?e=<?php echo $event_id; ?>" method="post">
		<input class="form_text_field sign_up_field focus_field" type="text" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
		<br />
		<?php if(isset($vol_sign_in_error)):
			echo "<span style='color:#f00'>".$vol_sign_in_error."</span><br /><br />";
		endif; ?>
		<input class="button submit_button sign_up_field" type="submit" style="margin-bottom: 5px;" value="Sign In"/>
		<input type="hidden" name="action" value="vol_sign_in"/>
		<input type="hidden" name="event" value="<?php echo $event_id; ?>"/>
	</form>
	<a class="button sign_up_field" href=".?e=<?php echo $event_id;?>" style="padding: 5px 0px 5px 0px; width: 196px; margin-top: 5px;">Cancel</a>
</div>