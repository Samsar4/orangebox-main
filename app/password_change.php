<?php

   

include("security.php");
include("security_level_check.php");
include("connect_i.php");
include("selections.php");

$message = "";

if(isset($_REQUEST["action"]))
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

            $password_curr = $_REQUEST["password_curr"];
            $password_curr = mysqli_real_escape_string($link, $password_curr);
            $password_curr = hash("sha1", $password_curr, false);                
                
            $sql = "SELECT password FROM users WHERE login = '" . $login . "' AND password = '" . $password_curr . "'";
                
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
                    
                $sql = "UPDATE users SET password = '" . $password_new . "' WHERE login = '" . $login . "'";

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

                $message = "<font color=\"green\">The password has been changed!</font>";

            }
                
            else
            {
                    
                $message = "<font color=\"red\">The current password is not valid!</font>";
                    
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

<title>OrangeBox - Change Password</title>

</head>

<body>
    
<header>

<h1 class="glitch is-glitching" data-text="Hover me!">OrangeBox</h1>

 

</header>    

<div id="menu">
      
    <table>
        
        <tr>
            
            <td><a href="portal.php">Bugs</a></td>
            <td><font color="#ffb717">Change Password</font></td>
            <td><a href="user_extra.php">Create User</a></td>
            <td><a href="security_level_set.php">Set Security Level</a></td>
            <td><a href="reset.php" onclick="return confirm('All settings will be cleared. Are you sure?');">Reset</a></td>            
             
   
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="black">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>
            
        </tr>
        
    </table>   
   
</div> 

<div id="main">
    
    <h1>Change Password</h1>

    <p>Please change your password <b><?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);} ?></b>.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST"> 

        <p><label for="password_curr">Current password:</label><br />
        <input type="password" id="password_curr" name="password_curr"></p>       

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