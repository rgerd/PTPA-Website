<?php
function execute_query($query, $vals = array(), $sanitize = true, $debug = false) {
    global $db;

    if($sanitize)
        foreach($vals as &$val)
            $val = sanitizeMySQL($val);

    unset($val);

    if($debug) {
        echo "QUERY: ".$query."<br /><br />";
        echo "VALUES: <br />";
        print_r($vals);
        echo "<br /><br />";
    }
   
    $result = $db->prepare($query);
    
    $exec_success = $result->execute($vals);

    if($debug) {
        echo "PREPARATION ".((!$result) ? "UNSUCCESSFUL" : "SUCCESSFUL")."<br />";
        echo "EXECUTION ".($exec_success ? "SUCCESSFUL" : "UNSUCCESSFUL")."<br />";
        echo "<br />";
    }

    return $result;
}

/*Returns the events of a specific user.*/
function get_events_by_user($userID) {
    $query = "SELECT * FROM events WHERE accountID = ?";
    return execute_query($query, func_get_args())->fetchAll();
}

/*Returns the users signed up for a task.*/
function get_users_signed_up($taskID) {
    $query = "SELECT * FROM signups WHERE taskID = ?";
    return execute_query($query, func_get_args())->fetchAll();
}

/* Returns the signup with the given user and task id */
function get_signup($taskID, $userID) {
    $query = "SELECT * FROM signups WHERE taskID = ? AND accountID = ?";
    return execute_query($query, func_get_args())->fetch();
}

/**/
function get_unregistered_user($code) {
    $query = "SELECT * FROM accounts WHERE password = ? AND registered = 0";
    return execute_query($query, func_get_args())->fetch();
}

/*Returns user given id*/
function get_user($id) {
    $query = "SELECT * FROM accounts WHERE ID = ?";
    return execute_query($query, func_get_args())->fetch();
}

/*Returns event given id*/
function get_event($id) {
    $query = "SELECT * FROM events WHERE ID = ?";
    return execute_query($query, func_get_args())->fetch();
}

/*Returns whether or not a user owns an event*/
function user_owns_event($user_id, $event_id) {
    return get_event($event_id)['accountID'] == $user_id;
}

/*Counts number of signups for a task*/
function count_signups($taskID) {
    $query = "SELECT count(*) as num FROM signups WHERE taskID = ?";
    return execute_query($query, func_get_args())->fetch()['num'];
}

/*Creates new event and returns id*/
function add_event($accountID, $title, $date, $desc) {
    global $db;
    $query = "INSERT INTO events (accountID, title, event_date, description) VALUES (?, ?, ?, ?)";
    execute_query($query, func_get_args());
    return $db->lastInsertId();
}

/*Updates an event after being edited*/
function update_event($id, $title, $date, $desc) {
    $query = "UPDATE events SET title = ?, event_date = ?, description = ? WHERE ID = ?";
    execute_query($query, array($title, $date, $desc, $id));
    return $id;
}

/*Creates new task*/
function add_task($eventID, $internalID, $desc, $numSlots, $comments) {
    $query = "INSERT INTO tasks (eventID, internalID, description, numSlots, comments) VALUES (?, ?, ?, ?, ?)";
    execute_query($query, func_get_args());
}

/*Updates a task after being edited*/
function update_task($id, $internalID, $desc, $numSlots, $comments) {
    $query = "UPDATE tasks SET internalID = ?, description = ?, numSlots = ?, comments = ? WHERE ID = ?";
    execute_query($query, array($internalID, $desc, $numSlots, $comments, $id));
}

/*Edits account information.*/
function edit_account($id, $fname, $lname, $email, $phone, $pass) {
    $query = "UPDATE accounts SET fname = ?, lname = ?, email = ?, phone = ?".($pass == "" ? "" : ", password=?")." WHERE ID = ?";
    execute_query($query, array($fname, $lname, $email, $phone, $pass, $id));
}

/*Deletes account given id*/
function delete_account($id) {
    $query = "DELETE FROM accounts WHERE ID = ?";
    execute_query($query, func_get_args());
}

/*Deletes event given id*/
function delete_event($event_id, $user_id) {
    global $db;
    $query = "SELECT * FROM events WHERE ID = ?";
    $result = execute_query($query, array($event_id))->fetch();

    if($result['accountID'] != $user_id)
        return;

    partially_delete_event($event_id);

    $query_tasks = "SELECT * FROM tasks WHERE eventID = ?";
    $result_tasks = execute_query($query_tasks, array($event_id))->fetchAll();

    foreach ($result_tasks as $task) {
        $task_id = $task['ID'];
        delete_task($task_id);

        $query = "SELECT * FROM signups WHERE taskID = '$task_id'";
        $result_signup = execute_query($query, array($task_id))->fetchAll();

        foreach($result_signup as $signup)
            delete_signup($signup['ID']);
    }

    $query = "SELECT * FROM event_reminders WHERE eventID = ?";
    $results = execute_query($query, array($event_id))->fetchAll();

    foreach ($results as $reminder)
        delete_reminder($reminder['ID']);
}

/*Deletes event given id*/
function partially_delete_event($id) {
    $query = "DELETE FROM events WHERE ID = ?";
    execute_query($query, func_get_args());
}


/*Deletes signup given id*/
function delete_signup($id) {
    $query = "DELETE FROM signups WHERE ID = ?";
    execute_query($query, func_get_args());
}

function delete_task($id) {
    $query = "DELETE FROM tasks WHERE ID = ?";
    execute_query($query, func_get_args());
}

function delete_reminder($id) {
    $query = "DELETE FROM event_reminders WHERE ID = ?";
    execute_query($query, func_get_args());
}

/*
    Registers an event creator
*/
function register_user($fname, $lname, $email, $phone, $password, $registered) {
    global $db;
    $query = "INSERT INTO accounts (fname, lname, email, phone, password, registered) VALUES (?, ?, ?, ?, ?, ?)";
    execute_query($query, func_get_args());
	return $db->lastInsertId();
}

/*
    Checks if a user with that email is already registered.
    Used by the register_user method.
*/
function user_exists($email) {
    $query = "SELECT ID FROM accounts WHERE email = ? AND registered = 1";
    return execute_query($query, func_get_args())->rowCount() > 0;
}

/*
    Returns a volunteer with that email.
    If the volunteer does not exist, -1 is returned.
*/
function auth_volunteer($email) {
    $query = "SELECT ID, fname, lname FROM accounts WHERE email = ? AND registered = 0";
    $result = execute_query($query, array($email));

    if($result->rowCount() == 0) 
        return -1;

    return $result->fetch();
}

/*
    Authenticates a registered user when signing in & returns their id.
*/
function auth_user($email, $password) {
    $query = "SELECT ID, email, password FROM accounts WHERE email = ? AND registered = 1";
    $result = execute_query($query, array($email))->fetch();
    
    if ($result['password'] == $password)
        return $result['ID'];
    return -1;
}

/*Sets cookie data for user*/
function set_cookie_data($user_id, $cookie_data) {
    $query = "UPDATE accounts SET cookieData = ? WHERE ID = ?";
    execute_query($query, array($cookie_data, $user_id));
}

/*
    Looks up a user by their cookie data and returns their id
*/
function get_user_id_by_cookie_data($data) {
    $query = "SELECT ID FROM accounts WHERE cookieData = ?";
    return execute_query($query, func_get_args())->fetch()['ID'];
}

/*
    Returns the tasks for a specified event  
*/
function get_tasks_for_event($event_id) {
    $query = "SELECT * FROM tasks WHERE eventID = ?";
    return execute_query($query, func_get_args())->fetchAll();
}

/*
    Returns a task by id
*/
function get_task($task_id) {
    $query = "SELECT * FROM tasks WHERE ID = ?";
    return execute_query($query, func_get_args())->fetch();
}

/*
    Signs a user up for a task
    If comments are disabled, the comment will just be an empty string
*/
function sign_up_for_task($task_id, $user_id, $comment = null) {
    $query = "SELECT comments FROM tasks WHERE ID = ?";
    $results = execute_query($query, array($task_id))->fetch()['comments'];

    $comm = $results == 0 ? "" : $comment;
    $query = "INSERT INTO signups (taskID, accountID, comment) VALUES (?, ?, ?)";
    execute_query($query, array($task_id, $user_id, $comm));
}

/*Edits comment of a signup*/
function edit_signup_comment($id, $comment){
    $query = "UPDATE signups SET comment = ? WHERE ID = ?";
    execute_query($query, array($comment, $id));
}

/*
    Gets all reminders matching today
*/ 
function get_reminders_for_today() {
    $query = "SELECT * FROM event_reminders WHERE reminder_date = CURDATE()";
    return execute_query($query)->fetchAll();
}

/*
    Gets all reminders for an event
*/
function get_reminders_for_event($event_id) {
    $query = "SELECT * FROM event_reminders WHERE eventID = ?";
    return execute_query($query, func_get_args())->fetchAll();
}

/*
    Adds a reminder to an event
*/
function add_reminder($event_id, $date_type, $date) {
    $query = "INSERT INTO event_reminders (eventID, type, date_type".($date_type == 0 ? ", reminder_date" : "").") VALUES (?, 1, ?".($date_type == 0 ? ", ?" : "").")";
    $params = array($event_id, $date_type);
    if($date_type == 0)
        array_push($params, $date);
    execute_query($query, $params);
}

/*
    Converts a date to a different format
*/
function convert_date($date, $format) {
    return date($format, strtotime($date));
}

/*
    Protects against MySQL injection and cross-site scripting
*/
function sanitizeMySQL($data) {
    $data = sanitizeHTML($data);
    $data = str_replace('"', '\"', $data);
    $data = str_replace("'", "\'", $data);
    return $data;
}

function sanitizeJS($data) {
    $data = str_replace('\"', '"', $data);
    $data = str_replace('"', '\"', $data);

    $data = str_replace("\'", "'", $data);
    $data = str_replace("'", "\'", $data);

    $data = str_replace("&lt;", "<", $data);
    $data = str_replace("&gt;", ">", $data);

    $line_breaks = array("<br />", "<br/>", "<BR />", "<BR/>", "<br >", "<br>", "<BR >", "<BR>");
    $data = str_replace($line_breaks, "\n", $data);

    return $data;
}

function sanitizeHTML($data) {
    $data = sanitizeJS($data);

    $data = str_replace("<", "&lt;", $data);
    $data = str_replace(">", "&gt;", $data);

    $data = str_replace('\"', '"', $data);
    $data = str_replace("\'", "'", $data);

    $data = nl2br($data);
    $data = str_replace("\n", "", $data);
    $data = str_replace("\r", "", $data);

    return $data; 
}

function removeAllNewLines($data, $spaces=false) {
    $line_breaks = array("<br />", "<br/>", "<BR />", "<BR/>", "<br >", "<br>", "<BR >", "<BR>");
    $data = str_replace($line_breaks, "\n", $data);
    $data = removeJSNewLines($data, $spaces);
    return $data;
}

function removeJSNewLines($data, $spaces = false) {
    $data = str_replace("\n", " ", $data);
    $data = str_replace("\r", " ", $data);
    return $data;
}