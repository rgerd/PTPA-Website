<?php

/*Returns all events.*/
function get_all_events() {
    global $db;
    $query = 'SELECT * FROM events';
    $result = $db->query($query);
    $result = $result->fetchAll();
    return $result;
}

/*Returns the events of a specific user.*/
function get_events_by_user($userID) {
    global $db;
    $query = "SELECT * FROM events WHERE accountID = '$userID'";
    $result = $db->query($query);
    $result = $result->fetchAll();
    return $result;
}

/*Returns the users signed up for a task.*/
function get_users_signedup($taskID) {
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

/*Creates new task*/
function add_task($eventID, $internalID, $desc, $numSlots, $comments){
    global $db;
    $query = "INSERT INTO tasks (eventID, description, numSlots, internalID, comments) VALUES ('$eventID', '$desc', '$numSlots', '$internalID', '$comments')";
    $results = $db->exec($query);
}

/*Edits comment of a signup*/
function edit_signup($id, $comment){
    global $db;
    $query = "UPDATE signups SET comment='$comment' WHERE ID='$id'";
    $results = $db->execute($query);
    return $results;
}

/*Deletes signup given id*/
function delete_signup($id){
    global $db;
    $query = "DELETE FROM signups WHERE ID = '$id'";
    $results = $db->execute($query);
    return $results;
}

/*Edits account information.*/
function edit_account($id, $fname, $lname, $email, $phone, $pass){
    global $db;
    $query = "UPDATE accounts SET fname='$fname',lname='$lname',email='$email',phone='$phone',password='$pass' WHERE ID='$id'";
    $results = $db->execute($query);
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
function delete_event($id){
    global $db;
    $query = "DELETE FROM events WHERE ID = '$id'";
    $results = $db->execute($query);
    return $results;
}

/*
    Registers an event creator
*/
function register_user($fname, $lname, $email, $phone, $password) {
    global $db;
    $query = "INSERT INTO accounts (fname, lname, email, phone, password, registered) VALUES ('$fname', '$lname', '$email', '$phone', '$password', 1)";
    $result = $db->query($query);
    return $result['ID'];
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
?>

