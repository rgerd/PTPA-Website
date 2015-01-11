var reminder_id = 0;
var deleted_reminders = [];
var reminders_table_showing = false;

$(document).ready(function() {
	$("#datepicker").datepicker(
	{
		dateFormat: "yy-mm-dd",
		onSelect: function(date) {
			$("#reminder_date").val(date);
		}
	});

	insertExistingReminders();
	loadMethods();
});

function loadMethods() {
	$("#reminders_table").on("click", ".delete_button", function() {
		var id = $(this).attr("reminder_id");
		//$("#" + id).fadeOut(function() { $(this).remove();});
		var __id = $("#reminder_" + id + "_id").val();
		if(__id != -1 && jQuery.inArray(__id, deleted_reminders) == -1) {
			deleted_reminders.push(__id);
			$("#deleted_reminders").attr("value", deleted_reminders.join());
		}
		$("#" + id).animate({opacity: "hide"}, 500, function() { $(this).remove(); if(reminder_id == 0) {$("#reminders_table").hide(0);reminder_table_showing = false;}});

		var _id = parseInt(id);
		for(var i = _id + 1; i < reminder_id; ++i) {
			var _i = i - 1;
			$("#" + i).attr("id", function(arr) {return _i;});
			$("#reminder_" + i + "_date").attr("id", function(arr) {return "reminder_" + (_i) + "_date";});
			$("#reminder_" + i + "_date_input").attr("name", function(arr) {return "reminder_" + (_i) + "_date";});
			$("#reminder_" + i + "_date_input").attr("id", function(arr) {return "reminder_" + (_i) + "_date_input";});
			$("#reminder_" + i + "_delete_button").attr("name", function(arr) {return "reminder_" + (_i) + "_slots";});
			$("#reminder_" + i + "_delete_button").attr("reminder_id", _i);
			$("#reminder_" + i + "_delete_button").attr("id", function(arr) {return "reminder_" + (_i) + "_delete_button";});
			$("#reminder_" + i).attr("value", function(arr) {return _i;});
			$("#reminder_" + i).attr("name", function(arr) {return "reminder_" + (_i);});
			$("#reminder_" + i).attr("id", function(arr) {return "reminder_" + (_i);});
			$("#reminder_" + i + "_id").attr("name", function(arr) {return "reminder_" + (_i) + "_id";});
			$("#reminder_" + i + "_id").attr("id", function(arr) {return "reminder_" + (_i) + "_id";});
		}
		reminder_id--;
	});
}

function addNewReminder() {
	var _date = document.getElementById("reminder_date").value;
	if(_date == "") {
		alert("Please select a date!");
		return;
	}
	createReminder(-1, _date);
	$("#datepicker").datepicker('setDate');
	$("#reminder_date").val("");
}

/*
	Converts for 'murica
*/
function convertDate(_date) {
	console.log(_date);
	var date = new Date(_date);
	var day = date.getDate() + 1;
	day = day < 10 ? "0" + day : "" + day;
	var month = date.getMonth() + 1;
	month = month < 10 ? "0" + month : "" + month;
	var year = date.getFullYear();

	return month + "/" + day + "/" + year;
}

function createReminder(_id, _date) {
	var container = document.createElement("tr");
	container.className = "reminder";
	container.id = reminder_id;

	var date = document.createElement("td");
	date.id = "reminder_" + reminder_id + "_date";
	date.appendChild(document.createTextNode(convertDate(_date)));
	container.appendChild(date);

	var date_input = document.createElement("input");
	date_input.id = "reminder_" + reminder_id + "_date_input";
	date_input.type = "hidden";
	date_input.name = "reminder_" + reminder_id + "_date";
	date_input.value = _date;
	container.appendChild(date_input);

	var delete_button = document.createElement("div");
	delete_button.id = "reminder_" + reminder_id + "_delete_button";
	delete_button.className = "button light_button delete_button";
	delete_button.setAttribute("reminder_id", reminder_id);
	delete_button.appendChild(document.createTextNode("Delete"));
	var delete_button_container = document.createElement("td");
	delete_button_container.appendChild(delete_button);
	container.appendChild(delete_button_container);

	var reminder_internal_id_hidden_input = document.createElement("input");
    reminder_internal_id_hidden_input.id = "reminder_" + reminder_id;
    reminder_internal_id_hidden_input.name = "reminder_" + reminder_id;
    reminder_internal_id_hidden_input.value = reminder_id;
    reminder_internal_id_hidden_input.type = "hidden";
    container.appendChild(reminder_internal_id_hidden_input);

    var reminder_id_hidden_input = document.createElement("input");
    reminder_id_hidden_input.id = "reminder_" + reminder_id + "_id";
    reminder_id_hidden_input.name = "reminder_" + reminder_id + "_id";
    reminder_id_hidden_input.value = _id;
    reminder_id_hidden_input.type = "hidden";
    container.appendChild(reminder_id_hidden_input);



    if(!reminders_table_showing) {
    	$("#custom_dates_title").show(0);
    	$("#reminders_table").show(0);
    	reminders_table_showing = true;

    }

	document.getElementById("table_body").appendChild(container);
	reminder_id++;
}