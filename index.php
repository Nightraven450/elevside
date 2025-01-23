<?php
session_start(); // Ensure session is started
include_once("includes/header.php");

// Check if user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: pages/login.php");
    exit();
}

// Content start
$page = $_GET['page'] ?? 'main';  // Default to 'main' page
if (file_exists("pages/$page.php")) {
    include_once("pages/$page.php");
} else {
    include_once("pages/404.php");
}
