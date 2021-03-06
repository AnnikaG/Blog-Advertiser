<?php

require '../header.php';

// Check $_GET is set (i.e. it has a value)

if (isset($_GET))
{
	$action = $_GET['action'];
}

// Make sure fopen is enabled, if not throw an error

if (!function_exists('fopen'))
{
	die('fopen must be enabled!');
}

if ($action == 'dbConnectInfo')
{

	// Write info to config file

	$configText = '<?php
	if (!defined(\'DB_HOST\'))
	{
		define(\'DB_HOST\', \'' . $_POST['host'] . '\');
	}
	if (!defined(\'DB_USER\'))
	{
		define(\'DB_USER\', \'' . $_POST['username'] . '\');
	}
	if (!defined(\'DB_PASSWORD\'))
	{
		define(\'DB_PASSWORD\', \'' . $_POST['password'] . '\');
	}
	if (!defined(\'DB_NAME\'))
	{
		define(\'DB_NAME\', \'' . $_POST['dbname'] . '\');
	}
	if (!defined(\'DB_PREFIX\'))
	{
		define(\'DB_PREFIX\', \'' . $_POST['tableprefix'] . '\');
	}
?>
	';

	$configFile = fopen('../inc/config.php', 'w');

	fwrite($configFile, $configText);

	echo '<a href="index.php?action=createTables">Continue</a>';
}
elseif ($action == 'createTables')
{
	// Prepare the query for executing. Not really needed here, but used anyway
	$installQuery = $database->prepare("CREATE TABLE " . DB_PREFIX . "users
				(
					id int(250) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					username varchar(255),
					email varchar(255),
					gid int(10),
					age date,
					fname varchar(255),
					lname varchar(255),
					pass char(32),
					dunno char(32),
					avatar varchar(155)
				);");
	// More rows & types need changing
	
	// Execute $installQuery
	$result = $installQuery->execute();

	if ($result == True)
	{
		echo 'Yay! It worked' .
		'<a href="index.php?action=addUser">Continue</a>';
	}
	else
	{
		echo 'Noooo, it didn\'t work! :( More work for me';
	}
}
elseif ($action == 'addUser')
{
	?>
	<script>
		$(document).ready(function() {
			$("#datepicker").datepicker();
		});
	</script>
<form action="index.php?action=createAdmin" method="post">
	<fieldset>
		<!-- User ID --> <input type="hidden" name="user_id" value="">
		<!-- First Name --> <label for="first_name">First Name</label> <input type="text" name="first_name">
		<!-- Last Name --> <label for="last_name">Last Name</label> <input type="text" name="last_name">
		<!-- Username --> <label for="user">Username</label> <input type="text" name="user">
		<!-- D.O.B --> <label for="dob">Date of Birth</label> <input id="datepicker" name="dob">
		<!-- E-mail --> <label for="email">E-mail</label> <input type="text" name="email">
		<!-- E-mail Confirm --> <label for="email_confirm">Confirm E-mail</label> <input type="text" name="email_confirm">
		<!-- Password --> <label for="password">Password <input type="password" name="password">
		<!-- Password Confirm --> <label for="password_confirm">Confirm Password</label> <input type="password" name="password_confirm">
		<!-- Submit --><input type="submit" name="submit" value="Register">
		<!-- Reset --><input type="reset" name="reset" value="Reset Fields">
	</fieldset>
</form>
	<?php
}
elseif ($action == 'createAdmin')
{
	$username = $_POST['user'];
	$email = $_POST['email'];
	$dob = $_POST['dob'];
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$salt = mcrypt_create_iv(32);
	$saltRemoved = str_replace("'", "", $salt);
	$password = md5($_POST['password'] . md5($saltRemoved));
	$tableName = DB_PREFIX . "users";

	// Prepare the query - :something are simply placeholders. This stops SQL Injections as data is never placed in the query itself
	$query = $database->prepare("INSERT INTO " . $tableName . " (`username`, `email`, `gid`, `age`, `fname`, `lname`, `dunno`, `pass`)
	VALUES (:username, :email, '1', :dob, :fname, :lname, :salt, :password)");

	// Execute the query with the data
	$query->execute(array(
						':username' => $username,
						':email' => $email,
						':dob' => $dob,
						':fname' => $fname,
						':lname' => $lname,
						':password' => $password,
						':salt' => $saltRemoved));

	if ($query->rowCount() == 1)
	{
		echo 'It worked!<br /><a href="index.php?action=settings">Continue</a>';
	} 
	else
	{
		echo 'It failed!';
	} 
}
elseif ($action == 'checkPass')
{
	// Not needed anymore
}
elseif ($action == 'settings')
{ ?>
	<form action="index.php?action=insertSettings" method="post">
		<label for="supportEmail">Support Email: </label><input type="text" name="supportEmail" id="supportEmail" required></input>
		<label for=""></label><!--- What else should we add? -->
<?php
}
else
{ ?>
	<h1>Blog Advertiser Install</h1>

	<form action="index.php?action=dbConnectInfo" method="post">
		<label for="host">Server Address: </label><input type="text" name="host" id="host" required></input>
		<br /><label for="username">Database Username: </label><input type="text" name="username" id="username" required></input>
		<br /><label for="password">Database Password: </label><input type="password" name="password" id="password"></input>
		<br /><label for="dbname">Database Name: </label><input type="text" name="dbname" id="dbname" required></input>
		<br /><label for="tableprefix">Table Prefix: </label><input type="text" name="tableprefix" id="tableprefix" required></input>
		<br /><input type="submit" value="Submit"></input>
	</form>
<?php

}

?>