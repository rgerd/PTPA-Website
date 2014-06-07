<script type="text/javascript" src="js/reminders.js"></script>
<div style="text-decoration: underline;">Reminders</div>
<br />
<div>
    Event: <?php echo $event_title; ?><br />
    Date: <?php echo $event_date; ?><br />
    Description: <?php echo $event_desc; ?>
</div>
<br /><br />
<div>
    <form method="post" action=".">
        <input type="checkbox" name="week_before"/> Week Before <br />
        <input type="checkbox" name="day_before"/> Day Before <br />
        <br />
        <button>Add Custom Date</button>
        <table>
            <tr>
                <td><div>06/07/14</div></td>
                <td><button>Delete</button></td>

            </tr>
        </table>
        <br />
        <input type="submit" value="Save"/>
    </form>
</div>