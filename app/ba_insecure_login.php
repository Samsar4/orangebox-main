<?php

   

include("security.php");
include("security_level_check.php");

switch($_COOKIE["security_level"])
{
        
    case "0" : 
            
        header("Location: ba_insecure_login_1.php");        
        break;
        
    case "1" :
                
        header("Location: ba_insecure_login_2.php");        
        break;
        
    case "2" :           
       
        header("Location: ba_insecure_login_3.php");        
        break;
        
    default : 
            
        header("Location: ba_insecure_login_1.php");        
        break;
       
} 

?>