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

// Query to fetch student names
$sql = "SELECT name, id FROM users ORDER BY name ASC"; // Adjust table name as necessary
$result = $conn->query($sql);
?>

    <style>
        .scrollable-panel {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
        }
        .student-item {
            padding: 5px;
            cursor: pointer;
        }
        .student-item:hover {
            background-color: #f0f0f0;
        }
        .subject-input {
            margin-top: 10px;
        }
    </style>
    <div class="container mt-4">
        <h2>Assign Grades</h2>
        <input type="text" id="searchBar" placeholder="Search for students..." onkeyup="filterStudents()">
        <div class="scrollable-panel" id="studentList">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="student-item" onclick="selectStudent(\'' . htmlspecialchars($row['name']) . '\', ' . htmlspecialchars($row['id']) . ')">' . htmlspecialchars($row['name']) . '</div>';
                }
            } else {
                echo '<div>No students found</div>';
            }
            $conn->close();
            ?>
        </div>
        <div id="gradeInput" style="display:none;">
            <h2>Add Grades for <span id="selectedStudent"></span></h2>
            <div class="subject-input">
                <label>Dansk:</label>
                <input type="number" id="grade_danish" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Matematik:</label>
                <input type="number" id="grade_math" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Engelsk:</label>
                <input type="number" id="grade_english" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Fysik/kemi:</label>
                <input type="number" id="grade_science" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Historie:</label>
                <input type="number" id="grade_history" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Geografi:</label>
                <input type="number" id="grade_geography" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Idræt:</label>
                <input type="number" id="grade_pe" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Kristendom:</label>
                <input type="number" id="grade_religion" placeholder="Enter grade">
            </div>
            <div class="subject-input">
                <label>Samfundsfag:</label>
                <input type="number" id="grade_social" placeholder="Enter grade">
            </div>
            <button onclick="submitGrades()">Submit Grades</button>
            <button onclick="deselectStudent()">Cancel/Deselect</button>
        </div>
    </div>

    <script>
        function filterStudents() {
            const searchValue = document.getElementById('searchBar').value.toLowerCase();
            const studentItems = document.querySelectorAll('.student-item');

            studentItems.forEach(item => {
                if (item.textContent.toLowerCase().includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function selectStudent(name, id) {
            document.getElementById('selectedStudent').textContent = name;
            document.getElementById('gradeInput').style.display = 'block';
        }

        function deselectStudent() {
            document.getElementById('selectedStudent').textContent = '';
            document.getElementById('gradeInput').style.display = 'none';
            document.querySelectorAll('.subject-input input').forEach(input => input.value = '');
        }

        function submitGrades() {
            const studentName = document.getElementById('selectedStudent').textContent;
            const grades = {
                danish: document.getElementById('grade_danish').value,
                math: document.getElementById('grade_math').value,
                english: document.getElementById('grade_english').value,
                science: document.getElementById('grade_science').value,
                history: document.getElementById('grade_history').value,
                geography: document.getElementById('grade_geography').value,
                pe: document.getElementById('grade_pe').value,
                music: document.getElementById('grade_music').value,
                art: document.getElementById('grade_art').value,
                religion: document.getElementById('grade_religion').value,
                social: document.getElementById('grade_social').value,
                technology: document.getElementById('grade_technology').value,
                home_economics: document.getElementById('grade_home_economics').value,
            };
            alert(`Grades submitted for ${studentName}: ${JSON.stringify(grades)}`);
            deselectStudent();
        }
    </script>