<?php
/*Returns the events of a specific user.*/
function get_events_by_user($userID) {
    global $db;
    $query = "SELECT * FROM events WHERE accountID = '$userID'";
    $result = $db->query($query);
    $result = $result->fetchAll();
    return $result;
}

/*Returns the users signed up for a task.*/
function get_users_signed_up($taskID) {
    global $db;
    $query = "SELECT * FROM signups WHERE taskID = '$taskID'";
    $result = $db->query($query);
    return $result->fetchAll();
}

/**/
function get_unregistered_user($code) {
    global $db;
    $query = "SELECT * FROM accounts WHERE password = '$code' AND registered = 0";
    $results = $db->query($query);
    $results = $results->fetch();
    return $results;
}

/*Returns user given id*/
function get_user($id){
    global $db;
    $query = "SELECT * FROM accounts WHERE ID = '$id'";
    $results = $db->query($query);
    $results = $results->fetch();
    return $results;
}

/*Returns event given id*/
function get_event($id){
    global $db;
    $query = "SELECT * FROM events WHERE ID = '$id'";
    $results = $db->query($query);
    $results = $results->fetch();
    return $results;
}

/*Returns whether or not a user owns an event*/
function user_owns_event($user_id, $event_id) {
    return get_event($event_id)['accountID'] == $user_id;
}

/*Counts number of signups for a task*/
function count_signups($task){
    global $db;
    $query = "SELECT count(*) as num FROM signups WHERE taskID = '$task'";
    $results = $db->query($query);
    $results = $results->fetch();
    return $results['num'];
}

/*Creates new event and returns id*/
function add_event($accountID, $title, $date, $desc){
    global $db;
    $query = "INSERT INTO events (accountID, event_date, title, description) VALUES ('$accountID', '$date', '$title', '$desc')";
    $results = $db->exec($query);
    return $db->lastInsertId();
}

/*Updates an event after being edited*/
function update_event($id, $title, $date, $desc) {
    global $db;
    $query = "UPDATE events SET title='$title', event_date='$date', description='$desc' WHERE ID='$id'";
    $result = $db->exec($query);
    return $id;
}

/*Creates new task*/
function add_task($eventID, $internalID, $desc, $numSlots, $comments){
    global $db;
    $query = "INSERT INTO tasks (eventID, description, numSlots, internalID, comments) VALUES ('$eventID', '$desc', '$numSlots', '$internalID', '$comments')";
    $results = $db->exec($query);
}

/*Updates a task after being edited*/
function update_task($id, $internalID, $desc, $numSlots, $comments) {
    global $db;
    $query = "UPDATE tasks SET internalID='$internalID', description='$desc', numSlots='$numSlots', comments='$comments' WHERE ID='$id'";
    $result = $db->exec($query);
    return $result;
}

/*Deletes all of the tasks from an event after a certain internalID*/
function delete_extra_tasks($event_id, $last_internalID) {
    global $db;
    $query = "DELETE FROM tasks WHERE internalID >= $last_internalID";
    $result = $db->exec($query);
    return $result;
}

/*Edits comment of a signup*/
function edit_signup($id, $comment){
    global $db;
    $query = "UPDATE signups SET comment='$comment' WHERE ID='$id'";
    $results = $db->execute($query);
    return $results;
}

/*Edits account information.*/
function edit_account($id, $fname, $lname, $email, $phone, $pass) {
    global $db;
    $query = "UPDATE accounts SET fname='$fname', lname='$lname', email='$email', phone='$phone'".($pass == "" ? "" : ", password='$pass'")." WHERE ID='$id'";
    $results = $db->query($query);
    return $results;
}

/*Deletes account given id*/
function delete_account($id){
    global $db;
    $query = "DELETE FROM accounts WHERE ID = '$id'";
    $results = $db->execute($query);
    return $results;
}

/*Deletes event given id*/
function delete_event($event_id, $user_id) {
    global $db;
    $query = "SELECT * FROM events WHERE ID='$event_id'";
    $result = $db->query($query);
    $result = $result->fetch();

    if($result['accountID'] != $user_id)
        return;

    partially_delete_event($event_id);

    $query_tasks = "SELECT * FROM tasks WHERE eventID='$event_id'";
    $result_tasks = $db->query($query_tasks);
    $result_tasks = $result_tasks->fetchAll();

    foreach ($result_tasks as $task) {
        $task_id = $task['ID'];
        delete_task($task_id);

        $query = "SELECT * FROM signups WHERE taskID = '$task_id'";
        $result_signup = $db->query($query);
        $result_signup = $result_signup->fetchAll();

        foreach($result_signup as $signup){
            delete_signup($signup['ID']);
        }
    }

    $query = "SELECT * FROM event_reminders WHERE eventID = '$event_id'";
    $results = $db->query($query);
    $results = $results->fetchAll();
    foreach ($results as $remind){
        delete_reminder($remind['ID']);
    }
}

/*Deletes event given id*/
function partially_delete_event($id){
    global $db;
    $query = "DELETE FROM events WHERE ID = '$id'";
    $results = $db->exec($query);
    return $results;
}


/*Deletes signup given id*/
function delete_signup($id){
    global $db;
    $query = "DELETE FROM signups WHERE ID = '$id'";
    $results = $db->exec($query);
    return $results;
}

function delete_task($id){
    global $db;
    $query = "DELETE FROM tasks WHERE ID = '$id'";
    $results = $db->exec($query);
    return $results;
}

function delete_reminder($id){
    global $db;
    $query = "DELETE FROM event_reminders WHERE ID = '$id'";
    $results = $db->exec($query);
    return $results;
}

/*
    Registers an event creator
*/
function register_user($fname, $lname, $email, $phone, $password, $registered) {
    global $db;
    $query = "INSERT INTO accounts (fname, lname, email, phone, password, registered) VALUES ('$fname', '$lname', '$email', '$phone', '$password', $registered)";
    $db->exec($query);
	return $db->lastInsertId();
}

/*
    Checks if a user with that email is already registered.
    Used by the register_user method.
*/
function user_exists($email) {
    global $db;
    $query = "SELECT ID FROM accounts WHERE email = '$email'";
    $results = $db->query($query);
    $results = $results->rowCount();
    return $results > 0;
}

/*
    Authenticates a user when signing in & returns their id.
*/
function auth_user($email, $password) {
    global $db;
    $query = "SELECT ID, email, password FROM accounts WHERE email = '$email' ";
    $result = $db->query($query);
    $result = $result->fetch();
    if ($result['password'] == $password) {
        return $result['ID'];
    }
    return -1;
}

/*Sets cookie data for user*/
function set_cookie_data($user_id, $cookie_data) {
    global $db;
    $query = "UPDATE accounts SET cookieData='$cookie_data' WHERE ID='$user_id'";
    $result = $db->exec($query);
    return $result;
}

/*
    Looks up a user by their cookie data and returns their id
*/
function get_user_id_by_cookie_data($data) {
    global $db;
    $query = "SELECT ID FROM accounts WHERE cookieData = '$data'";
    $result = $db->query($query);
    $result = $result->fetch();
    return $result['ID'];
}

/*
    Protects against MySQL injection and cross-site scripting
*/
function sanitize($data) {
    $data = str_replace("<", "&lt;", $data);
    $data = str_replace(">", "&gt;", $data);
    //$data = str_replace("\"", "", $data);
    //$data = str_replace("'", "", $data);
    return $data;
}

/*
    Returns the tasks for a specified event  
*/
function get_tasks_for_event($event_id) {
    global $db;
    $query = "SELECT * FROM tasks WHERE eventID = '$event_id'";
    $results = $db->query($query);
    return $results->fetchAll();
}

/*
    Returns a task by id
*/
function get_task($task_id) {
    global $db;
    $query = "SELECT * FROM tasks WHERE ID = '$task_id'";
    $results = $db->query($query);
    return $results->fetch();
}

/*
    Signs a user up for a task
    If comments are disabled, the comment will just be an empty string
*/
function sign_up_for_task($task_id, $user_id, $comment = null) {
    global $db;
    $query = "SELECT comments FROM tasks WHERE ID = '$task_id'";
    $results = $db->query($query)->fetch()['comments'];
    $comm = $results == 0 ? "" : $comment;
    $query = "INSERT INTO signups (taskID, accountID, comment) VALUES ('$task_id', '$user_id', '$comm')";
    $db->exec($query);
}

/*
    Gets all reminders matching today
*/ 
function get_reminders_for_today() {
    global $db;
    $query = "SELECT * FROM event_reminders WHERE reminder_date = CURDATE()";
    $results = $db->query($query);
    return $results->fetchAll();
}

/*
    Gets all reminders for an event
*/
function get_reminders_for_event($event_id) {
    global $db;
    $query = "SELECT * FROM event_reminders WHERE eventID = '$event_id'";
    $results = $db->query($query);
    return $results->fetchAll();
}

/*
    Adds a reminder to an event
*/
function add_reminder($event_id, $date) {
    global $db;
    $query = "INSERT INTO event_reminders (eventID, type, reminder_date) VALUES ('$event_id', 1, '$date')";
    $db->exec($query);
}

/*
    Converts a date to a different format
*/
function convert_date($date, $format) {
    return date($format, strtotime($date));
}