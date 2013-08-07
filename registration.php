<?php
require 'header.php';

$tableName = DB_PREFIX . "users";
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = htmlentities($_POST['user']);
$dob = $_POST['dob'];

// Username

// Prepare the query
$usernameQuery = $database->prepare("SELECT id FROM " . $tableName . " WHERE username = :username");
// Execute the query with the data
$usernameQuery->execute(array(':username' => $username));
// Get all the data from the query
$result = $usernameQuery->fetchAll();

if ($result != False)
{
	die("That username is already in use!");
}

// Email
if ($_POST['email'] === $_POST['email_confirm'])
{
	$email = $_POST['email'];	
}
else
{
	die("The emails did not match");
}

// Do the same here
$emailQuery = $database->prepare("SELECT id FROM " . DB_PREFIX . "users WHERE email = :email");
$emailQuery->execute(array(':email' => $email));
$result = $emailQuery->fetchAll();

if ($result != False)
{
	die("That email is already in use!");
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
$fileName = NULL;

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
		echo 'An error occured: ' . $_FILES['avatar']['error'];
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


try
{
	$query = $database->prepare("INSERT INTO " . $tableName . " (`username`, `email`, `gid`, `age`, `fname`, `lname`, `dunno`, `pass`, `avatar`)
	VALUES (:username, :email, '1', :dob, :fname, :lname, :salt, :password, :fileName)");

	// Execute the query with the data
	$query->execute(array(
						':username' => $username,
						':email' => $email,
						':dob' => $dob,
						':fname' => $fname,
						':lname' => $lname,
						':password' => $password,
						':salt' => $saltRemoved,
						':fileName' => $fileName));
}
catch(PDOException $e){
	echo $e;
}

if ($query->rowCount() == 1)
{
	echo "You have registered successfullly!";
}
else
{
	echo "There was an error registering the user!";
	echo $username . '<br />' . $email;
}