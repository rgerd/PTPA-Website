var changePassword = false;

$(document).ready(function() {
	$("#new_pword").click(function() {
		changePassword = !changePassword;
		$("#pword_input").slideToggle(100, function() {
			$("#new_pword").html(changePassword ? "Cancel" : "Change Password");
			$("#change_password").attr("value", changePassword ? "yes" : "no");
		});
	});
});