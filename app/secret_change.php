<?php

   

include("security.php");
include("security_level_check.php");
include("selections.php");
include("connect_i.php");

$message = "";

if(isset($_POST["action"]))
{

    $email = $_POST["email"];
    $email = mysqli_real_escape_string($link, $email);

    $reset_code = $_POST["reset_code"];
    $reset_code = mysqli_real_escape_string($link, $reset_code);

    $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND BINARY reset_code = '" . $reset_code . "'";

    // Debugging
    // echo $sql;

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }

    // Debugging
    // echo "<br />Affected rows: ";
    // printf($link->affected_rows);

    $row = $recordset->fetch_object();

    if($row)
    {

        // Debugging
        // echo "<br />Row: ";
        // print_r($row);

        $secret = $_POST["secret"];
        $secret = mysqli_real_escape_string($link, $secret);
        $secret = htmlspecialchars($secret, ENT_QUOTES, "UTF-8");

        $sql = "UPDATE users SET reset_code = NULL, secret = '" . $secret . "' WHERE email = '" . $email . "'";

        // Debugging
        // echo $sql;

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }

        // Debugging
        // echo "<br />Affected rows: ";
        // printf($link->affected_rows);

        $message = "<font color=\"green\">Your secret has been changed!</font>";

    }

    else
    {

        $message = "<font color=\"red\">Your secret has not been changed!</font>";

    }

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>OrangeBox - Change Secret</title>

</head>

<body>

<header>

<h1 class="glitch is-glitching" data-text="Hover me!">OrangeBox</h1>

 

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

    <h1>Change Secret</h1>

    <p>Please change your secret.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="secret">New secret:</label><br />
        <input type="text" id="secret" name="secret"></p>

        <input type="hidden" id="email" name="email" value="<?php if(isset($_GET["email"])){echo htmlspecialchars($_GET["email"],ENT_QUOTES,'UTF-8');} ?>" />

        <input type="hidden" id="reset_code" name="reset_code" value="<?php if(isset($_GET["reset_code"])){echo htmlspecialchars($_GET["reset_code"],ENT_QUOTES,'UTF-8');} ?>" />

        <button type="submit" name="action" value="change">Change</button>

    </form>

    <br />
    <?php

    echo $message;

    $link->close();

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