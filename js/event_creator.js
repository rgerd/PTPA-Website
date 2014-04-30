var event_task_id = 0;

$(document).ready(function() {
	$("#event_creator_add_button").click(function() {
		$("#event_creator_task_container").append(createEventTask(event_task_id));
		$("#" + event_task_id).fadeIn();
		event_task_id++;
		loadMethods();
	});
});


function loadMethods() {
	$(".event_creator_delete_button").click(function() {
		var id = $(this).attr("task_id");
		$("#" + id).fadeOut(function() { $(this).remove();});
	});

	$(".event_creator_slots").keypress(function(event) {
		event.preventDefault();
		// 0 = 48
		// 9 = 57

		var code = event.which;
		if(code < 49 || code > 57)
			return;

		$(this).val((code - 48) + "");
	});
}

function createEventTask(_event_task_id) {
	var _container = document.createElement("div");
	
	var container = document.createElement("div");
	container.className = "event_creator_task";
	container.id = _event_task_id;
	container.style.display = "none";
	_container.appendChild(container);
	
	var title_input = document.createElement("input");
	title_input.className = "event_creator_task_title";
	title_input.type = "text";
	container.appendChild(title_input);

	var slots_input = document.createElement("input");
	slots_input.className = "event_creator_slots";
	slots_input.type = "text";
	slots_input.maxLength = 1;
	container.appendChild(slots_input);
	
	var comments_input = document.createElement("input");
	comments_input.className = "event_creator_comments_checkbox";
	comments_input.type = "checkbox";
	container.appendChild(comments_input);
	
	var delete_button = document.createElement("div");
	delete_button.className = "event_creator_delete_button";
	delete_button.setAttribute("task_id", _event_task_id);
	var delete_text = document.createTextNode("Delete");
	delete_button.appendChild(delete_text);
	container.appendChild(delete_button);

	return _container.innerHTML;
}