$(document).ready(function() {
	$(".event_task_expander").click(function() {
		var expanded = $(this).attr("expanded");
		
		var dets = $(this).parent().parent().find(".event_task_details");
		if(expanded == "true") {
			dets.slideUp(500);
			expanded = "false";
		} else {
			dets.slideDown(500);
			expanded = "true";
		}

		$(this).attr("expanded", expanded);
	});
});