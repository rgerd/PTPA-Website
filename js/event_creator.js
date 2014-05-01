var event_task_id = 0;

$(document).ready(function() {
	$("#event_creator_add_button").click(function() {
		$("#table_body").append(createEventTask(event_task_id));
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
	
	var container = document.createElement("tr");
	container.className = "event_creator_task";
	container.id = _event_task_id;
	container.style.display = "none";
	_container.appendChild(container);

    var td_title = document.createElement("td");
	var title_input = document.createElement("input");
	title_input.className = "event_creator_task_title";
	title_input.type = "text";
	td_title.appendChild(title_input);
    container.appendChild(td_title);

    var td_slots = document.createElement("td");
	var slots_input = document.createElement("input");
	slots_input.className = "event_creator_slots";
	slots_input.type = "text";
	slots_input.maxLength = 1;
	td_slots.appendChild(slots_input);
    container.appendChild(td_slots);

    var td_comments = document.createElement("td");
	var comments_input = document.createElement("input");
	comments_input.className = "event_creator_comments_checkbox";
	comments_input.type = "checkbox";
	td_comments.appendChild(comments_input);
    container.appendChild(td_comments);

    var td_delete = document.createElement("td");
	var delete_button = document.createElement("div");
	delete_button.className = "event_creator_delete_button";
	delete_button.setAttribute("task_id", _event_task_id);
	var delete_text = document.createTextNode("Delete");
	delete_button.appendChild(delete_text);
	td_delete.appendChild(delete_button);
    container.appendChild(td_delete);

	return _container.innerHTML;
}