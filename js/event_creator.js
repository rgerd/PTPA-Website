var event_task_id = 0;

$(document).ready(function() {
	$("#add_event_task").click(function() {
		$("#edit_event_tasks").append(
			'<div class="edit_event_task" style="display:none;"\
			id="'+event_task_id+'""><input class="task_title_input"\
			type="text" /><input class="comments_checkbox" type="checkbox" />\
			<div class="delete_button" task_id="' + event_task_id + '">Delete</div></div>'
		);
		$("#" + event_task_id).fadeIn();
		event_task_id++;
		loadMethods();
	});
});


function loadMethods() {
	$(".delete_button").click(function() {
		var id = $(this).attr("task_id");
		$("#" + id).fadeOut(function() { $(this).remove();});
	});
}