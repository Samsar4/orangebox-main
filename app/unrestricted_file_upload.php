<?php

   

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("selections.php");

if(isset($_POST["form"]))
{
    
    $file_error = "";
    
    switch($_COOKIE["security_level"])
    {
         
        case "0" : 
            
            move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
            
            break;
        
        case "1" :
            
            $file_error = file_upload_check_1($_FILES["file"]);
            
            if(!$file_error)
            {
                
                move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
    
            }            
            
            break;
        
        case "2" :            
                       
            $file_error = file_upload_check_2($_FILES["file"], array("jpg","png"));
            
            if(!$file_error)
            {
                
                move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
    
            }            
            
            break;
        
        default : 
            
            move_uploaded_file($_FILES["file"]["tmp_name"],"images/" . $_FILES["file"]["name"]);
            
            break;   

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

<title>OrangeBox - Unrestricted File Upload</title>

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
    
    <h1>Unrestricted File Upload</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST" enctype="multipart/form-data">

        <p><label for="file">Please upload an image:</label><br />
        <input type="file" name="file"></p>

        <input type="hidden" name="MAX_FILE_SIZE" value="10">
        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="100000"> -->

        <input type="submit" name="form" value="Upload">

    </form>

    <br />
    <?php

    if(isset($_POST["form"]))
    {

        if(!$file_error)
        {

            echo "The image has been uploaded <a href=\"images/" . $_FILES["file"]["name"] . "\" target=\"_blank\">here</a>.";

        }

        else
        {

            echo "<font color=\"red\">" . $file_error . "</font>";        

        }

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