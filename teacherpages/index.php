<?php
session_start(); // Ensure session is started
include_once("includes/header.php");

// Content start
$page = $_GET['page'] ?? 'elevindex';
if (file_exists("pages/$page.php")) {
    include_once("pages/$page.php");
} else {
    include_once("pages/404.php");
}

include_once("includes/footer.php");