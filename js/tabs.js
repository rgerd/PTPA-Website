$(document).ready(function() {
	var tabs_div = $("#tabs");
	var tabs = tabs_div.find("#tab_bar").children(".tab");


	var foundFirstTab = false;
	tabs.each(function() {
		var _content = this.getAttribute("content");
		var content = tabs_div.find(_content);
		if(!foundFirstTab) {
			$(this).addClass("selected");
			content.css("display", "block");
		} else {
			content.css("display", "none");
		}
		foundFirstTab = true;
	});

	$(".tab").click(function() {
		var __content = $(this).attr("content");
		var index = 0;
		tabs.each(function() {
			var _content = this.getAttribute("content");
			var content = tabs_div.find(_content);
			if(_content == __content) {
				$(this).addClass("selected");
				content.css("display", "block");
			} else {
				$(this).removeClass("selected");
				content.css("display", "none");
			}
			index++;
		});
	});
});