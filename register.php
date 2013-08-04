<?php require "header.php"; ?>
	<script>
		$(document).ready(function() {
			$("#datepicker").datepicker();
		});
	</script>
<form action="registration.php" method="post" enctype="multipart/form-data">
	<fieldset>
		<!-- User ID --> <label for="fname">Forename: </label><input type="text" name="fname">
		<!-- Full Name --> <label for="lname">Last Name: </label> <input type="text" name="lname">
		<!-- Username --> <label for="user">Username: </label> <input type="text" name="user">
		<!-- D.O.B --> <label for="dob">Date of Birth: </label> <input id="datepicker" name="dob">
		<!-- E-mail --> <label for="email">E-mail: </label> <input type="text" name="email">
		<!-- E-mail Confirm --> <label for="email_confirm">Confirm E-mail: </label> <input type="text" name="email_confirm">
		<!-- Password --> <label for="password">Password: <input type="password" name="password">
		<!-- Password Confirm --> <label for="password_confirm">Confirm Password: </label> <input type="password" name="password_confirm">
		<!-- Avatar --><label for="avatar">Avatar: </label><input type="file" id="avatar" name="avatar">
		<!-- Captcha --><label for="captcha">Captcha: </label><input type="text" name="captcha">
		<!-- Submit --><input type="submit" name="submit" value="Register">
		<!-- Reset --><input type="reset" name="reset" value="Reset Fields">
	</fieldset>
</form>
