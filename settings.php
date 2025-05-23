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

// Fetch settings
$sql = "SELECT * FROM settings";
$result = $conn->query($sql);

// Update settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $conn->query("UPDATE settings SET setting_value = '$value' WHERE setting_key = '$key'");
    }
    echo "<script>alert('Settings Updated Successfully!'); window.location.href='settings.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Settings</h1>
        <form method="POST">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='mb-3'>
                            <label for='{$row['setting_key']}' class='form-label'>{$row['setting_key']}</label>
                            <input type='text' name='{$row['setting_key']}' id='{$row['setting_key']}' class='form-control' value='{$row['setting_value']}' required>
                          </div>";
                }
            } else {
                echo "<p>No settings found.</p>";
            }
            ?>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>