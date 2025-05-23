<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}


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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        .card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Dashboard</h4>
        <a href="dashboard.php"><i class="bi bi-house-door"></i> Home</a>
                <a href="display_contact.php"><i class="bi bi-envelope"></i> Contacts</a>


        <a href="student_details.php"><i class="bi bi-people"></i> Student Details</a>
        <a href="display_depart.php"><i class="bi bi-person-plus"></i> department</a>
        <a href="id_card_issuance.php"><i class="bi bi-card-heading"></i> ID Card Issuance</a>
        <a href="reports.php"><i class="bi bi-bar-chart"></i> Reports</a>
        <a href="settings.php"><i class="bi bi-gear"></i> Settings</a>
        <a href="admin_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <h2>Welcome to the Student ID Card Management Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <i class="bi bi-person-fill"></i>
                            <h5 class="card-title">Student Details</h5>
                            <p class="card-text">Manage student information and details.</p>
                            <a href="student_details.php" class="btn btn-light">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <i class="bi bi-card-heading"></i>
                            <h5 class="card-title">ID Card Issuance</h5>
                            <p class="card-text">Process and manage ID card issuance.</p>
                            <a href="id_card_issuance.php" class="btn btn-light">Manage ID Cards</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <i class="bi bi-bar-chart"></i>
                            <h5 class="card-title">Reports</h5>
                            <p class="card-text">View and generate reports.</p>
                            <a href="reports.php" class="btn btn-light">View Reports</a>
                        </div>
                    </div>
                </div>
                <!-- Contact Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <i class="bi bi-envelope"></i>
                            <h5 class="card-title">Contacts</h5>
                            <p class="card-text">View and manage contact messages.</p>
                            <a href="display_contact.php" class="btn btn-light">View Contacts</a>
                        </div>
                    </div>
                </div>
                <!-- Department Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-secondary mb-3">
                        <div class="card-body">
                            <i class="bi bi-building"></i>
                            <h5 class="card-title"
                            >Departments</h5>
                            <p class="card-text">View and manage departments.</p>
                            <a href="display_depart.php" class="btn btn-light">View Departments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>