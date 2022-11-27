<?php

   

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("selections.php");

$message = "";
$authorized_device = false;

// No differences between the security levels
switch($_COOKIE["security_level"])
{

    case "0" :    
    
        $authorized_device = check_user_agent();                
        break;

    case "1" :  
       
        $authorized_device = check_user_agent();        
        break;

    case "2" :

        $authorized_device = check_user_agent();        
        break;

    default :
  
        $authorized_device = check_user_agent();        
        break;

}

function check_user_agent()
{

    $user_agent = $_SERVER["HTTP_USER_AGENT"];
     
    // Debugging
    // echo $user_agent;
    
    $authorized_device = false;

    $devices = array("iPhone", "iPad", "iPod", "Android");
    
    // Searches for a string in an array
    foreach($devices as $str)
    {

        // echo $str;
        if(strpos($user_agent, $str) !== false) 
        {      
        
            // Debugging    
            // echo $user_agent . " contains the word " . $str;
        
            $authorized_device = true;
        
        }

    } 
    
    return $authorized_device;
 
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

<title>OrangeBox - Missing Functional Level Access Control</title>

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
    
    <h1>Restrict Device Access</h1>

    <p>Only some authorized devices have access to the content of this page.</p>

    <p>

    <?php 

    if($authorized_device != false)
    {

        $message = "<font color=\"green\">This is a smartphone or a tablet computer!</font>";  

    }

    else
    {

        $message = "<font color=\"red\">This is not a smartphone or a tablet computer (Apple/Android)!</font>";   

    }

    echo $message;

    ?>


    </p>

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