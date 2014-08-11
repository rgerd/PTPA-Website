$(document).ready(function() {
	$("#nav_bar").on('dragstart', function(event) {event.preventDefault();});

	var info_width;

	$(".info_request").mouseenter(function(event) {
		var info = $(this).attr("info");
		$("#info").html(info);
		info_width = $("#info").width() + 10 * 2 + 2 * 2;
		moveInfo(event);
		$("#info").css("display", "block");
	});

	$(".info_request").mousemove(function(event) {
		moveInfo(event);
	});

	$(".info_request").mouseleave(function() {
		$("#info").css("display", "none");
	});


	function moveInfo(event) {
		var x = event.pageX + 10;
		var y = event.pageY + 10;

		x = x < 0 ? 0 : x;
		y = y < 0 ? 0 : y;

		var info = $("#info");
		var win = $(document);

		var i_w = info_width;
		var i_h = info.height();
		var w_w = win.width();
		var w_h = win.height();

		var right = x + i_w;
		var bottom = y + i_h;

		x = right >= w_w ? w_w - i_w : x;
		y = bottom >= w_h ? w_h - i_h : y;



		$("#info").offset({
			top: y + 10,
			left: x + 10
		});
	}
});