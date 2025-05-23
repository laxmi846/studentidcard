
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

// Fetch students without issued ID cards
$sql = "SELECT * FROM students WHERE id NOT IN (SELECT student_id FROM id_cards)";
$result = $conn->query($sql);

// Issue ID card
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $sql = "INSERT INTO id_cards (student_id) VALUES ('$student_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ID Card Issued Successfully!'); window.location.href='id_card_issuance.php';</script>";
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
    <title>ID Card Issuance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">ID Card Issuance</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="student_id" class="form-label">Select Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    <option value="">-- Select Student --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['name']} ({$row['class']})</option>";
                        }
                    } else {
                        echo "<option value=''>No students available</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Issue ID Card</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>