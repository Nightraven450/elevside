<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Page</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        body {
            background-image: url('images/backround.jpg'); /* Set the background image */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the image */
            height: 100vh; /* Full height */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-direction: column; /* Stack elements vertically */
            color: white; /* Text color */
        }
        .login-button {
            padding: 15px 30px; /* Button padding */
            font-size: 18px; /* Button font size */
            background-color: #007bff; /* Button color */
            color: white; /* Text color */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Rounded corners */
            margin-top: 20px; /* Space above the button */
        }
    </style>
</head>
<body>
    <h1>Syddansk Erhvervsskole</h1> <!-- Title -->
    <p>Sign in with your email</p> <!-- Instruction -->
    <a href="pages/login.php" class="login-button">Login</a> <!-- Login button -->
</body>
</html>
