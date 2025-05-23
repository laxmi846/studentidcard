<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']); // Use md5 to match registration

    $conn = new mysqli("localhost", "root", "", "student_id_management");
    if ($conn->connect_error) {
        $error = "Database connection failed.";
    } else {
        $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            echo "<script>localStorage.setItem('user_name', '".addslashes($row['name'])."');window.location='index.html';</script>";
            exit;
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
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
        <h2>User Login</h2>
        <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="mt-3 text-center">
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</body>
</html>