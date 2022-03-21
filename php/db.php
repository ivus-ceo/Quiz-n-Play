<?php

	$dbServerName = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "webtechtask";

	$link = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);

	mysqli_set_charset($link, "utf8");

	if (!$link) {
		die("Connection failed: ".mysqli_connect_error());
	}

?>
