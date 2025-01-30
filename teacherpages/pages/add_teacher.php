<?php
// Database connection settings
$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

$feedback = ""; // Initialize feedback as empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $mobil = $_POST['mobil'] ?? ''; // Updated variable name
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $imagePath = ''; // Initialize image path

    // Validate input
    if (empty($name) || empty($subject) || empty($mobil) || empty($email) || empty($password)) {
        $feedback = "<span style='color:red;'>Please fill in all fields.</span>";
    } else {
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Validate file type and size
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions) && $fileSize < 2000000) { // 2MB limit
                // Directory to save uploaded file
                $uploadFileDir = '../images/';
                $dest_path = $uploadFileDir . $fileName;

                // Move the file to the directory
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagePath = $dest_path; // Store the image path
                } else {
                    $feedback = "<span style='color:red;'>Error moving the uploaded file.</span>";
                }
            } else {
                $feedback = "<span style='color:red;'>Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions) . " and size must be less than 2MB.</span>";
            }
        }

        // Create connection
        $mysqli = new mysqli($host, $user, $pass, $database);

        // Check for connection errors
        if ($mysqli->connect_error) {
            $feedback = "<span style='color:red;'>Database connection failed: " . $mysqli->connect_error . "</span>";
        } else {
            // Prepare and bind to the correct table
            $stmt = $mysqli->prepare("INSERT INTO teachers (name, subject, mobil, email, password, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $subject, $mobil, $email, $password, $imagePath);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the correct page to prevent resubmission
                header("Location: index.php?p=3&page=lærer");
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
<main> 
    <h1 class = "add-teacher";>Add New Teacher</h1>
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            <br>
            <label for="mobil">Mobile:</label> <!-- Updated label -->
            <input type="text" id="mobil" name="mobil" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <br>
            <input type="submit" value="Add Teacher">

        </form>
        <?php if (!empty($feedback)) echo $feedback; ?>
    </div>
</main>
