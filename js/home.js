$(document).ready(function() {
	$(".share_button").each(function(i) {
		var clip = new ZeroClipboard($(this), {
			moviePath: "js/ZeroClipboard/ZeroClipboard.swf"
		});
		clip.on("load", function(client) {
			client.on("complete", function(client, args) {
				alert("The link to access this event has been copied to your clipboard.");
			});
		});
	});
});