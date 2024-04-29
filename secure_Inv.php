<?php
    session_start();
    //If the user is not signed in and their employee type is not "inventory department", redirect them to index.php
    if (!isset($_SESSION['username']) || $_SESSION['emp_type'] != "inventory department") {
        echo "<script>alert('You are not authorized to access this page.'); window.location='index.php';</script>";
        exit();
    }
?>
