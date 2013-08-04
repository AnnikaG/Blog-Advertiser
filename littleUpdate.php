<?php
require 'header.php';

$query = "ALTER TABLE " . DB_PREFIX . "users ADD avatar varchar(155)";

$result = mysql_query($query);

if ($result == True)
{
	echo "It was successfully updated";
}
else
{
	echo "There was an error";
}
