<?php
require_once("includes/settings.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="styles/lærer.css">
</head>

<body>
    <div class="nav" style="display: flex; justify-content: space-between;">
        <button onclick="location.href='index.php?p=1&page=main'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 1) {
                echo "<strong>Main</strong>";
            } else {
                echo "Main";
            }
            ?>
        </button>
        <button onclick="location.href='index.php?p=2&page=karakter'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 2) {
                echo "<strong>Karakter</strong>";
            } else {
                echo "Karakter";
            }
            ?>
        </button>
        <button onclick="location.href='index.php?p=3&page=lærer'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 3) {
                echo "<strong>Lærer</strong>";
            } else {
                echo "Lærer";
            }
            ?>
        </button>
        <button style="margin-left: auto;"
            onclick="location.href='<?php echo isset($_SESSION['login']) && $_SESSION['login'] ? 'logout.php' : '../pages/login.php'; ?>'">
            <?php
            if (isset($_SESSION['login']) && $_SESSION['login']) {
                echo "Logout";
            } else {
                echo "Login";
            }
            ?>
        </button>
    </div>
    <div class="user-info" style="background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
        <?php if (isset($_SESSION['login']) && $_SESSION['login']): ?>
            <p>Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>