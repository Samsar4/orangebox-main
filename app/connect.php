<?php

   

// Connection settings
include("config.inc.php");

// Connects to the server
$link = mysql_connect($server, $username, $password);

// Checks the connection
if(!$link)
{
    
    // @mail($recipient, "Could not connect to server: ", mysql_error());
    
    die("Could not connect to the server: " . mysql_error());
    
}

// Connects to the database
$database = mysql_select_db($database, $link);

// Checks the connection
if(!$database)
{
    
    // @mail($recipient, "Could not connect to database: ", mysql_error());
    
    die("Could not connect to the database: " . mysql_error()); 

}

// mysql_close($link);

?>