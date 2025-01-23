<?php
session_start();  // Initialize session
$feedback = '';  // Initialize feedback message

if (isset($_POST['email']) && isset($_POST['password'])) {

    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $database = 'elevside';

    $form_email = trim($_POST['email']);  
    $form_password = trim($_POST['password']);

    $mysqli = new mysqli($host, $user, $pass, $database);

    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    // Updated SQL query to include username
    $stmt = $mysqli->prepare("SELECT `email`, `password`, `username` FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $form_email);  
    $stmt->execute();  
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_object();  
        $db_password = $user->password;

        // Directly compare the entered password with the stored password
        if ($form_password === $db_password) {
            // Set session variables
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user->username;  // Store username in session
            header("Location: http://localhost:3000/index.php?p=2&page=main");
            exit(); // Ensure no further code is executed after redirection
        } else {
            $feedback = 'Incorrect password!';
        }
    } else {
        $feedback = 'No user found with this email!';
    }

    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($feedback): ?>
            <div class="feedback"><?php echo $feedback; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
