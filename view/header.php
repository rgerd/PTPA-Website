<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_style.css"/>
    <link rel="stylesheet" type="text/css" href="css/tabs.css"/>
    <link rel="stylesheet" type="text/css" href="css/event_creator.css"/>
    <link rel="stylesheet" type="text/css" href="css/jQuery-UI.css"/>
    <link rel="stylesheet" type="text/css" href="css/button.css"/>
    <link rel="stylesheet" type="text/css" href="css/footer.css"/>
    <script type = "text/javascript" src="js/jQuery.js"></script>
    <script type = "text/javascript" src="js/jQuery-UI.js"></script>
    <script type = "text/javascript" src="js/event_task.js"></script>
    <script type = "text/javascript" src="js/header.js"></script>
    <script type = "text/javascript" src="js/tabs.js"></script>
    <script type = "text/javascript" src="js/account_manager.js"></script>
    <script type = "text/javascript" src="js/ZeroClipboard/ZeroClipboard.js"></script>
    <script type = "text/javascript" src="js/home.js"></script>
</head>
<body>
<!--<div id="info"></div>--> <!-- UNCOMMENT TO ENABLE INFO BOX -->
<div >
    <div id="nav_bar">
        <div id="inner_navbar">
            <div id="float_left" style="background-color:black"><a href="index.php"><img src="css/images/logo_white.png" alt="PT Volunteer" height="70px"/></a></div>
            <div id="float_right">
                <?php if($user_id != -1): ?>
                    <div class="header_button info_request" info="Settings"><a href=".?a=acc"><img src="css/images/gear_white.png" alt="User Settings" height="60px"/></a></div>
                    <div class="header_button info_request" info="Sign Out"><a href=".?a=sign_out"><img src="css/images/signout_white.png" alt="Log Out" height="60px"/></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div id="page_content">
    <div id="view_content">
