<?php

   

include("settings.php");

if(isset($_COOKIE["security_level"]))
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $security_level = "low";
            break;

        case "1" :

            $security_level = "medium";
            break;

        case "2" :

            $security_level = "high";
            break;

        case "666" :

            $security_level = "666";
            break;

        default :

            $security_level = "low";
            break;

    }

}

else
{

    $security_level = "not set";

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="../js/html5.js"></script>

<title>OrangeBox - Admin Portal</title>

</head>

<body>

<header>

<h1 class="glitch is-glitching" data-text="Hover me!">OrangeBox</h1>

 

</header>

<div id="menu">

    <table>

        <tr>

            <td><font color="#ffb717">Admin Portal</font></td>
   

        </tr>

    </table>

</div>

<div id="main">

    <h1>Settings</h1>

    <table id="table_yellow">

        <tr height="50" bgcolor="#ffb717" align="center">

            <td width="150"><b>Setting</b></td>
            <td width="150"><b>Value</b></td>
            <td width="540"><b>Description</b></td>

        </tr>

        <tr height="50">

            <td>Security Level</td>
            <td align="center"><?php echo $security_level ?></td>
            <td>Possible values: low - medium - high</td>

        </tr>

        <tr height="50">

            <td>SMTP Server</td>
            <td align="center"><?php echo $smtp_server ?></td>
            <td>Used for e-mail functionality</td>

        </tr>

        <tr height="50">

            <td>A.I.M. IP Address</td>
            <td align="center"><?php echo $AIM_IPs[0] ?></td>
            <td>A no-authentication mode, for testing web scanners and crawlers</td>

        </tr>

        <tr height="50">

            <td>Evil Bee Mode</td>
            <td align="center"><?php echo $evil_bee ?></td>
            <td>All security levels are bypassed in this mode</td>

        </tr>

        <tr height="50">

            <td>Credentials</td>
            <td align="center"><?php echo $login . "/" . $password ?></td>
            <td>Static credentials used on some pages</td>

        </tr>

    </table>

</div>

<div id="side">

    <a href="http://itsecgames.blogspot.com" target="blank_" class="button"><img src="../images/blogger.png"></a>
    <a href="http://be.linkedin.com/in/malikmesellem" target="blank_" class="button"><img src="../images/linkedin.png"></a>
    <a href="http://twitter.com/MME_IT" target="blank_" class="button"><img src="../images/twitter.png"></a>
    <a href="http://www.facebook.com/pages/MME-IT-Audits-Security/104153019664877" target="blank_" class="button"><img src="../images/facebook.png"></a>

</div>

<div id="disclaimer">

    <p>OrangeBox is licensed under <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank"><img style="vertical-align:middle" src="../images/cc.png"></a>   </p>

</div>

<div id="bee">

    <img src="../images/bee_1.png">

</div>

</body>

</html>