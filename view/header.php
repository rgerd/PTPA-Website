<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="shortcut icon" href="http://192.185.4.11/~ptcs/favicon.ico" type="image/x-icon">
    <link rel="icon" href="http://192.185.4.11/~ptcs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_style.css"/>
    <link rel="stylesheet" type="text/css" href="css/tabs.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_creator.css"/>
    <link rel="stylesheet" type="text/css" href="css/jQuery-UI.css"/>
    <link rel="stylesheet" type="text/css" href="css/button.css"/>
    <link rel="stylesheet" type="text/css" href="css/footer.css"/>
    <script type = "text/javascript">
        var error_message_return = <?php echo !isset($error_message_return) || $error_message_return ? "true" : "false"; ?>
    </script>
    <script type = "text/javascript" src="js/jQuery.js"></script>
    <script type = "text/javascript" src="js/jQuery-UI.js"></script>
    <script type = "text/javascript" src="js/jQuery-UI-effects.js"></script>
    <script type = "text/javascript" src="js/jcaret.js"></script>
    <script type = "text/javascript" src="js/universal.js"></script>
    <script type = "text/javascript" src="js/event_task.js"></script>
    <script type = "text/javascript" src="js/header.js"></script>
    <script type = "text/javascript" src="js/tabs.js"></script>
    <script type = "text/javascript" src="js/account_manager.js"></script>
    <script type = "text/javascript" src="js/ZeroClipboard/ZeroClipboard.js"></script>
    <script type = "text/javascript" src="js/home.js"></script>
</head>
<body>
<!--<div id="info"></div>--> <!-- UNCOMMENT TO ENABLE INFO BOX -->

<!--
<?php if($user_id != -1): ?> 
<div >
    <div id="nav_bar">
        <div id="inner_navbar">
            <div id="float_left" style="background-color:black"><a href="<?php echo $home_link; ?>"><img src="css/images/logo_white.png" alt="PT Volunteer" height="70px"/></a></div>
            <div id="float_right">
                <?php if($user_id != -1): ?>
                    <div class="header_button info_request" info="Settings"><a href=".?a=acc"><img src="css/images/gear_white.png" alt="User Settings" height="60px"/></a></div>
                    <div class="header_button info_request" info="Sign Out"><a href=".?a=sign_out"><img src="css/images/signout_white.png" alt="Log Out" height="60px"/></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if($user_id == -1 && $event_id != -1): ?>
    <a href="<?php echo $home_link; ?>"><div><img height="70px" src="css/images/logo1.png"/></div></a>
<?php endif; ?>
<div id="page_content" <?php if($user_id == -1) echo "class='front".($event_id != -1 ? " event" : "")."'"; ?>>
    <div id="view_content" <?php if($user_id == -1) echo "class='front".($event_id != -1 ? " event" : "")."'"; ?>>
-->

<a href="<?php echo $home_link; ?>" id="header_left"><div><img height="70px" src="css/images/logo1.png"/></div></a>
<?php if($user_id != -1): ?>
    <div id="header_right">
    <div class="header_button info_request" info="Settings"><a href=".?a=acc"><img src="css/images/gear_white.png" alt="User Settings" height="60px"/></a></div>
    <div class="header_button info_request" info="Sign Out"><a href=".?a=sign_out"><img src="css/images/signout_white.png" alt="Log Out" height="60px"/></a></div>
    </div>
<?php endif; ?>
<div id="page_content" class="front event" style="clear: both;">
    <div id="view_content" class="front event">