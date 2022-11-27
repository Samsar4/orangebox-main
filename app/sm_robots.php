<?php

   

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("selections.php");

$message = "";
$file = "robots.txt";
$catch = false;

switch($_COOKIE["security_level"])
{

    case "0" :            

        $color_1 = "";        
        $color_2 = "";
        
        break;

    case "1" :         

        $color_1 = "red";        
        $color_2 = "green";
        
        $message = "Don't place any sensitive files or directories in the <i>robots.txt</i> file!";
        
        break;

    case "2" :

        $color_1 = "red";        
        $color_2 = "green";
        
        $message = "Don't place any sensitive files or directories in the <i>robots.txt</i> file!";
        
        break;

    default :           

        $color_1 = "";        
        $color_2 = "";

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

<title>OrangeBox - Security Misconfiguration</title>

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
    
    <h1>Robots File</h1>
    
    Contents of <i>robots.txt</i>:
    
    <br /><br />

<?php

// Checks whether a file or directory exists    
if(is_file($file)) 
{

    $banned = array("admin", "documents", "passwords");
    
    // Opens the file
    $fp = fopen($file, "r") or die("Couldn't open $file.");

    while(!feof($fp))
    {

        // Reads 1 line from the file
        $line = fgets($fp,1024);
        
        // Checks if a banned word is present in the current line
        foreach($banned as $str)
        {
        
            if(strpos($line, $str) !== false) 
            {

               $catch = true;

            }
            
        }
        
        // If a banned word is present then the line is written with color 1
        if($catch == true)
        {

            echo "<font color=\"" . $color_1 . "\">" . $line . "</font><br />";

        }

        // If a banned word is not present then the line is written with color 2
        else
        {

            echo "<font color=\"" . $color_2 . "\">" . $line . "</font><br />";

        }
        
        $catch = false;        

    }

} 

?>


    <?php echo "<br />" . $message;?>


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