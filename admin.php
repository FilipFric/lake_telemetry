<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) { // Checking login

    echo '<script>window.location = \'login.php\';</script>';
    exit();

	}

if (isset($_POST['new_data']) && $_POST['new_data'] != "") {

	file_put_contents("database.txt", $_POST['new_data']."\n", FILE_APPEND); // Appending to database.txt

}

if (isset($_POST['remove'])) {

	if ($_POST['remove'] == "-all-") {

			file_put_contents("database.txt", ""); // Writing empty string to database.txt

		} else {

			if ($_POST['remove'] != "") {

			$data = file_get_contents("database.txt"); // Getting the data from database.txt

			if ($data[-1] == "\n") {

				$data = substr($data, 0, -1); // Removing the last newline character from the string

			} 

			$list = explode("\n", $data); // Spliting the string data into a list on the \n


			for ($i=0; $i < (int)$_POST['remove'] ; $i++) {   // Running array_pop() according number of times

				array_pop($list);

			}

			$data = join("\n", $list); // Joining the list back to string

			if ($data != "") { // Checking whether the data is empty if so the \n is not needed

				$data = $data."\n"; // Adding the \n back
			}
			
			file_put_contents("database.txt", $data); // Writing data to the database.txt

		}

	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" href="favicon.ico">
    <title>Admin</title>
</head>
<body>
	<a class="back" href="/">Back</a>
	<a class="logout" href="logout.php">Logout</a>
    <a class="ps_change" href="change_pass.php">Change password</a>
    <div class="frame">
    	<h1>Admin</h1>
    	<p>You can use this page to add new or remove data on the site. In order to remove lates entry or entries write the number you want to remove, to remove all write "-all-".</p>
    	<iframe src="database.txt"></iframe><br><br>
	    <div class="forms">
	    	<form method="post" action="admin.php">
		    	<input type="text" name="new_data">
		    	<input class="submit" type="submit" name="submit" value="submit">
		    </form><br>
		    <form method="post" action="admin.php">
		    	<input type="text" name="remove">
		    	<input class="submit" type="submit" value="remove">
		    </form>
	    </div>
    </div>
</body>
</html>

