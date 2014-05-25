<div class="footer preview_footer">
	<div class="footer_left">
		<form method="post" action=".">
    <?php 
  if(isset($_POST['event_id'])) {
    echo '<input type="hidden" name="event_id" value="'.$_POST['event_id'].'"/>';
  } else if(isset($event_id)) {
    echo '<input type="hidden" name="event_id" value="'.$event_id.'"/>';
  }
?>
			<input type="hidden" name="action" value="preview_edit"/>
			<input class="button light_button" type="submit" value="Edit"/>
		</form>
    </div>
    <div class="footer_right">
   		<form method="post" action=".">
        <?php 
  if(isset($_POST['event_id'])) {
    echo '<input type="hidden" name="event_id" value="'.$_POST['event_id'].'"/>';
  } else if(isset($event_id)) {
    echo '<input type="hidden" name="event_id" value="'.$event_id.'"/>';
  }
?>
   			<input type="hidden" name="action" value="preview_save"/>
    		<input class="button light_button" type="submit" value="Save"/>
    	</form>
    </div>
</div>