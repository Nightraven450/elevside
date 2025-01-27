<?php
session_start(); // Ensure session is started
include_once("header.php");

// Content start
$page = $_GET['page'] ?? 'elevindex';  // Default to 'main' page
if (file_exists("pages/$page.php")) {
    include_once("pages/$page.php");
} else {
    include_once("pages/404.php");
}

include_once("footer.php");