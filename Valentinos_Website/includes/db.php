<?php
// Initiate a session to be able to use $_SESSION global variables
session_start();

	// Declare variables
	$host = 'cristea.worcestercomputing.com';
	$dbname = 'vwnmjyoc_valentinos';
	$user = 'vwnmjyoc_valenti';
	$pass = 'worcester123';

	try {
		// Secure connection to databse using PDO
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	// Display  the error if connection is not successful.
	catch(PDOException $e) {
		echo $e->getMessage();

	}

?>
