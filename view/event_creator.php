<script type="text/javascript" src="js/event_creator.js"></script>
<form method = "POST" action=".">
<div class="event_creator_top_div">
    <input class="event_creator_top_field" type="text" name="event_title" placeholder="Event Name"/>
    <!--<input class="event_creator_top_field" type="text" name="event_date" id="datepicker" placeholder="Event Date/Time"/>-->
    <textarea id="event_creator_textarea" class="event_creator_top_field" type="text" name="event_desc" rows="4" placeholder="Event Description"></textarea>
</div>

<fieldset>
	<legend>Date</legend>
	<div id="datepicker"></div>
</fieldset>
<input type="hidden" id="event_date_input" name="event_date" />
<br />

<!-- ALL DAY? 
<div>
Time: <input type="number"/> : <input type="number"/> 
</div>
-->

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

<div id="event_creator_add_button">Add Task</div>
<br />
<input class="solid_button" type="submit" value="Save!"/>
<input type="hidden" name="action" value="save_event"/>
<?php include 'event_creator_footer.php'; ?>
</form>





<!--
	<div id="event_creator_task_header">
		<div style="display: table-row;">
			<div style="display: table-cell;">
				Hello
			</div>
			<div style="display: table-cell;">
				Hello
			</div>
			<div style="display: table-cell;">
				Hello
			</div>
			<div style="display: table-cell;">
				Hello
			</div>
		</div>
	</div>
	</div>
-->