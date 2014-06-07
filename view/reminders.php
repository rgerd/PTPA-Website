<script type="text/javascript" src="js/reminders.js"></script>
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
        <br />
        <button>Add Custom Date</button>
        <table> 
        <?php foreach($reminders as $reminder): ?>
            <tr>
                <td><div><?php echo $reminder['reminder_date']; ?></div></td>
                <td><button>Delete</button></td>

            </tr>
        <?php endforeach; ?>
        </table>
        <br />
        <input type="submit" value="Save"/>
    </form>
</div>