$(document).ready(function() {
	$(".event_task_expander").click(function() {
		var _this = $(this);
		var expanded = _this.attr("expanded");
		var dets = _this.parent().parent().find(".event_task_details");
		if(expanded == "true") {
			dets.slideUp(500, function() 
			{_this.css("background-image", 'url(css/images/plus.png)');});
			expanded = "false";
		} else {
			dets.slideDown(500, function()
			{_this.css("background-image", 'url(css/images/minus.png)');});
			expanded = "true";
		}

		$(this).attr("expanded", expanded);
	});
});