<?php

   

include("admin/settings.php");

session_start();

$addresses = array();
@list($ip, $len) = explode('/', $AIM_subnet);

if(($min = ip2long($ip)) !== false)
{

    $max = ($min | (1<<(32-$len))-1);
    for($i = $min; $i < $max; $i++)
    $addresses[] = long2ip($i);

}

if(in_array($_SERVER["REMOTE_ADDR"], $AIM_IPs) or in_array($_SERVER["REMOTE_ADDR"], $addresses))
{

    ini_set("display_errors", 0);

    $_SESSION["login"] = "A.I.M.";
    $_SESSION["admin"] = "1";

}

if(!(isset($_SESSION["login"]) && $_SESSION["login"]))
{
    
    header("Location: login.php");
    
    exit;
   
}

?>