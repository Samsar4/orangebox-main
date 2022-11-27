<?php

   

include("security.php");
include("security_level_check.php");

?>
<!DOCTYPE html>
<html>
    
<head>
        
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>OrangeBox - CAPTCHA box</title>

</head>

<body>

<table>

    <tr>
        
        <td><img src="captcha.php"></iframe></td>        
        <td><input type="button" value="Reload" onClick="window.location.reload()"></td>
        
    </tr>
    
</table>      
        
</body>

</html>