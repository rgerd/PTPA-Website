<script type="text/javascript" src="js/reminders.js"></script>
<script type="text/javascript">
    function insertExistingReminders() {
        <?php foreach($reminders as $reminder) {
            switch($reminder['date_type']) {
                case 0:
                    echo 'createReminder('.$reminder['ID'].', "'.$reminder['reminder_date'].'");';
                break;
                case 1:
                    echo "document.getElementById('day_before').checked = true;";
                break;
                case 2:
                    echo "document.getElementById('week_before').checked = true;";
                break;
            }
        }
        ?>
    }
</script>

<div style="text-decoration: underline;">Reminders</div>
<br />
<div>
    Event: <?php echo $event['title']; ?><br />
    Date: <?php echo convert_date($event['event_date'], 'm/d/Y'); ?><br />
    Description: <?php echo sanitizeHTML($event['description']); ?>
</div>
<br /><br />
<div>
    <form method="post" action=".">
        <input type="checkbox" id="week_before" name="week_before"/> A week before <br />
        <input type="checkbox" id="day_before" name="day_before"/> The day before <br />
        <br /><br />
        <div id="datepicker"></div>
        <button type="button" class="button light_button" onclick="addNewReminder()">Add Custom Date</button>
        <br /><br />
        <table id="reminders_table">
            <thead>
                <tr>
                    <td id="custom_dates_title" style="display: none;">Custom Dates</td>
                </tr>
            </thead>
            <tbody id="table_body"></tbody>
        </table>
        <br />
        <input type="hidden" id="deleted_reminders" name="deleted_reminders" value=""/>
        <input type="hidden" name="action" value="save_event_reminders"/>
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>"/>
        <?php foreach($reminders as $reminder) {
            switch($reminder['date_type']) {
                case 1:
                    echo '<input type="hidden" name="day_before_id" value="'.$reminder['ID'].'"/>';
                break;
                case 2:
                    echo '<input type="hidden" name="week_before_id" value="'.$reminder['ID'].'"/>';
                break;
            }

        }
        ?>
        <input type="submit" class="button light_button" value="Save"/><br />
        <a href=".?e=<?php echo $event_id;?>" class="button light_button">Cancel</a>
    </form>
</div>
<input type="hidden" id="reminder_date" value=""/>