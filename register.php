<?php require "header.php"; ?>
	<script>
		$(document).ready(function() {
			$("#datepicker").datepicker();
		});
	</script>
<form action="registration.php" method="post">
	<fieldset>
		<!-- User ID --> <input type="hidden" name="user_id" value="">
		<!-- Full Name --> <label for="full_name">Full Name</label> <input type="text" name="full_name">
		<!-- Username --> <label for="user">Username</label> <input type="text" name="user">
		<!-- D.O.B --> <label for="dob">Date of Birth</label> <input id="datepicker">
		<!-- E-mail --> <label for="email">E-mail</label> <input type="text" name="email">
		<!-- E-mail Confirm --> <label for="email_confirm">Confirm E-mail</label> <input type="text" name="email_confirm">
		<!-- Password --> <label for="password">Password <input type="password" name="password">
		<!-- Password Confirm --> <label for="password_confirm">Confirm Password</label> <input type="password" name="password_confirm">
		<!-- Captcha --><label for="captcha">Captcha</label><input type="text" name="captcha">
		<!-- Submit --><input type="submit" name="submit" value="Register">
		<!-- Reset --><input type="reset" name="reset" value="Reset Fields">
	</fieldset>
</form>
