<?php
	session_start();

	//If the user is not signed in, they will be directed to index.php
	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}
?>