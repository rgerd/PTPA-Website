<?php
function get_all_events(){
    global $db;
    $query = 'SELECT * FROM events';
    $result = $db->query($query);
    return $result;
}

function get_user_events($userID){
    global $db;
    $query = "SELECT * FROM events WHERE accountID = '$userID'";
    $result = $db->query($query);
    return $result;
}

function get_users_signedup($taskID){
    global $db;
    $query = "SELECT * FROM signups WHERE taskID = '$taskID'";
    $result = $db->query($query);
    return $result;
}

function get_unregistered_user($code){
    global $db;
    $query = "SELECT * FROM accounts WHERE password = '$code'";
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


?>

