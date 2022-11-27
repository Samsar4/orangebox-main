<?php

   

header("Content-Type: text/plain");

if(isset($_SERVER["HTTP_ORIGIN"]) and $_SERVER["HTTP_ORIGIN"] == "http://intranet.itsecgames.com")
{

    header("Access-Control-Allow-Origin: http://intranet.itsecgames.com");

	echo "Wolverine's secret: What's a Magneto?";
	
}

else
{

    echo "This is just a normal page with no secrets :)";

}

?>