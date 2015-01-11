<?php 
	if(isset($_POST['event_id'])) {
		echo '<input type="hidden" name="event_id" value="'.$_POST['event_id'].'"/>';
	} else if(isset($event_id)) {
		echo '<input type="hidden" name="event_id" value="'.$event_id.'"/>';
	}
?>

<input type="hidden" id="deleted_tasks" name="deleted_tasks" value=""/>

<div class="footer creator_footer">
	<div class="footer_left">
		<a class="button light_button" href=".">Cancel</a><br />
		<a class="button light_button" href=".?a=delete&e=<?php echo $event_id; ?>" onclick="return confirm('Are you sure you wish to delete this event? (This cannot be undone)');">Delete Event</a>
    </div>
    <div class="footer_right">
    	<input class="button light_button" type="submit" name="action" value="Reminders"/><br />
    	<input class="button light_button" type="submit" name="action" value="Preview"/>
    	<input class="button light_button" type="submit" name="action" value="Save"/>
    </div>
</div>
</form>