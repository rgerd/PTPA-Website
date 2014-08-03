<?php				
$_events = get_events_by_user($user_id);
$num_events = count($_events);
?>

<div id="home">
	<div id="top">
		<?php if($num_events != 0): ?>
		<div id="page_title" style="float:left;">Events</div>
		<?php endif; ?>
		<div  style="<?php echo $num_events == 0 ? "text-align:center;" : "float:right;"; ?> display: block;"><a style="text-decoration: none;" href=".?a=create_event"><div class="button">Create New Event</div></a></div>
	</div>

	<br />
	<br />
	<table id="events_table">
		<tbody>
			<?php
				foreach($_events as $event):
			?>
				<tr class="event">
						<td class="event_title"><a class="hover_link" href=".?e=<?php echo $event['ID']; ?>"><?php echo $event['title']; ?></a></td>
						<td class="event_description"><a class="hover_link" href=".?e=<?php echo $event['ID']; ?>"><?php echo removeAllNewLines($event['description'], true); ?></a></td>
						<td class="event_share"><button class="button share_button" data-clipboard-text="<?php echo "http://localhost:8888/PTPA-Website/index.php?e=".$event['ID']; ?>">Share</button></td>
				</tr>
			<?php
				endforeach;
			?>
		</tbody>
	</table>
</div>