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

// Query to fetch student names and ages
$sql = "SELECT name, age, username, email, id FROM users ORDER BY username ASC"; // Adjust table name as necessary
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2>Student List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>ID</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . htmlspecialchars($row['name']) . '</td>
                            <td>' . htmlspecialchars($row['username']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['id']) . '</td>
                            <td>' . htmlspecialchars($row['age']) . '</td>
                            <td>
                                <form action="pages/delete_student.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this student?\');">Delete</button>
                                </form>
                            </td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="5">No students found</td></tr>';
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
