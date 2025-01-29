<?php
$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set and is a valid number
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to the elever.php page
header("Location: ../index.php?p=4&page=elever");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
