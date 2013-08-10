<?php
require 'header.php';

if (is_null($_SESSION['user']))
{
	die("You must be logged in to use the Dashboard!");
}

$action = $_GET['action'];

if ($action == 'newBlog')
{
	
}