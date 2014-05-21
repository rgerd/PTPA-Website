var event_task_id = 0;
var event_task_table_showing = false;

$(document).ready(function() {
	$("#event_creator_add_button").click(function() {
		createEventTask();
		$("#" + (event_task_id - 1)).fadeIn();
		loadMethods();
	});

	$("#datepicker").datepicker(
	{
		dateFormat: "yy-mm-dd",
		onSelect: function(date) {
			$("#event_date_input").val(date);
		}
	});
});


function loadMethods() {
	$(".delete_button").click(function() {
		var id = $(this).attr("task_id");
		$("#" + id).fadeOut(function() { $(this).remove();});
	});

	$(".event_creator_slots").keypress(function(event) {
		// 0 = 48
		// 9 = 57

		var code = event.which;
		if(code < 48 || code > 57)
			event.preventDefault();
	});
}

function createEventTask() {
	createEventTask("", "", false);
}

function createEventTask(_title, _numSlots, _comments) {
	var container = document.createElement("tr");
	container.className = "event_creator_task";
	container.id = event_task_id;
	container.style.display = "none";

    var td_title = document.createElement("td");
    var td_div_title = document.createElement("div");
    td_div_title.className = "td_div";
	var title_input = document.createElement("input");
	title_input.name = "event_task_" + event_task_id + "_title";
	title_input.className = "event_creator_task_title";
	title_input.type = "text";
	if(_title)
		title_input.value = _title;
	//title_input.placeholder = "Task Description";
	td_div_title.appendChild(title_input);
    td_title.appendChild(td_div_title);
    container.appendChild(td_title);

    var td_slots = document.createElement("td");
    var td_div_slots = document.createElement("div");
    td_div_slots.className = "td_div";
	var slots_input = document.createElement("input");
	slots_input.name = "event_task_" + event_task_id + "_slots";
	slots_input.className = "event_creator_slots";
	slots_input.type = "number";
	if(_numSlots)
		slots_input.value = _numSlots;
	td_div_slots.appendChild(slots_input);
    td_slots.appendChild(td_div_slots);
    container.appendChild(td_slots);

    var td_comments = document.createElement("td");
    var td_div_comments = document.createElement("div");
    td_div_comments.className = "td_div";
	var comments_input = document.createElement("input");
	comments_input.name = "event_task_" + event_task_id + "_comments";
	comments_input.className = "event_creator_comments_checkbox";
	comments_input.type = "checkbox";
	comments_input.checked = _comments;
	td_div_comments.appendChild(comments_input);
    td_comments.appendChild(td_div_comments);
    container.appendChild(td_comments);

    var td_delete = document.createElement("td");
	var delete_button = document.createElement("div");
	delete_button.className = "button light_button delete_button";
	delete_button.setAttribute("task_id", event_task_id);
	var delete_text = document.createTextNode("Delete");
	delete_button.appendChild(delete_text);
	td_delete.appendChild(delete_button);
    container.appendChild(td_delete);

    var task_id_hidden_input = document.createElement("input");
    task_id_hidden_input.name = "event_task_" + event_task_id;
    task_id_hidden_input.value = event_task_id;
    task_id_hidden_input.type = "hidden";
    container.appendChild(task_id_hidden_input);
    
    if(!event_task_table_showing) {
    	$("#event_tasks_table").show(0);
    	event_task_table_showing = true;
    }
    
	document.getElementById("table_body").appendChild(container);
	event_task_id++;
}