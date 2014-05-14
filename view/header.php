<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_style.css"/>
    <link rel="stylesheet" type="text/css" href="css/tabs.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_creator.css"/>
    <link rel="stylesheet" type="text/css" href="css/jQuery-UI.css"/>
    <script type = "text/javascript" src="js/jQuery.js"></script>
    <script type = "text/javascript" src="js/jQuery-UI.js"></script>
    <script type = "text/javascript" src="js/event_task.js"></script>
    <script type = "text/javascript" src="js/header.js"></script>
    <script type = "text/javascript" src="js/tabs.js"></script>
    <script type = "text/javascript" src="js/ZeroClipboard/ZeroClipboard.js"></script>
    <script type = "text/javascript" src="js/home.js"></script>
</head>
<body>
<div >
    <div id="nav_bar">
        <div id="inner_navbar">
            <div id="float_left"><a href="index.php"><img src="css/images/logo1.png" alt="PT Volunteer" height="60px"/></a></div>
            <div id="float_right">
                <?php if($user_id != -1): ?>
                    <div class="header_button"><a href=".?a=acc"><img src="css/images/gear.png" alt="User Settings" height="60px"/></a></div>
                    <div class="header_button"><a href=".?a=sign_out"><img src="css/images/signout.png" alt="Log Out" height="60px"/></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div id="page_content">
    <div id="view_content">
