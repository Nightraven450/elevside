<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/lærer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="nav">
        <button onclick="location.href='index.php?p=1&page=elevindex'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 1) {
                echo "<strong>Elevindex</strong>";
            } else {
                echo "Elevindex";
            }
            ?>
        </button>
        <button onclick="location.href='index.php?p=2&page=grades'">
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
        <button onclick="location.href='index.php?p=4&page=elever'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 4) {
                echo "<strong>Elever</strong>";
            } else {
                echo "Elever";
            }
            ?>
        </button>
        <button onclick="location.href='index.php?p=5&page=add_teacher'">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == 5) {
                echo "<strong>Tilføj Lærer</strong>";
            } else {
                echo "Tilføj Lærer";
            }
            ?>
        </button>
    </div>