<?php session_start();


		if (isset($_SESSION['authenticated'])) { // Checking if the session var is set

			if ($_SESSION['authenticated'] == true) { // If it`s set to true redirecting admin page

				echo '<script>window.location = \'admin.php\';</script>';

			}
		}

		$error = "";

		$password_hash = file_get_contents('./pass_hash.txt'); // Getting password hash

		if (isset($_POST['username']) && isset($_POST['password'])) { // Checking wheter the request is a login attempt

			if ($_POST['username'] == 'admin' && hash('sha256', $_POST['password']) == $password_hash) { // Checking password
		    $_SESSION['authenticated'] = true;
		    echo '<script>window.location = \'admin.php\';</script>';
		    exit();

		} else {

		    $error = '<p>Invalid password</p>';

			}
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="login.css">
	<title>Login</title>
</head>
<body>
	<a href="/">Back</a>
	<form method="post" action="login.php">
		<h1>Login</h1>
		<input type="text" name="username" class="username"value="admin"><br>
		<input type="password" name="password" class="password"><br>
		<input type="submit" name="submit" class="submit" value="Submit">

		<?php if ($error != "") {
			echo $error;
		} ?>

		
	</form>



</body>
</html>