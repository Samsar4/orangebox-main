<?php

   

include("admin/settings.php");

$addresses = array();
@list($ip, $len) = explode('/', $AIM_subnet);

if(($min = ip2long($ip)) !== false)
{

    $max = ($min | (1<<(32-$len))-1);
    for($i = $min; $i < $max; $i++)
    $addresses[] = long2ip($i);

}

if(!(isset($_COOKIE["security_level"])) && !(in_array($_SERVER["REMOTE_ADDR"], $AIM_IPs)) && !(in_array($_SERVER["REMOTE_ADDR"], $addresses)))
{

    header("Location: security_level_set.php");
    
    exit;
 
}

?>