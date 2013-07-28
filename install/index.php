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
	$tablePrefix = DB_PREFIX;
	$installQuery = "CREATE TABLE " . $tablePrefix . "users
				(
					id int(250) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					username varchar(255),
					email varchar(255),
					gid int(10),
					age date,
					fname varchar(255),
					lname varchar(255),
					pass char(32)
				);";
	// More rows & types need changing
	
	$result = mysql_query($installQuery);

	if ($result == True)
	{
		echo 'Yay! It worked' .
		'<a href="index.php?action=addUser">Continue</a>';
	}
	else
	{
		echo 'Noooo, it didn\'t work! :( More work for me';
		echo $installQuery;
	}
}
elseif ($action == 'addUser')
{
	?>
	<form action="index.php?action=createAdmin" method="post">
		<label for="username">Username: </label><input type="text" name="username" id="username" required></input>
		<br /><label for="password">Password: </label><input type="password" name="password" id="password" required></input>
		<br /><label for="email">Email: </label><input type="email" name="email" id="email" required></input>
		<br /><label for="dob">Date of Birth: </label><input type="date" name="dob" id="dob" required</form></input>
		<br /><input type="submit" value="Submit"></input>
	</form>
	<?php
}
elseif ($action == 'createAdmin')
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$dob = $_POST['dob'];

	// Password etc.
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
<?php echo DB_PREFIX;

}

?>