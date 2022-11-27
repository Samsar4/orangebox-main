<?php

   

include("connect_i.php");

$message = "";

if(isset($_GET["user"]) && isset($_GET["activation_code"]) )
{
    
    $login = $_GET["user"];
    $login = mysqli_real_escape_string($link, $login);    
    
    $activation_code = $_GET["activation_code"];
    $activation_code = mysqli_real_escape_string($link, $activation_code);               
                
    $sql = "SELECT * FROM users WHERE login = '" . $login . "' AND BINARY activation_code = '" . $activation_code . "'";
                
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
                    
        $sql = "UPDATE users SET activation_code = NULL, activated = 1 WHERE login = '" . $login . "'";

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

        $message = "<font color=\"green\">User activated!</font>";

    }
                
    else
    {

        $message = "<font color=\"red\">User not or already activated!</font>";

    }

}

else

{
    
    $message = "<font color=\"red\">Not a valid input!</font>";

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

<title>OrangeBox - User Activation</title>

</head>

<body>
    
<header>

<h1 class="glitch is-glitching" data-text="Hover me!">OrangeBox</h1>

 

</header>    

<div id="menu">
      
    <table>
        
        <tr>
            
            <td><a href="login.php">Login</a></td>
            <td><font color="#ffb717">User Activation</font></td>            
            
        </tr>
        
    </table>   
   
</div> 

<div id="main">

    <h1>User Activation</h1>

    <p><?php

    echo $message;

    $link->close();

    ?></p>

</div>
    
 
    
<div id="disclaimer">
          
    <p>OrangeBox is licensed under <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank"><img style="vertical-align:middle" src="./images/cc.png"></a>   </p>
   
</div>
    
<div id="bee">
    
    <img src="./images/bee_1.png">
    
</div>
      
</body>
    
</html>