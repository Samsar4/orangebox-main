<?php

   

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("selections.php");

$ticket_price = 15;

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

<title>OrangeBox - Insecure DOR</title>

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
            <td><font color="black">Welcome <?php if(isset($_SESSION["login"])){if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);};}?></font></td>
            
        </tr>
        
    </table>   
   
</div> 

<div id="main">

    <h1>Insecure DOR (Order Tickets)</h1> 

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p>How many movie tickets would you like to order? (<?php echo $ticket_price ?> EUR per ticket)</p>
        
        <p>I would like to order <input type="text" name="ticket_quantity" value="1" size="2"> tickets.</p>

<?php

if($_COOKIE["security_level"] != "1" and $_COOKIE["security_level"] != "2")
{

?>
        <input type="hidden" name="ticket_price" value="<?php echo $ticket_price ?>">

<?php

}

?>
        <button type="submit" name="action" value="order">Confirm</button>

    </form>

<br />

<?php

if(isset($_REQUEST["ticket_quantity"]))
{
    
    if($_COOKIE["security_level"] != "2")
    {

        if(isset($_REQUEST["ticket_price"]))
        {

            $ticket_price = $_REQUEST["ticket_price"];

        }
        
    }
    
    $ticket_quantity = abs($_REQUEST["ticket_quantity"]);
    $total_amount = $ticket_quantity * $ticket_price;

    echo "<p>You ordered <b>" . $ticket_quantity . "</b> movie tickets.</p>";
    echo "<p>Total amount charged from your account automatically: <b>" . $total_amount . " EUR</b>.</p>";
    echo "<p>Thank you for your order!</p>";
    
    $_SESSION["amount"] = $_SESSION["amount"] - $total_amount;

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