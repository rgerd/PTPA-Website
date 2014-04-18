<?php
function get_all_events() {
    global $db;
    $query = 'SELECT * FROM events';
    $result = $db->query($query);
    return $result;
}

function get_user_events($userID) {
    global $db;
    $query = "SELECT * FROM events WHERE accountID = '$userID'";
    $result = $db->query($query);
    return $result;
}

function get_users_signedup($taskID) {
    global $db;
    $query = "SELECT * FROM signups WHERE taskID = '$taskID'";
    $result = $db->query($query);
    return $result;
}

function get_unregistered_user($code) {
    global $db;
    $query = "SELECT * FROM accounts WHERE password = '$code' AND registered = 0";
    $results = $db->query($query);
    $results = $results->fetchRow();
    return $results;
}

function get_user($id){
    global $db;
    $query = "SELECT * FROM accounts WHERE ID = '$id'";
    $results = $db->query($query);
    $results = $results->fetchRow();
    return $results;
}

function get_event($id){
    global $db;
    $query = "SELECT * FROM events WHERE ID = '$id'";
    $results = $db->query($query);
    $results = $results->fetchRow();
    return $results;
}

function count_signups($task){
    global $db;
    $query = "SELECT count(*) FROM signups WHERE taskID = '$task'";
    $results = $db->query($query);
    $results = $results->fetchRow();
    return $results;
}

function add_event($accountID, $date, $title, $desc){
    global $db;
    $query = "INSERT INTO events (accountID, date, title, desc) VALUES ('$accountID', '$date', '$title', '$desc')";
    $results = $db->execute($query);
    return $results;
}

function add_task($eventID, $desc, $count){
    global $db;
    $query = "INSERT INTO tasks (eventID, desc, count) VALUES ('$eventID', '$desc', '$count')";
    $results = $db->query($query);
    return $results;
}

function signup($taskID, $accountID, $comment = null){
    global $db;
    $query = "INSERT INTO signups (taskID, accountID, comment) VALUES ('$taskID', '$accountID', '$comment')";
    $results = $db->query($query);
    return $results;
}

function edit_signup($id, $comment){
    global $db;
    $query = "UPDATE signups SET comment='$comment' WHERE ID='$id'";
    $results = $db->execute($query);
    return $results;
}

function delete_signup($id){
    global $db;
    $query = "DELETE FROM signups WHERE ID = '$id'";
    $results = $db->execute($query);
    return $results;
}

function edit_account($id, $fname, $lname, $email, $phone, $pass){
    global $db;
    $query = "UPDATE accounts SET fname='$fname',lname='$lname',email='$email',phone='$phone',password='$pass' WHERE ID='$id'";
    $results = $db->execute($query);
    return $results;
}

function delete_account($id){
    global $db;
    $query = "DELETE FROM accounts WHERE ID = '$id'";
    $results = $db->execute($query);
    return $results;
}

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
    $query = "INSERT INTO accounts (fname, lname, email, phone, password) VALUES ('$fname', '$lname', '$email', '$phone', '$password')";
    $result = $db->query($query);
    return $result;
}

/*
    Checks if a user with that email is already registered.
    Used by the register_user method.
*/
function user_already_registered($email) {
    global $db;
    $query = "SELECT ID FROM accounts WHERE email = '$email'";
    $results = $db->query($query);
    $results = $results->rowCount();
    echo $results;
    if ($results >= 0){
        return true;
    }
    return false;
}

/*
    Authenticates a user when signing in
*/
function auth_user($email, $password) {
    // TODO: IMPLEMENT

    return false;
}

?>

