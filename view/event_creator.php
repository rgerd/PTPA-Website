<script type="text/javascript" src="js/event_creator.js"></script>
<form method = "POST" action=".">
<div class="event_creator_top_div">
    <input class="event_creator_top_field" type="text" name="event_title" placeholder="Event Name"/>
    <textarea id="event_creator_textarea" class="event_creator_top_field" type="text" name="event_desc" rows="4" placeholder="Event Description"></textarea>
</div>

<fieldset id="date_fieldset">
	<legend id="date_legend">Date</legend>
	<div id="datepicker"></div>
</fieldset>
<input type="hidden" id="event_date_input" name="event_date" />
<br /><br />

<div id="event_creator_task_container">
        <table id="event_tasks_table">
            <thead>
            <th class="th" id="th_desc">Description</th>
            <th class="th" id="th_signups">Number&nbspof&nbspSignups</th>
            <th class="th">Comments</th>
            <th class="th" id="th_delete"> </th>
            </thead>
            <tbody id="table_body"></tbody>
        </table>
</div>

<div id="event_creator_add_button" class="button event_creator_add_button">Add Task</div>
<br /><br />
<input type="hidden" name="action" value="save_event"/>
<?php include 'event_creator_footer.php'; ?>
</form>