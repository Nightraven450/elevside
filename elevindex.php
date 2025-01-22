<?php
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

class Student {
    public $name;
    public $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
}

$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

require_once("includes/settings.php");
require_once("pages/Karakter.php");

$feedback = ""; // Initialize feedback as empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';

    // Generate username and email
    $username = strtolower(str_replace(' ', '_', $name));
    $random_numbers = rand(0, 10) . rand(0, 10) . rand(0, 10);
    $username .= $random_numbers;
    $email = $username . '@gmail.com';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($name) || empty($age)) {
        $feedback = "<span style='color:red;'>Please fill in all fields.</span>";
    } else {
        $student = new Student($name, $age);
        
        // Create connection
        $mysqli = new mysqli($host, $user, $pass, $database);

        // Check for connection errors
        if ($mysqli->connect_error) {
            $feedback = "<span style='color:red;'>Database connection failed: " . $mysqli->connect_error . "</span>";
        } else {
            // Prepare and bind to the correct table
            $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, name, age) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $username, $email, $password, $student->name, $student->age);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the same page to prevent resubmission
                header("Location: elevindex.php");
                exit;
            } else {
                $feedback = "<span style='color:red;'>Error: " . $stmt->error . "</span>";
            }

            // Close connections
            $stmt->close();
            $mysqli->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            position: relative;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0; /* Rounded top corners */
        }
    </style>
    <script>
        function generateUsername() {
            const nameInput = document.getElementById('name').value;
            const usernameField = document.getElementById('username');
            const randomNumbers = Math.floor(Math.random() * 10) + '' + Math.floor(Math.random() * 10) + '' + Math.floor(Math.random() * 10);
            const username = nameInput.replace(/\s+/g, '_').toLowerCase() + randomNumbers;
            usernameField.value = username;
            document.getElementById('email').value = username + '@gmail.com';
        }
    </script>
</head>
<body>
    <div class="form-container">
        <div class="header">Add Student</div>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required oninput="generateUsername()">
            <br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            <br>
            <input type="submit" value="Add Student">
        </form>
        <?php if (!empty($feedback)) echo $feedback; ?>
    </div>
</body>
</html>
