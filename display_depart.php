<?php
$conn = new mysqli("localhost", "root", "", "student_id_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT department_id, department_name FROM departments");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Departments List</h3>
        <div>
            <a href="depart.php" class="btn btn-primary me-2">Add Department</a>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['department_id']}</td>
                        <td>{$row['department_name']}</td>
                        <td>
                            <a href='edit_department.php?id={$row['department_id']}' class='btn btn-sm btn-warning me-2'>Edit</a>
                            <a href='delete_department.php?id={$row['department_id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this department?');\">Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No departments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php $conn->close(); ?>