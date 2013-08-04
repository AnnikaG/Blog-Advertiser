<?php
require 'header.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = htmlentities($_POST['user']);
$dob = $_POST['dob'];

// Email
if ($_POST['email'] === $_POST['email_confirm'])
{
	$email = $_POST['email'];	
}
else
{
	die("The emails did not match");
}

// Password
if (md5($_POST['password']) === md5($_POST['password_confirm']))
{
	$salt = mcrypt_create_iv(32);
	$saltRemoved = str_replace("'", "", $salt);
	$password = md5($_POST['password'] . md5($saltRemoved));
}
else
{
	die("The passwords did not match");
}

// Avatar
$allowedExtensions = array("jpeg", "jpg", "png", "gif");
$tempExtenstion = explode(".", $_FILES['avatar']['name']);
$extension = end($tempExtenstion);

if ((($_FILES['avatar']['type'] == 'image/jpeg')
	|| ($_FILES['avatar']['type'] == 'image/jpg')
	|| ($_FILES['avatar']['type'] == 'image/gif')
	|| ($_FILES['avatar']['type'] == 'image/pjpeg')
	|| ($_FILES['avatar']['type'] == 'image/png'))
	&& ($_FILES['avatar']['size'] < 30000)
	&& in_array($extension, $allowedExtensions))
{
	if ($_FILES['avatar']['error'] > 0)
	{
		die('An error occured: ' . $_FILES['avatar']['error']);
	}
	else
	{
		$_FILES['avatar']['name'] = $username . $_FILES['avatar']['name'];
		move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatars/' . $_FILES['avatar']['name']);
		$fileName = $_FILES['avatar']['name'];
	}
}
else
{
	echo 'There was an error uploading your avatar';
}



$query = "INSERT INTO `" . DB_PREFIX . "users` (`username`, `email`, `gid`, `age`, `fname`, `lname`, `dunno`, `pass`, `avatar`)
VALUES ('$username', '$email', '3', '$dob', '$fname', '$lname', '$saltRemoved', '$password', '$fileName')";

$result = mysql_query($query);

if ($result == True)
{
	echo "You have registered successfullly!";
}
else
{
	echo "There was an error registering the user!";
}