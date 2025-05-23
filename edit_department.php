<?php
$conn = new mysqli("localhost", "root", "", "student_id_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['department_name']);
    $stmt = $conn->prepare("UPDATE departments SET department_name=? WHERE department_id=?");
    $stmt->bind_param("si", $new_name, $id);
    if ($stmt->execute()) {
        header("Location: display_depart.php");
        exit;
    } else {
        $message = "Update failed.";
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT department_name FROM departments WHERE department_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($department_name);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width:500px;">
    <h3>Edit Department</h3>
    <?php if ($message) echo "<div class='alert alert-danger'>$message</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name</label>
            <input type="text" class="form-control" id="department_name" name="department_name" value="<?php echo htmlspecialchars($department_name); ?>" required>
        </div>
        <button type="submit" class="btn btn-success w-100 mb-2">Update</button>
        <a href="display_depart.php" class="btn btn-secondary w-100">Back</a>
    </form>
</div>
</body>
</html>