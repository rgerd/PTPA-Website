$(document).ready(function() {
	/*
	$(".event_task_expander").click(function() {
		var _this = $(this);
		var expanded = _this.attr("expanded");
		var dets = _this.parent().parent().find(".event_task_details");
		if(expanded == "true") {
			dets.stop().slideToggle(200, function()
			{_this.css("background-image", 'url(css/images/plus.png)');});
			expanded = "false";
		} else {
			dets.stop().slideToggle(200, function()
			{_this.css("background-image", 'url(css/images/minus.png)');});
			expanded = "true";
		}

		$(this).attr("expanded", expanded);
	});
	*/

	$(".event_task_expander").click(function() {
		expandTask($(this));
	});

	$(".event_task_title").click(function() {
		var exp = $(this).find(".event_task_expander");
		expandTask(exp);
	});

	function expandTask(expander) {
		var expanded = expander.attr("expanded");
		var dets = expander.parent().parent().find(".event_task_details");
		if(expanded == "true") {
			dets.stop().slideToggle(200, function()
			{expander.css("background-image", 'url(css/images/plus.png)');});
			expanded = "false";
		} else {
			dets.stop().slideToggle(200, function()
			{expander.css("background-image", 'url(css/images/minus.png)');});
			expanded = "true";
		}

		expander.attr("expanded", expanded);
	}
});