<?php

   

include("security.php");
include("security_level_check.php");
include("connect_i.php");
include("selections.php");
include("functions_external.php");

function xss($data)
{
         
    switch($_COOKIE["security_level"])
    {
        
        case "0" : 
            
            $data = no_check($data);            
            break;
        
        case "1" :
            
            $data = xss_check_4($data);
            break;
        
        case "2" :            
                       
            $data = xss_check_3($data);            
            break;
        
        default : 
            
            $data = no_check($data);            
            break;   

    }       

    return $data;

}

$message = "";

$login = $_SESSION["login"];

if(isset($_POST["action"]))
{

    if(isset($_REQUEST["secret"]))
    {

        $secret = $_REQUEST["secret"];

        if($secret == "")
        {

            $message = "<font color=\"red\">Please enter a new secret...</font>";       

        }

        else
        {
            
            // If the security level is not MEDIUM or HIGH
            if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2") 
            {

                if(isset($_REQUEST["login"]) && $_REQUEST["login"])
                {

                    $login = $_REQUEST["login"];
                    $login = mysqli_real_escape_string($link, $login);
                    
                    $secret = mysqli_real_escape_string($link, $secret);
                    $secret = xss($secret);

                    $sql = "UPDATE users SET secret = '" . $secret . "' WHERE login = '" . $login . "'";

                    // Debugging
                    // echo $sql;      

                    $recordset = $link->query($sql);

                    if(!$recordset)
                    {

                        die("Connect Error: " . $link->error);

                    }

                    $message = "<font color=\"green\">The secret has been changed!</font>";

                }

                else 
                {

                    $message = "<font color=\"red\">Invalid login!</font>"; 

                }
                
            }

            else
            {
                
                // If the security level is MEDIUM or HIGH
                if(!isset($_REQUEST["token"]) or !isset($_SESSION["token"]) or $_REQUEST["token"] != $_SESSION["token"])
                {

                    $message = "<font color=\"red\">Invalid token!</font>";            

                }

                else
                {

                    $secret = mysqli_real_escape_string($link, $secret);
                    $secret = htmlspecialchars($secret, ENT_QUOTES, "UTF-8");

                    $sql = "UPDATE users SET secret = '" . $secret . "' WHERE login = '" . $login . "'";

                    // Debugging
                    // echo $sql;      

                    $recordset = $link->query($sql);

                    if(!$recordset)
                    {

                        die("Connect Error: " . $link->error);

                    }

                    $message = "<font color=\"green\">The secret has been changed!</font>";

                }
                
            }

        }

    }
    
    else
    {
    
        $message = "<font color=\"red\">Invalid secret!</font>"; 
        
    }   
    
}

// A random token is generated when the security level is MEDIUM or HIGH
if($_COOKIE["security_level"] == "1" or $_COOKIE["security_level"] == "2")
{

    $token = sha1(uniqid(mt_rand(0,100000)));
    $_SESSION["token"] = $token;

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

<title>OrangeBox - XSS</title>

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
    
    <h1>XSS - Stored (Change Secret)</h1>

    <p>Change your secret.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="secret">New secret:</label><br />
        <input type="text" id="secret" name="secret"></p>
        <?php

        if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2") 
        {

        ?>

        <input type="hidden" name="login" value="<?php echo $login;?>">
        <?php        

        }

        else
        {

        ?>

        <input type="hidden" id="token" name="token" value="<?php echo $_SESSION["token"]?>">
        <?php

        }

        ?>

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