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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $id_card_number = $_POST['id_card_number'];

    // Insert student into the database
    $sql = "INSERT INTO students (name, class, id_card_number) VALUES ('$name', '$class', '$id_card_number')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student added successfully!'); window.location.href='student_details.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add New Student</h1>
        <a href="student_details.php" class="btn btn-secondary mb-3">Go Back</a>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Student Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" name="class" id="class" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="id_card_number" class="form-label">ID Card Number</label>
                <input type="text" name="id_card_number" id="id_card_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="student_details.php" class="btn btn-secondary">Back to Student Details</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>