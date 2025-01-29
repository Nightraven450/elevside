<?php
session_start(); // Ensure session is started

include_once("../includes/header.php"); // Include the header for navigation

// Database connection settings
$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

$feedback = ""; // Initialize feedback as empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $image = $_POST['image'] ?? ''; // Assuming image is uploaded or provided as a URL

    // Validate input
    if (empty($name) || empty($subject) || empty($phone)) {
        $feedback = "<span style='color:red;'>Please fill in all fields.</span>";
    } else {
        // Create connection
        $mysqli = new mysqli($host, $user, $pass, $database);

        // Check for connection errors
        if ($mysqli->connect_error) {
            $feedback = "<span style='color:red;'>Database connection failed: " . $mysqli->connect_error . "</span>";
        } else {
            // Prepare and bind to the correct table
            $stmt = $mysqli->prepare("INSERT INTO teachers (name, subject, phone, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $subject, $phone, $image);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the correct page to prevent resubmission
                header("Location: index.php?p=1&page=lærer");
                exit;
            } else {
                $feedback = "<span style='color:red;'>Error: " . $stmt->error . "</span>";
            }

            // Close connections
            $stmt->close();
        }
        $mysqli->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css"> <!-- Link to the correct CSS file -->
</head>
<body>

<main> 
    <h1>Add New Teacher</h1>
    <div class="form-container">
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image">
            <br>
            <input type="submit" value="Add Teacher">
        </form>
        <?php if (!empty($feedback)) echo $feedback; ?>
    </div>
</main>
</body>
</html>
