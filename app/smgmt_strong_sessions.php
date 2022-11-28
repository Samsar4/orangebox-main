<?php

   

include("security.php");
include("security_level_check.php");
include("selections.php");

/* 
URL: http://php.net/manual/en/function.setcookie.php 

Writes a cookie
bool setcookie ( string $name [, string $value [, int $expire = 0 [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]]]] )

Deletes a cookie
setcookie ("top_security", "", time()-3600);

Prints an individual cookie
echo $_COOKIE["top_security"];

Another way to debug/test is to view all cookies
print_r($_COOKIE); 
*/

$message = "";

// Deletes the cookie
setcookie("top_security", "", time()-3600, "/", "", false, false);

switch($_COOKIE["security_level"])
{
        
    case "0" :
        
        $message = "<p>Click <a href=\"top_security.php\" target=\_blank\>here</a> to access our top security page.</p>";
        
        // Deletes the cookies
        setcookie("top_security_nossl", "", time()-3600, "/", "", false, false);
        setcookie("top_security_ssl", "", time()-3600, "/", "", false, false);
        
        break;
        
    case "1" :
        
        $message = "<p>Click <a href=\"top_security.php\" target=\_blank\>here</a> to access our top security page.</p>";
        
        // Deletes the cookie
        setcookie("top_security_ssl", "", time()-3600, "/", "", false, false);
        
        if(!isset($_POST["form"]))
        {

            // Generates a non-SSL secured cookie
            // Generates a random token
            $token = uniqid(mt_rand(0,100000));
            $token = hash("sha256", $token);
            
            $_SESSION["top_security_nossl"] = $token;

            // The cookie will be available within the entire domain
            // Sets the Http Only flag        
            setcookie("top_security_nossl", $token, time()+3600, "/", "", false, true);

        }
        
        break;
        
    case "2" :
        
        $message = "<p>This page must be accessed over a SSL channel to fully function!<br />";
        $message.= "Click <a href=\"top_security.php\" target=\_blank\>here</a> to access our top security page.</p>";
        
        // Deletes the cookie
        setcookie("top_security_nossl", "", time()-3600, "/", "", false, false);

        if(!isset($_POST["form"]))
        {
            
            // Generates a non-SSL secured cookie
            // Generates a random token
            // $token = uniqid(mt_rand(0,100000));
            // $token = hash("sha256", $token);
            
            // $_SESSION["top_security_nossl"] = $token;

            // The cookie will be available within the entire domain
            // Sets the Http Only flag        
            // setcookie("top_security_nossl", $token, time()+3600, "/", "", false, true);          
            
            // Generates a SSL secured cookie
            // Generates a random token
            $token = uniqid(mt_rand(0,100000));
            $token = hash("sha256", $token);
            
            $_SESSION["top_security_ssl"] = $token;

            // The cookie will be available within the entire domain
            // Sets the Http Only flag and the Secure flag        
            setcookie("top_security_ssl", $token, time()+3600, "/", "", true, true);

        }
        
        break;
        
    default :
        
        $message = "<p>Click <a href=\"top_security.php\" target=\_blank\>here</a> to access our top security page.</p>";
        
        // Deletes the cookies
        setcookie("top_security_nossl", "", time()-3600, "/", "", false, false);
        setcookie("top_security_ssl", "", time()-3600, "/", "", false, false);
        
        break;
  
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

<title>OrangeBox - Session Management</title>

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
    
    <h1>Session Mgmt. - Strong Sessions</h1>
    
    <form action="<?php echo($_SERVER["SCRIPT_NAME"]); ?>" method="POST">

        <p>

        Click the button to see your current cookies:  
        <button type="submit" name="form" value="cookies">Cookies</button>

        </p>

    </form>
    
    <?php echo $message;?>
    
    
    <table id="table_yellow">

        <tr height="30" bgcolor="#ffb717" align="center">

            <td width="150"><b>Name</b></td>
            <td width="550"><b>Value</b></td>

        </tr>
<?php

if(isset($_POST["form"]))
{

    foreach ($_COOKIE as $key => $cookie)
    {        

?>

        <tr height="30">

            <td><?php echo $key;?></td>
            <td><?php echo $cookie;?></td>

        </tr>
<?php

    }

}

?>        
    </table>

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