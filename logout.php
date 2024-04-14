<?php
	session_start();
	session_destroy();
	echo "<script>
        window.alert('You have logged out successfully.');
        window.location.href = 'index.php';
        </script>";
?>
