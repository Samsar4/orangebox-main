<?php

   

include("security.php");
include("security_level_check.php");
include("selections.php");

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<?php

if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2")
{

?>
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER["HTTP_HOST"]?>/OrangeBox/stylesheets/stylesheet.css" media="screen" />
<?php

}

else
{
?>
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<?php

}

?>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<?php

if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2")
{

?>
<script src="http://<?php echo $_SERVER["HTTP_HOST"]?>/OrangeBox/js/html5.js"></script>
<?php

}

else
{
?>
<script src="js/html5.js"></script>
<?php

}

?>

<title>OrangeBox - Host Header Attacks</title>

</head>

<body>

<header>

 <h1>OrangeBox</h1>

 

</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="portal.php">Bugs</a></td>
            <td><a href="password_change.php">Change Password</a></td>
            <td><a href="user_extra.php">Create User</a></td>
            <td><a href="security_level_set.php">Set Security Level</a></td>
            <td><a href="reset.php" onclick="return confirm('All settings will be cleared. Are you sure?');">Reset</a></td>
             
   
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="black">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Host Header Attack (Cache Poisoning)</h1>
    
<?php

if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2")
{
    
    $session_id = session_id();         

?>
    <p>Click <a href="http://<?php echo $_SERVER["HTTP_HOST"]?>/OrangeBox/portal.php">here</a> to go back to the portal.</p>
<?php

}

else
{
?>
    <p>Click <a href="portal.php">here</a> to go back to the portal.</p>
<?php

}

?>

</div>

   

<div id="disclaimer">

    <p>OrangeBox is licensed under <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank"><img style="vertical-align:middle" src="./images/cc.png"></a>   </p>

</div>

<div id="bee">

    <img src="./images/bee_1.png">

</div>

<div id="security_level">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Set your security level:</label><br />

        <select name="security_level">

            <option value="0">low</option>
            <option value="1">medium</option>
            <option value="2">high</option>

        </select>

        <button type="submit" name="form_security_level" value="submit">Set</button>
        <font size="4">Current: <b><?php echo $security_level?></b></font>

    </form>

</div>

<div id="bug">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Choose your bug:</label><br />

        <select name="bug">

<?php

// Lists the options from the array 'bugs' (bugs.txt)
foreach ($bugs as $key => $value)
{

   $bug = explode(",", trim($value));

   // Debugging
   // echo "key: " . $key;
   // echo " value: " . $bug[0];
   // echo " filename: " . $bug[1] . "<br />";

   echo "<option value='$key'>$bug[0]</option>";

}

?>


        </select>

        <button type="submit" name="form_bug" value="submit">Go</button>

    </form>

</div>

</body>

</html>