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

// Fetch report data
$total_students = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$total_issued = $conn->query("SELECT COUNT(*) AS total FROM id_cards")->fetch_assoc()['total'];
$students_without_id = $conn->query("SELECT COUNT(*) AS total FROM students WHERE id NOT IN (SELECT student_id FROM id_cards)")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-body {
            font-size: 1.1rem;
        }
        .card i {
            font-size: 3rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reports</h1>
        <div class="row">
            <!-- Total Students -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-header text-center">
                        <i class="bi bi-people"></i>
                        Total Students
                    </div>
                    <div class="card-body text-center">
                        <h2><?php echo $total_students; ?></h2>
                        <p>Registered in the system</p>
                    </div>
                </div>
            </div>

            <!-- Total ID Cards Issued -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-header text-center">
                        <i class="bi bi-card-heading"></i>
                        ID Cards Issued
                    </div>
                    <div class="card-body text-center">
                        <h2><?php echo $total_issued; ?></h2>
                        <p>Issued to students</p>
                    </div>
                </div>
            </div>

            <!-- Students Without ID Cards -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-warning">
                    <div class="card-header text-center">
                        <i class="bi bi-exclamation-circle"></i>
                        Students Without ID Cards
                    </div>
                    <div class="card-body text-center">
                        <h2><?php echo $students_without_id; ?></h2>
                        <p>Pending ID issuance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>