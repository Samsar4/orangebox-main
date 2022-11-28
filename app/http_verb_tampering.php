<?php

   

include("security.php");
include("security_level_check.php");
include("connect_i.php");
include("selections.php");

$message = "";

// If the security level is not MEDIUM or HIGH
if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2") 
{

    if(isset($_REQUEST["password_new"]) && isset($_REQUEST["password_conf"]))
    {

        $password_new = $_REQUEST["password_new"];
        $password_conf = $_REQUEST["password_conf"];        

        if($password_new == "")
        {

            $message = "<font color=\"red\">Please enter a new password...</font>";       

        }

        else
        {

            if($password_new != $password_conf)
            {

                $message = "<font color=\"red\">The passwords don't match!</font>";       

            }

            else            
            {

                $login = $_SESSION["login"];

                $password_new = mysqli_real_escape_string($link, $password_new);
                $password_new = hash("sha1", $password_new, false);

                $sql = "SELECT password FROM users WHERE login = '" . $login . "'";

                $recordset = $link->query($sql);             

                if(!$recordset)
                {

                    die("Error: " . $link->error);

                }

                $row = $recordset->fetch_object();   

                if($row)
                {

                    $sql = "UPDATE users SET password = '" . $password_new . "' WHERE login = '" . $login . "'";

                    $recordset = $link->query($sql);

                    if(!$recordset)
                    {

                        die("Error: " . $link->error);

                    }

                    $message = "<font color=\"green\">The password has been changed!</font>";

                }

                else
                {

                    $message = "<font color=\"red\">The password has not been changed!</font>";

                }              

            } 

        }

    }

}

// If the security level is MEDIUM or HIGH
else
{

    if(isset($_POST["password_new"]) && isset($_POST["password_conf"]))
    {

        $password_new = $_POST["password_new"];
        $password_conf = $_POST["password_conf"];        

        if($password_new == "")
        {

            $message = "<font color=\"red\">Please enter a new password...</font>";       

        }

        else
        {

            if($password_new != $password_conf)
            {

                $message = "<font color=\"red\">The passwords don't match!</font>";       

            }

            else            
            {

                $login = $_SESSION["login"];

                $password_new = mysqli_real_escape_string($link, $password_new);
                $password_new = hash("sha1", $password_new, false);            

                $sql = "SELECT password FROM users WHERE login = '" . $login . "'";

                $recordset = $link->query($sql);             

                if(!$recordset)
                {

                    die("Error: " . $link->error);

                }

                $row = $recordset->fetch_object();   

                if($row)
                {

                    $sql = "UPDATE users SET password = '" . $password_new . "' WHERE login = '" . $login . "'";

                    $recordset = $link->query($sql);

                    if(!$recordset)
                    {

                        die("Error: " . $link->error);

                    }

                    $message = "<font color=\"green\">The password has been changed!</font>";

                }

                else
                {

                    $message = "<font color=\"red\">The password has not been changed!</font>";

                }              

            } 

        }

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

<title>OrangeBox - HTTP Verb Tampering</title>

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
    
    <h1>HTTP Verb Tampering</h1>

    <p>Please change your password <b><?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);} ?></b>.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST"> 

        <p><label for="password_new">New password:</label><br />
        <input type="password" id="password_new" name="password_new"></p>

        <p><label for="password_conf">Re-type new password:</label><br />
        <input type="password" id="password_conf" name="password_conf"></p>  

        <button type="submit" name="action" value="change">Change</button>   

    </form>

    </br >
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