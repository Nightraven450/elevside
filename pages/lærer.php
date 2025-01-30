<header>
    <h1>Our Teachers</h1>
    <a href="pages/add_teacher.php" class="add-teacher-button">Add New Teacher</a> <!-- Button to add teacher -->
</header>
<main>
    <section class="teachers">
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
            die("Database connection failed: " . $mysqli->connect_error);
        }

        // Fetch teachers from the database
        $result = $mysqli->query("SELECT * FROM teachers");

        // Display each teacher
        while ($teacher = $result->fetch_assoc()) {
            echo '<div class="teacher">';
            echo '<h2>' . htmlspecialchars($teacher['name']) . '</h2>';
            echo '<p>' . htmlspecialchars($teacher['subject']) . '</p>';
            echo '<p>Mobile: ' . htmlspecialchars($teacher['mobil']) . '</p>';
            echo '<p>Email: ' . htmlspecialchars($teacher['email']) . '</p>';
            echo '</div>';
        }

        // Close the database connection
        $mysqli->close();
        ?>
    </section>
</main>
