<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = trim($_POST['department_name']);
    $conn = new mysqli("localhost", "root", "", "student_id_management");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO departments (department_name) VALUES (?)");
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: depart.php");
    exit;
}
?>