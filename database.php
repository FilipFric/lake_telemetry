<?php 

$data = file_get_contents('./database.txt');

if ($data[-1] == "\n") {

	$data = substr($data, 0, -1); // Removing the last newline character from the string
}



echo $data;



?>