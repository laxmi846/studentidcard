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

// Pagination setup
$limit = 10; // Students per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Fetch total students count
$count_sql = "SELECT COUNT(*) as total FROM students";
$count_result = $conn->query($count_sql);
$total_students = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_students / $limit);

// Fetch students for current page
$sql = "SELECT * FROM students LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Student Details</h1>
        <div class="mb-3 d-flex justify-content-between">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            <a href="add_student.php" class="btn btn-primary">Add New Student</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>ID Card Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['class']}</td>
                                <td>{$row['id_card_number']}</td>
                                <td>
                                    <a href='edit_student.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_student.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page-1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>

<?php
$conn->close();
?>