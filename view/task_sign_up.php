<?php
	$task = get_task($_POST['task']);
	$comments_enabled = $task['comments'];
?>

<form>
	<input type="text" name="fname" placeholder="First Name"/>
	<input type="text" name="lname" placeholder="Last Name"/>
	<input type="text" name="email" placeholder="Email"/>
	<input type="text" name="phone" placeholder="Phone Number"/>
	<?php if($comments_enabled): ?>
	<textarea type="text" name="comments" rows="4" placeholder="Comments"></textarea>
	<?php endif; ?>
</form>