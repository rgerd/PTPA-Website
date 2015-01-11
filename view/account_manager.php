<?php $user = get_user($user_id); ?>

<!--<span style="text-decoration: underline;">Account Manager</span>-->
<div id="page_title" style="text-align: center;">Account Manager</div>

<div stye="text-align: center">
	<form method="POST" action=".">
		<input type="hidden" name="action" value="update_acc"/><br />
		<input class="form_text_field sign_up_field" type="text" name="fname" value="<?php echo $user['fname']; ?>" placeholder="First Name"/>
		<input class="form_text_field sign_up_field" type="text" name="lname" value="<?php echo $user['lname']; ?>" placeholder="Last Name"/>
		<input class="form_text_field sign_up_field" type="text" name="email" value="<?php echo $user['email']; ?>" placeholder="Email"/>
		<input class="form_text_field sign_up_field phone_number" type="text" name="phone" value="<?php echo format_number($user['phone']); ?>" placeholder="Phone Number"/>
		
		<input class="form_text_field sign_up_field" id="pword_input" style="display: none;" type="password" name="pword" placeholder="New Password"/>
		<input type="hidden" id="change_password" name="change_password" value="no"/>
		<button id="new_pword" class="button submit_button sign_up_field" style="font-size: 0.6em;" type="button">Change Password</button>
		<br />
		<input class="button submit_button sign_up_field" type="submit" value="Save"/>
		<a class="button sign_up_field link_button" href=".">Cancel</a>
	</form>
</div> 