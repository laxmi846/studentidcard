
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_id_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from URL
$student_id = $_GET['id'];

// Delete student record
$sql = "DELETE FROM students WHERE id = $student_id";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Student deleted successfully!'); window.location.href='student_details.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>