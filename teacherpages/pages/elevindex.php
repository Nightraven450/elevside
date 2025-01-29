<?php

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

class Student
{
    public $name;
    public $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$feedback = ""; // Initialize feedback as empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $password = trim($_POST['password'] ?? '');
    $username = trim($_POST['username'] ?? ''); // Use the exact username from the form
    $email = $username . '@gmail.com';

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($name) || $age <= 0) {
        $feedback = "<span style='color:red;'>Please fill in all fields correctly.</span>";
    } else {
        $student = new Student($name, $age);

        // Prepare and bind insert statement
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, name, age) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $email, $password, $student->name, $student->age);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to prevent resubmission
            header("Location: index.php?p=1&page=elevindex");
            exit;
        } else {
            $feedback = "<span style='color:red;'>Error: " . $stmt->error . "</span>";
        }

        // Close statement
        $stmt->close();
    }
}

// Close database connection
$mysqli->close();

?>

<script>
    function generateUsername() {
        const nameInput = document.getElementById('name').value;
        const usernameField = document.getElementById('username');
        const hiddenUsernameField = document.getElementById('hiddenUsername'); // Hidden field to store username
        const randomNumbers = Math.floor(Math.random() * 900) + 100; // 3-digit random number
        const username = nameInput.replace(/\s+/g, '_').toLowerCase() + randomNumbers;

        usernameField.value = username;
        hiddenUsernameField.value = username; // Store in hidden input field
        document.getElementById('email').value = username + '@gmail.com';
    }
</script>


<div class="form-container">
    <div class="header">Tilføj Elev</div>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required oninput="generateUsername()">
        <br>
        <label for="username">Username:</label>
        <input type="text" id="username" readonly>
        <input type="hidden" id="hiddenUsername" name="username"> <!-- Hidden field -->
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" readonly>
        <br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br>
        <input type="submit" value="Add Student">
    </form>
    <?php if (!empty($feedback)) echo $feedback; ?>
</div>