<?php

   

include("security.php");
include("security_level_check.php");

switch($_COOKIE["security_level"])
{
        
    case "0" : 
            
        header("Location: ba_pwd_attacks_1.php");
        
        break;
        
    case "1" :
                
        header("Location: ba_pwd_attacks_2.php");
        
        break;
        
    case "2" :           
       
        header("Location: ba_pwd_attacks_4.php");
        
        break;
        
    default : 
            
        header("Location: ba_pwd_attacks_1.php");
        
        break;
       
} 

?>