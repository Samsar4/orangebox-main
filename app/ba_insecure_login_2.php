<?php

   

include("security.php");
include("security_level_check.php");
include("admin/settings.php");

$bugs = file("bugs.txt");

if(isset($_POST["form_bug"]) && isset($_POST["bug"]))
{
        
            $key = $_POST["bug"]; 
            $bug = explode(",", trim($bugs[$key]));
            
            // Debugging
            // print_r($bug);
            
            header("Location: " . $bug[1]);
            
            exit;
   
}
 
if(isset($_POST["form_security_level"]) && isset($_POST["security_level"]))    
{
    
    $security_level_cookie = $_POST["security_level"];
    
    switch($security_level_cookie)
    {

        case "0" :

            $security_level_cookie = "0";
            break;

        case "1" :

            $security_level_cookie = "1";
            break;

        case "2" :

            $security_level_cookie = "2";
            break;

        default : 

            $security_level_cookie = "0";
            break;

    }

    if($evil_bee == 1)
    {

        setcookie("security_level", "666", time()+60*60*24*365, "/", "", false, false);

    }
    
    else        
    {
      
        setcookie("security_level", $security_level_cookie, time()+60*60*24*365, "/", "", false, false);
        
    }

    header("Location: ba_insecure_login.php");
    
    exit;

}

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

$message = "";

// Debugging
// print_r($_REQUEST);

if(isset($_REQUEST["secret"]))   
{ 
        
    if($_REQUEST["secret"] == "hulk smash!")
    {
        
        $message = "<font color=\"green\">The secret was unlocked: HULK SMASH!</font>";
        
    }
    
    else        
    {

        $message = "<font color=\"red\">Still locked... Don't lose your temper Bruce!</font>";

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

<title>OrangeBox</title>

<script language="javascript">   

function unlock_secret()
{

    var OrangeBox = "bash update killed my shells!"

    var a = OrangeBox.charAt(0);  var d = OrangeBox.charAt(3);  var r = OrangeBox.charAt(16);
    var b = OrangeBox.charAt(1);  var e = OrangeBox.charAt(4);  var j = OrangeBox.charAt(9);
    var c = OrangeBox.charAt(2);  var f = OrangeBox.charAt(5);  var g = OrangeBox.charAt(4);
    var j = OrangeBox.charAt(9);  var h = OrangeBox.charAt(6);  var l = OrangeBox.charAt(11);
    var g = OrangeBox.charAt(4);  var i = OrangeBox.charAt(7);  var x = OrangeBox.charAt(4);
    var l = OrangeBox.charAt(11); var p = OrangeBox.charAt(23); var m = OrangeBox.charAt(4);
    var s = OrangeBox.charAt(17); var k = OrangeBox.charAt(10); var d = OrangeBox.charAt(23);
    var t = OrangeBox.charAt(2);  var n = OrangeBox.charAt(12); var e = OrangeBox.charAt(4);
    var a = OrangeBox.charAt(1);  var o = OrangeBox.charAt(13); var f = OrangeBox.charAt(5);
    var b = OrangeBox.charAt(1);  var q = OrangeBox.charAt(15); var h = OrangeBox.charAt(9);
    var c = OrangeBox.charAt(2);  var h = OrangeBox.charAt(2);  var i = OrangeBox.charAt(7);
    var j = OrangeBox.charAt(5);  var i = OrangeBox.charAt(7);  var y = OrangeBox.charAt(22);
    var g = OrangeBox.charAt(1);  var p = OrangeBox.charAt(4);  var p = OrangeBox.charAt(28);
    var l = OrangeBox.charAt(11); var k = OrangeBox.charAt(14);
    var q = OrangeBox.charAt(12); var n = OrangeBox.charAt(12);
    var m = OrangeBox.charAt(4);  var o = OrangeBox.charAt(19);

    var secret = (d + "" + j + "" + k + "" + q + "" + x + "" + t + "" +o + "" + g + "" + h + "" + d + "" + p);

    if(document.forms[0].passphrase.value == secret)
    { 
              
        // Unlocked
        location.href="<?php echo($_SERVER["SCRIPT_NAME"]); ?>?secret=" + secret;

    }
    
    else
    {
        
        // Locked
        location.href="<?php echo($_SERVER["SCRIPT_NAME"]); ?>?secret=";
                
    }

}	

</script>

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

    <h1>Broken Auth. - Insecure Login Forms</h1>

    <p>Enter the correct passphrase to unlock the secret.</p>

    <form>   

        <p><label for="name">Name:</label><font color="white">brucebanner</font><br />
        <input type="text" id="name" name="name" size="20" value="brucebanner" /></p> 

        <p><label for="passphrase">Passphrase:</label><br />
        <input type="password" id="passphrase" name="passphrase" size="20" /></p>

        <input type="button" name="button" value="Unlock" onclick="unlock_secret()" /><br />

    </form>

    </br >    
    <?php echo $message;?>    
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