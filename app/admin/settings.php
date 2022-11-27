<?php

   

// Database connection settings
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "OrangeBox";

// SQLite database name
$db_sqlite = "db/OrangeBox.sqlite";

// SMTP settings
$smtp_sender = "OrangeBox@mailinator.com";
$smtp_recipient = "OrangeBox@mailinator.com";
$smtp_server = "";

// A.I.M.
// A.I.M., or Authentication Is Missing, is a no-authentication mode
// It can be used for testing web scanners and crawlers
// Steps to crawl all pages, and to detect all vulnerabilities without authentication:
//   1. Change the IP address(es) in this file to the IP address(es) of your tool(s)
//   2. Point your web scanners, crawlers or attack tools to this URL: http://[OrangeBox-IP]/OrangeBox/aim.php
//   3. Push the button: all hell breaks loose...
$AIM_IPs = array("6.6.6.6", "6.6.6.7", "6.6.6.8", "10.0.1.66");
$AIM_subnet = "6.6.6.0/30";
//
// Add here the files that could break OrangeBox or your web server in the A.I.M. mode
$AIM_exclusions = array("aim.php", "ba_logout.php", "cs_validation.php", "csrf_1.php", "http_verb_tampering.php", "ldap_connect.php", "ldapi.php", "portal.php", "sm_dos_2.php", "sm_obu_files.php");

// Evil bee mode
// All OrangeBox security levels are bypassed in this mode by using a fixed cookie (security_level: 666)
// It can be combined with the A.I.M. mode, your web scanner will ONLY detect the vulnerabilities
// Evil bees are HUNGRY :)
// Possible values: 0 (off) or 1 (on)
$evil_bee = 0;

// Static credentials
// These credentials are used on some PHP pages
$login = "bee";
$password = "bug";

?>
