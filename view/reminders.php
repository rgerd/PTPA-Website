<script type="text/javascript" src="js/reminders.js"></script>
<script type="text/javascript">
    function insertExistingReminders() {
        <?php foreach($reminders as $reminder) {
            echo 'createReminder('.$reminder['ID'].', "'.$reminder['reminder_date'].'");';
        }
        ?>
    }
</script>

<div style="text-decoration: underline;">Reminders</div>
<br />
<div>
    Event: <?php echo $event['title']; ?><br />
    Date: <?php echo $event['event_date']; ?><br />
    Description: <?php echo $event['description']; ?>
</div>
<br /><br />
<div>
    <form method="post" action=".">
        <input type="checkbox" name="week_before"/> A week before <br />
        <input type="checkbox" name="day_before"/> The day before <br />
        <br /><br />
        <div id="datepicker"></div>
        <button type="button" onclick="addNewReminder()">Add Custom Date</button>
        <br /><br />
        <table id="reminders_table">
            <thead>
                <tr>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody id="table_body"></tbody>
        </table>
        <br />
        <input type="hidden" name="deleted_reminders" value=""/>
        <input type="submit" value="Save"/>
    </form>
</div>
<input type="hidden" id="reminder_date" value=""/>