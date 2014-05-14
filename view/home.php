<div id="home">
	<div id="top">
		<div style="float:left; display: block; text-decoration: underline; font-size: 1.5em; color: #999;">Events</div>
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
						<td class="event_title"><a class="hover_link" href=".?e=<?php echo $event['ID']; ?>"><?php echo $event['title']; ?></a></td>
						<td class="event_description"><a class="hover_link" href=".?e=<?php echo $event['ID']; ?>"><?php echo $event['description']; ?></a></td>
						<td class="event_share"><a class="css_button_a"><button class="css_button_div_share" data-clipboard-text="<?php echo "http://localhost:8888/PTPA-Website/index.php?e=".$event['ID']; ?>">Share</button></a></td>
				</tr>
			<?php
				endforeach;
			?>
		</tbody>
	</table>
</div>