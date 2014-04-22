<div id="tabs">
    <div id="bounding_tabs">
	<ul id="tab_bar">
		<li id = "_sign_in" class="tab" content="#sign_in" <?php if($top_tab == "sign_in" || !$top_tab) echo 'top="true"'; ?>>Sign In</li>
		<li id = "_sign_up" class="tab" content="#sign_up" <?php if($top_tab == "sign_up") echo 'top="true"'; ?>>Sign Up</li>
	</ul>

	<div id="sign_in" class="tab_content">
		<form id="sign_in_form" method="POST" action=".">
			<input class="front_input form_text_field" type="text" name="email" value="<?php if($action == "sign_in") echo $email; ?>" spellcheck = "false" autocorrect = "false" placeholder="Email"/>
			<input class="front_input form_text_field" type="password" name="password" spellcheck = "false" autocorrect = "false" placeholder="Password"/>
			<span style="background-color: #E0E0E0;"><input class="front_input _3D" type="submit" spellcheck = "false" autocorrect = "false"  value="Sign In!"/></span>
			<?php if($sign_in_error_message) echo '<div class="error_message">'.$sign_in_error_message.'</div>'; ?>
			<input name="action" type="hidden" value="sign_in"/>
		</form>
	</div>
	<div id="sign_up" class="tab_content">
		<form id="sign_up_form" method="POST" action=".">
			<input class="front_input form_text_field" type="text" name="fname" value="<?php if($action == "sign_up") echo $fname; ?>" spellcheck = "false" autocorrect = "false" placeholder="First Name"/>
			<input class="front_input form_text_field" type="text" name="lname" value="<?php if($action == "sign_up") echo $lname; ?>" spellcheck = "false" autocorrect = "false" placeholder="Last Name"/>
			<input class="front_input form_text_field" type="text" name="email" value="<?php if($action == "sign_up") echo $email; ?>" spellcheck = "false" autocorrect = "false" placeholder="Email"/>
			<input class="front_input form_text_field" type="text" name="pnum" value="<?php if($action == "sign_up") echo $pnum; ?>" spellcheck = "false" autocorrect = "false" placeholder="Phone Number"/>
			<input class="front_input form_text_field" type="password" name="password" spellcheck = "false" autocorrect = "false" placeholder="Password"/>
			<span style="background-color: #E0E0E0;"><input class="front_input _3D" type="submit" spellcheck = "false" autocorrect = "false"  value="Sign Up!"/></span>
			<?php if($sign_up_error_message) echo '<div class="error_message">'.$sign_up_error_message.'</div>'; ?>
			<input name="action" type="hidden" value="sign_up"/>
		</form>
	</div>
    </div>
</div>