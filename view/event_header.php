<div class="event_details">
    <div class="details_element" id="details_title"><?php echo sanitizeHTML($event['title']); ?></div>
    <div class="details_element"><?php echo date_format(date_create($event['event_date']), 'm/d/Y'); ?></div>
    <div class="details_element"><?php echo sanitizeHTML($event['description']); ?></div>
</div>