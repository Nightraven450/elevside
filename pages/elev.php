<?php
class Student
{
    private $name;
    private $age;
    private $grades;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
        $this->grades = array();
    }

    public function add_grade($subject, $grade)
    {
        $this->grades[$subject] = $grade;
    }

    public function display_info()
    {
        echo "Name: " . $this->name . "<br>";
        echo "Age: " . $this->age . "<br>";
        foreach ($this->grades as $subject => $grade) {
            echo "Karakter i $subject: $grade<br>";
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dansk = $_POST['dansk'];
    $engelsk = $_POST['engelsk'];
    $matematik = $_POST['matematik'];
    $idræt = $_POST['idræt'];
    $historie = $_POST['historie'];
    $religion = $_POST['religion'];
    $fyskem = $_POST['fyskem'];
    $samfundsfag = $_POST['samfundsfag'];
    $tyskFransk = $_POST['TyskFransk'];

    $student = new Student($name, $age);
    $student->add_grade('dansk', $dansk);
    $student->add_grade('engelsk', $engelsk);
    $student->add_grade('matematik', $matematik);
    $student->add_grade('idræt', $idræt);
    $student->add_grade('historie', $historie);
    $student->add_grade('religion', $religion);
    $student->add_grade('fyskem', $fyskem);
    $student->add_grade('samfundsfag', $samfundsfag);
    $student->add_grade('TyskFransk', $tyskFransk);
    $student->display_info();
}
?>
<h1>Enter Student Grades</h1>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>
    <label for="age">Age:</label>
    <input type="text" id="age" name="age" required><br>
    <label for="dansk">dansk:</label>
    <input type="text" id="dansk" name="dansk" required><br>
    <label for="engelsk">engelsk:</label>
    <input type="text" id="engelsk" name="engelsk" required><br>
    <label for="matematik">matematik:</label>
    <input type="text" id="matematik" name="matematik" required><br>
    <label for="idræt">idræt:</label>
    <input type="text" id="idræt" name="idræt" required><br>
    <label for="historie">historie:</label>
    <input type="text" id="historie" name="historie" required><br>
    <label for="religion">religion:</label>
    <input type="text" id="religion" name="religion" required><br>
    <label for="fyskem">fyskem:</label>
    <input type="text" id="fyskem" name="fyskem" required><br>
    <label for="samfundsfag">samfundsfag:</label>
    <input type="text" id="samfundsfag" name="samfundsfag" required><br>
    <label for="tyskFransk">Tysk/Fransk:</label>
    <input type="text" id="TyskFransk" name="TyskFransk" required><br>
    <input type="submit" value="Submit">