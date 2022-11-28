<?php

   

include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");
include("connect.php");

// Error handling
error_reporting(0);

function sqli($data)
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = no_check($data);
            break;

        case "1" :

            $data = sqli_check_1($data);
            break;

        case "2" :

            $data = sqli_check_2($data);
            break;

        default :

            $data = no_check($data);
            break;

    }

    return $data;

}

if(isset($_REQUEST["title"]))
{

    $title = $_REQUEST["title"];

    $sql = "SELECT * FROM movies WHERE title = '" . sqli($title) . "'";

    $recordset = mysql_query($sql, $link);

    if($recordset and mysql_num_rows($recordset) != 0)
    {

        $row = mysql_fetch_array($recordset);

        $movie = $row["title"];

        $login = $_SESSION["login"];

        $sql = "SELECT email FROM users WHERE login = '" . $login . "'";

        $recordset = mysql_query($sql, $link);

        $row = mysql_fetch_array($recordset);

        $email = $row["email"];

        if($smtp_server != "")
        {

            ini_set( "SMTP", $smtp_server);

        }

        // Sends a mail to the user
        $subject = "OrangeBox - Movie Search";
        $sender = $smtp_sender;

        $content = "Hello " . ucwords($login) . ",\n\n";
        $content.= "The movie \"" . $movie . "\" exists in our database." . "\n\n";
        $content.= "Greets from OrangeBox!";

        $status = @mail($email, $subject, $content, "From: $sender");

    }

    mysql_close($link);

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

<title>OrangeBox - SQL Injection</title>

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

    <h1>SQL Injection - Blind - Time-Based</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]); ?>" method="GET">

        <p>

        <label for="title">Search for a movie:</label>
        <input type="text" id="title" name="title" size="25">

        <button type="submit" name="action" value="search">Search</button>

        </p>

    </form>

    <p>The result will be sent by e-mail...</p>
    
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