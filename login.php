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
	$email = $_POST['email'];

	$query = $database->prepare("SELECT `pass`, `dunno` FROM " . DB_PREFIX . "users WHERE email = :email");
	$query->execute(array(':email' => $email));
	$result = $query->rowCount();

	if ($result == 0)
	{
		die("Your email address could not be found!");
	}
	else
	{
		$info =$query->fetch(PDO::FETCH_ASSOC);
	}

	$password = md5($_POST['password'] . md5($info['dunno']));

	if ($password == $info['pass'])
	{
		$passwordQuery = $database->prepare("SELECT id, username, email, gid, age, fname, lname, avatar FROM " . DB_PREFIX . "users WHERE email = :email");
		$passwordQuery->execute(array(':email' => $email));
		$_SESSION['user'] = $passwordQuery->fetch(PDO::FETCH_ASSOC);
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
?>