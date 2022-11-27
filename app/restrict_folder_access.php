<?php

   

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("selections.php");

// Sets the directory
$directory = "documents";

// Downloads a file
if(isset($_GET["file"])) 
{

    $file = $_GET["file"];
    
    // Checks for directory traversal
    $directory_traversal_error = directory_traversal_check_3($file, $base_path = "./" . $directory); 
        
    if(!$directory_traversal_error)
    {

        // Checks if the file exists
        if(is_file($file)) 
        {

            // Debugging
            // echo $file;      
            
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . basename($file));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($file));

            ob_clean();

            flush();

            readfile($file) or die("Couldn't open $file.");

            exit;

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
    
    <h1>Restrict Folder Access</h1>

    <p>Only authorized users have access to the <i><?php echo $directory ?></i> folder.</p>

    <p>Log off and try to access files in this directory...</p>

    <?php

    switch($_COOKIE["security_level"])
    {

        case "0" :            

            // Deletes the '.htaccesss' file        
            if(file_exists($directory . "/.htaccess"))
            {    

                unlink($directory . "/.htaccess");

            }

            $dp = opendir($directory);

            while($line = readdir($dp))
            {

                if($line != "." && $line != "..")
                {

                    echo "<a href=\"" . $directory . "/" . $line . "\" target=\"_blank\">" . $line . "</a><br />";

                }

            }        

            break;

        case "1" :  

            // Creates the '.htaccess' file
            $fp = fopen($directory . "/.htaccess", "w");
            fputs($fp, "Deny from all", 200);
            fclose($fp);

            $dp = opendir($directory);

            while($line = readdir($dp))
            {

                if($line != "." && $line != ".." && $line != ".htaccess")
                {

                    echo "<a href=\"restrict_folder_access.php?file=" . $directory . "/" . $line . "\">" . $line . "</a><br />";

                }

            }

            break;

        case "2" :

            // Creates the '.htaccess' file
            $fp = fopen($directory . "/.htaccess", "w");
            fputs($fp, "deny from all", 200);
            fclose($fp);

            $dp = opendir($directory);

            while($line = readdir($dp))
            {

                if($line != "." && $line != ".." && $line != ".htaccess")
                {

                    echo "<a href=\"restrict_folder_access.php?file=" . $directory . "/" . $line . "\">" . $line . "</a><br />";

                }

            }

            break;

        default :

            // Deletes the '.htaccesss' file        
            if(file_exists($directory . "/.htaccess"))
            {    

                unlink($directory . "/.htaccess");

            }

            $dp = opendir($directory);

            while($line = readdir($dp))
            {

                if($line != "." && $line != "..")
                {

                    echo "<a href=\"" . $directory . "/" . $line . "\" target=\"_blank\">" . $line . "</a><br />";

                }

            }   

            break;

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