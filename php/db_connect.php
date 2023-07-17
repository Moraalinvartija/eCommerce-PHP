<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "commerce";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
	//tsekkaa yhteys
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	  }

?>