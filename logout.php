<?php
session_start();
$_SESSION['login'] = false; // Set login state to false
session_destroy(); // Destroy the session
header("Location: pages/start.php"); // Redirect to start.php
exit();
?>
