<?php

include("admin/settings.php");

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<title>OrangeBox - A.I.M.</title>

</head>

<body style="font-family:arial;font-size:15px;">

<h1>A.I.M.</h1>

<p>A.I.M., or Authentication Is Missing, is a no-authentication mode that can be used for testing web scanners and crawlers.</p>

<p>Steps to crawl all pages, and to detect all vulnerabilities without authentication:</p>

<p>1. Change the IP address in the settings file (admin/settings.php) to your IP address: <?php echo $_SERVER["REMOTE_ADDR"];?></p>

<p>2. Point your web scanner, crawler or attack tool to this URL: <?php echo "http://" . $_SERVER["HTTP_HOST"] . htmlspecialchars($_SERVER["REQUEST_URI"], ENT_QUOTES, "UTF-8");?></p>

<p>3. Push the button: all hell breaks loose...</p>

<p><img src="./images/evil_bee.png"></p>

<?php

$bugs = file("bugs.txt");

// Displays all bugs, from the array 'bugs' (bugs.txt)
foreach ($bugs as $key => $value)
{

    $bug = explode(",", trim($value));

    // Debugging
    // echo "key: " . $key;
    // echo " value: " . $bug[0];
    // echo " filename: " . $bug[1] . "<br />"; 
 
    if(!in_array($bug[1], $AIM_exclusions))
    {

        echo "<p><a href='$bug[1]'>$bug[0]</a></p>";

    }

}

?>

</body>

</html>