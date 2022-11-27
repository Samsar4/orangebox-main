<?php

   

include("security.php");
include("security_level_check.php");
include("connect_i.php");

$login = $_SESSION["login"];

$sql = "SELECT * FROM users WHERE login = '" . $login . "'";

$recordset = $link->query($sql);             

if(!$recordset)
{

    die("Error: " . $link->error);

}

$row = $recordset->fetch_object();

header("Content-Type: text/plain");

if($row)
{

    $secret = $row->secret;

    echo "Your secret: " . $secret;          

}

$link->close();

?>