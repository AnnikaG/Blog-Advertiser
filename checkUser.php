<?php
require 'header.php';
echo $_SESSION['user']['id'];
echo "<br />" . $_SESSION['user']['username'];
echo "<a href=\"login.php?action=logOut\">Log Out</a>";
?>