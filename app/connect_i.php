<?php

   

// Connection settings
include("config.inc.php");

// Connects to the server
$link = new mysqli($server, $username, $password, $database);

// Checks the connection
if($link->connect_error)
{
    
    // @mail($recipient, "Connection failed: ", $link->connect_error);
    
    die("Connection failed: " . $link->connect_error);   
   
}

// $link->close();

?>