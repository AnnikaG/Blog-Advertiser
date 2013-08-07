<?php

require 'config.php';

// Connect to MySQL Database
// Vars added for future updates

$server = DB_HOST;
$dbuser = DB_USER;
$dbpass = DB_PASSWORD;
$dbname = DB_NAME;

// This tells us the driver (mysql), the host and the name of the db we are connecting to

$connect = 'mysql:host=' . $server . ';dbname=' . $dbname;

// Here we use a simple try/catch block in case we get any errors
try
{
	// Create a new instance of the PDO class, name it database. We now have a connection to the database!
	$database = new PDO($connect, $dbuser, $dbpass);
	// Set some error modes (will probably be removed for the live version)
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// If we do get an error....
catch(PDOException $e)
{
	// Print it out
	echo 'An error occured connecting to the database: ' . $e->getMessage();
}
?>