<?php
session_start(); // Optional: if you plan to manage sessions later

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "student_id_management");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash input with MD5

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $username; // <-- UNCOMMENT this line
        header("Location: dashboard.php");
        exit(); // Very important to stop script execution
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px 25px 25px 25px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 16px rgba(0,0,0,0.08);
        }
        .login-container h2 {
            margin-bottom: 25px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
