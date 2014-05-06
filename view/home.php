<div id="home">
	<div id="top">
		<div style="float:left; display: block;">Events</div>
		<div  style="float:right; display: block;"><a class="css_button_a" href=".?a=create_event"><div class="css_button_div">Create New Event</div></a></div>
	</div>

	<br />
	<br />
	<table id="events_table">
		<tbody>
			<?php
				$_events = get_events_by_user($user_id);
				foreach($_events as $event):
			?>
				<tr class="event">
						<td class="event_title"><?php echo $event['title']; ?></td>
						<td class="event_description"><?php echo $event['description']; ?></td>
						<td class="event_share"><a class="css_button_a"><div class="css_button_div_share">Share</div></a></td>
				</tr>
			<?php
				endforeach;
			?>
		</tbody>
	</table>
</div>