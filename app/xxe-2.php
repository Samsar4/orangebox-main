<?php

   

include("security.php");
include("security_level_check.php");
include("connect_i.php");

$message = "";
$body = file_get_contents("php://input");

// If the security level is not MEDIUM or HIGH
if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2")
{

    ini_set("display_errors",1);

    $xml = simplexml_load_string($body);

    // Debugging
    // print_r($xml);

    $login = $xml->login;
    $secret = $xml->secret;

    if($login && $login != "" && $secret)
    {

        // $login = mysqli_real_escape_string($link, $login);
        // $secret = mysqli_real_escape_string($link, $secret);
        
        $sql = "UPDATE users SET secret = '" . $secret . "' WHERE login = '" . $login . "'";

        // Debugging
        // echo $sql;      

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Connect Error: " . $link->error);

        }

        $message = $login . "'s secret has been reset!";

    }

    else
    {

        $message = "An error occured!";

    }

}

// If the security level is MEDIUM or HIGH
else
{

    // Disables XML external entities. Doesn't work with older PHP versions!
    // libxml_disable_entity_loader(true);
    $xml = simplexml_load_string($body);
    
    // Debugging
    // print_r($xml);

    $login = $_SESSION["login"];
    $secret = $xml->secret;

    if($secret)
    {

        $secret = mysqli_real_escape_string($link, $secret);

        $sql = "UPDATE users SET secret = '" . $secret . "' WHERE login = '" . $login . "'";

        // Debugging
        // echo $sql;      

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Connect Error: " . $link->error);

        }

        $message = $login . "'s secret has been reset!";

    }

    else
    {

        $message = "An error occured!"; 

    }

}

echo $message;

$link->close();

?>