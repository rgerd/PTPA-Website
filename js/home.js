$(document).ready(function() {
	var _globalConfig = {
			swfPath: "js/ZeroClipboard/ZeroClipboard.swf",
		  	hoverClass: "share_button_hover",
  			activeClass: "share_button_active",
  			forceHandCursor: true,
	}
	ZeroClipboard.config(_globalConfig);

	var client = new ZeroClipboard($(".share_button"));
	client.on("complete", function(client, args) {
		alert("The link to access this event has been copied to your clipboard.");
	});
});