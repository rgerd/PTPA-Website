<?php
	$task = get_task($_POST['task']);
	$comments_enabled = $task['comments'];
?>

<form>
	<input class="form_text_field" type="text" name="fname" placeholder="First Name"/>
	<input class="form_text_field" type="text" name="lname" placeholder="Last Name"/>
	<input class="form_text_field" type="text" name="email" placeholder="Email"/>
	<input class="form_text_field" type="text" name="phone" placeholder="Phone Number"/>
	<?php if($comments_enabled): ?>
	<textarea class="form_text_field" type="text" name="comments" rows="4" placeholder="Comments"></textarea>
	<?php endif; ?>
	<br />
	<input class="button submit_button" type="submit" value="Sign Up!"/>
</form>