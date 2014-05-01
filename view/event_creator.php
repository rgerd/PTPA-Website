<script type="text/javascript" src="js/event_creator.js"></script>
<div class="event_creator_top_div">
    <input class="event_creator_top_field" type="text" name="event_name" placeholder="Event Name"/>
    <input class="event_creator_top_field" type="text" name="event_date" placeholder="Event Date/Time"/>
    <textarea class="event_creator_top_field" type="text" name="event_desc" rows="4" placeholder="Event Description"></textarea>
</div>

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
<div id="event_creator_task_container">
        <table>
            <thead>
            <th>Description</th>
            <th>Number of Signups</th>
            <th>Comments</th>
            <th>\n</th>
            </thead>
            <tbody id="table_body"></tbody>
        </table>
</div>

<div id="event_creator_add_button">Add Task</div>