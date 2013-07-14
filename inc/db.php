<?php

require 'config.php';

// Connect to MySQL Database
// Vars added for future updates

$server = DB_HOST;
$dbuser = DB_USER;
$dbpass = DB_PASSWORD;

if ($server != '' && $dbuser != '')
{
	$db = mysql_connect($server, $dbuser, $dbpass);
	$dbTable = mysql_select_db(DB_NAME);
}

?>