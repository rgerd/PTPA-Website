<?php $user = get_user($user_id); ?>

<span style="text-decoration: underline;">Account Manager</span>
<div style="float:left; display: block; text-decoration: none; font-size: 1.5em; color: #999;">Account Manager</div>

<div stye="margin-left: 50px;">
	<form method="POST" action=".">
		<input type="hidden" name="action" value="update_acc"/><br />
		<input class="form_text_field" type="text" name="fname" value="<?php echo $user['fname']; ?>" placeholder="First Name"/>
		<input class="form_text_field" type="text" name="lname" value="<?php echo $user['lname']; ?>" placeholder="Last Name"/>
		<input class="form_text_field" type="text" name="email" value="<?php echo $user['email']; ?>" placeholder="Email"/>
		<input class="form_text_field" type="text" name="phone" value="<?php echo $user['phone']; ?>" placeholder="Phone Number"/>
		
		<input class="form_text_field" id="pword_input" style="display: none;" type="password" name="pword" placeholder="New Password"/>
		<input type="hidden" id="change_password" name="change_password" value="no"/>
		<button id="new_pword" type="button">Change Password</button>
		
		<br />
		<input style="margin-left: 0px" class="button" type="submit" value="Save"/><br />
		<a class="button" href=".">Cancel</a>
	</form>
</div>