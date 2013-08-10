<?php
require 'header.php';

$query = $database->prepare("CREATE TABLE " . DB_PREFIX . "blogs
		(
			id int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			uid int(255),
			title varchar(255),
			category varchar(255),
			audience varchar(255),
			openingDate date,
			description text,
			link text,
			image text
		);");

if ($query->execute() == True)
{
	echo "It was successfully updated";
}
else
{
	echo "There was an error";
}
