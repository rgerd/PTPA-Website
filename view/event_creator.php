<script type="text/javascript" src="js/event_creator.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#datepicker").datepicker('setDate', '<?php echo $preview['event_date']; ?>');
        <?php       
        $event_task_index = 0;
        while(true):
            $v = 'event_task_'.$event_task_index;
            if(isset($preview[$v])):
                $title = sanitize($preview[$v."_title"]);
                $slots = sanitize($preview[$v."_slots"]);
                $comments = isset($preview[$v."_comments"]) ? "true" : "false";
        ?>
        createEventTask("<?php echo $title;?>", "<?php echo $slots;?>", <?php echo $comments; ?>);
        $("#" + (event_task_id - 1)).show(0);
        <?php   
            else:
                break;
            endif;
            $event_task_index++;
        endwhile;
        ?>
        loadMethods();
    });
</script>
<form method = "POST" action=".">
<div class="event_creator_top_div">
    <input class="event_creator_top_field" type="text" name="event_title" placeholder="Event Name" value="<?php echo $preview['event_title'];?>"/>
    <textarea id="event_creator_textarea" class="event_creator_top_field" type="text" name="event_desc" rows="4" placeholder="Event Description"><?php echo $preview['event_desc'];?></textarea>
</div>

<fieldset id="date_fieldset">
	<legend id="date_legend">Date</legend>
	<div id="datepicker"></div>
</fieldset>
<input type="hidden" id="event_date_input" name="event_date" value="<?php echo $preview['event_date']; ?>" />
<br /><br />

<div id="event_creator_task_container">
        <table id="event_tasks_table" style="display:none;">
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
<?php include 'event_creator_footer.php'; ?>
</form>