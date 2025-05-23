<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "student_id_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch contact messages
$sql = "SELECT id, name, email, subject, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .container { margin-top: 40px; }
        .table thead { background: #007bff; color: #fff; }
        .table tbody tr:hover { background: #e9ecef; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">Contact Messages</h2>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['subject']}</td>
                        <td>".htmlspecialchars($row['message'])."</td>
                        <td>{$row['submitted_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No messages found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
$conn->close();
?>