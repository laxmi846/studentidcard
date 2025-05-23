<?php
$conn = new mysqli("localhost", "root", "", "student_id_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM departments WHERE department_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
header("Location: display_depart.php");
exit;
?>