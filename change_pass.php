<?php 
	
	$message = "";
	
	// Checking wheter the request is a password change attempt
	if (isset($_POST['original_password']) && isset($_POST['password1']) && isset($_POST['password2'])) {
		
		$password_hash = file_get_contents('./pass_hash.txt'); // Getting password hash

		if (hash('sha256', $_POST['original_password']) != $password_hash) { // Checking the password

			$message = "<p class=\"red\">Wrong password</p>";

		} else {

			if ($_POST['password1'] != $_POST['password2']) {

				$message = "<p class=\"red\">Passwords do not match</p>";

			} else {

				if ($_POST['password1'] == "") {

					$message = "<p class=\"red\">Password can not be nothing</p>";

				} else {

					$password_hash = hash('sha256', $_POST['password1']); // Setting password_hash to the new password

					file_put_contents("pass_hash.txt", $password_hash); // Writing new hash to the pass_hash.txt

					$message = "<p class=\"green\">Success</p>";
				}
			}
		}	
	}
 ?>









<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="change_pass.css">
    <link rel="icon" href="favicon.ico">
	<title>Admin | change password</title>
</head>
<body>
	<a href="admin.php">Back</a>
	<form method="post" action="change_pass.php">
		<h1>Change Password</h1>
		<?php if ($message != "") {
			echo $message;
		} ?>
		<input type="password" name="original_password" placeholder="old password"><br><br>
		<input type="text" name="password1" placeholder="new password"><br><br>
		<input type="text" name="password2" placeholder="repeat"><br><br>
		<input class="submit" type="submit" name="submit" value="Submit">
	</form>

</body>
</html>