<?php
// Database connection settings
$host = '127.0.0.1'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$database = 'elevside'; // Database name

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch teacher details
$query = "SELECT name, subject, mobil, email, image FROM teachers";
$result = $mysqli->query($query);
?>
<main>
    <h1>Our Teachers</h1>
    <section class="teachers">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='teacher'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                echo "<p>Subject: " . htmlspecialchars($row['subject']) . "</p>";
                echo "<p>Mobile: " . htmlspecialchars($row['mobil']) . "</p>";
                echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                if (!empty($row['image'])) {
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Image of " . htmlspecialchars($row['name']) . "' style='width:100px;height:auto;'>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No teachers found.</p>";
        }
        ?>
    </section>
</main>
<?php
$mysqli->close();
?>
