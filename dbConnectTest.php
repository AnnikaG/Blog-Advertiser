<?php
require 'header.php';
$dbTable = mysql_select_db(DB_NAME);

if ($dbTable == True)
{
	echo 'It worked! :D';
}
else
{
	echo 'Oh no! It failed. :(';
}

?>