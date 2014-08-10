jQuery.fn.putCursorAtEnd = function() {
  return this.each(function() {
    $(this).focus()
    if (this.setSelectionRange) {
      var len = $(this).val().length * 2;
      this.setSelectionRange(len, len);
    } else {
      $(this).val($(this).val());      
    }
    this.scrollTop = 999999;
  });
};

$("#search").putCursorAtEnd();

$(document).ready(function() {
	$("#sign_in_focus").focus();
	var tabs_div = $("#tabs");
	var tabs = tabs_div.find("#tab_bar").children(".tab");

	tabs.each(function() {
		var _content = this.getAttribute("content");
		var content = tabs_div.find(_content);
		if(this.getAttribute("top") == "true") {
			$(this).addClass("selected");
			content.css("display", "block");
			$(_content + "_focus").putCursorAtEnd();
		} else {
			content.css("display", "none");
		}
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
				$(_content + "_focus").putCursorAtEnd();
			} else {
				$(this).removeClass("selected");
				content.css("display", "none");
			}
			index++;
		});
	});

	$(".error_message").slideDown(450).delay(10000).slideUp(450);
});

