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

require_once("../includes/settings.php");
require_once("../pages/Karakter.php");

$feedback = ""; // Initialize feedback as empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';

    // Generate base username
    $base_username = strtolower(str_replace(' ', '_', $name));
    
    // Check if username already exists
    $checkStmt = $mysqli->prepare("SELECT username FROM users WHERE username LIKE CONCAT(?, '%')");
    $checkStmt->bind_param("s", $base_username);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        // If a username exists, use the existing one
        $username = $base_username . rand(0, 999); // Append random numbers to avoid collision
    } else {
        // If no username exists, create a new one
        $username = $base_username . rand(0, 999); // Append random numbers
    }
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
        die("<span style='color:red;'>Database connection failed: " . $mysqli->connect_error . "</span>");
    }

        // Check for connection errors
        if ($mysqli->connect_error) {
            $feedback = "<span style='color:red;'>Database connection failed: " . $mysqli->connect_error . "</span>";
        } else {
            // Check if username or email already exists
            $checkStmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $checkStmt->bind_param("ss", $username, $email);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
        }

        if ($count > 0) {
            $feedback = "<span style='color:red;'>Username or email already exists. Please choose another.</span>";
        } else {
            // Prepare and bind to the correct table
            $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, name, age) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $username, $email, $password, $student->name, $student->age);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the correct page to prevent resubmission
                header("Location: index.php?p=1&page=elevindex");
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
        <div class="header">tilføj elev</div>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required>
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
