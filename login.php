<?php 
require 'header.php'; 

if (isset($_GET))
{
	$action = $_GET['action'];
}
?>



<?php
if ($action == 'submit')
{
	$email = htmlentities($_POST['email']);

	$query = "SELECT `pass`, `dunno` FROM " . DB_PREFIX . "users WHERE email = '$email'";
	$result = mysql_query($query);

	if ($result == False)
	{
		die("Your email address could not be found!");
	}
	else
	{
		$info = mysql_fetch_array($result, MYSQL_ASSOC);
	}

	$password = md5($_POST['password'] . md5($info['dunno']));

	if ($password == $info['pass'])
	{
		$query = "SELECT id, username, email, gid, age, fname, lname, avatar FROM " . DB_PREFIX . "users WHERE email = '$email'";
		$_SESSION['user'] = mysql_fetch_array(mysql_query($query), MYSQL_ASSOC);
		echo "You have successfully logged in, " . $_SESSION['user']['username'];
		echo "<a href=\"login.php?action=logOut\">Log Out</a>";
	}
	else
	{
		die("Your password was incorrect!");
	}

}
elseif ($action == 'logOut')
{
	session_destroy();
}
else
{ ?>

<form action="login.php?action=submit" method="post">
	<!-- Will have JS checks for emptiness etc. -->
	<label for="email">Email: </label><input type="email" id="email" name="email">
	<label for="password">Password: </label><input type="password" id="password" name="password">
	<input type="submit" value="Submit">
	<!-- Remember me coming soon -->
</form>

<?php
}