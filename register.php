<?php
session_start();
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fields
    $name = trim($_POST['name']);
    $number = trim($_POST['number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    // Simple validations
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($number) || !preg_match('/^[0-9]{10}$/', $number)) $errors[] = "Valid 10-digit number is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if (empty($captcha) || strtolower($captcha) !== strtolower($_SESSION['captcha_text'])) $errors[] = "Invalid captcha.";

    if (empty($errors)) {
        $conn = new mysqli("localhost", "root", "", "student_id_management");
        if ($conn->connect_error) {
            $errors[] = "Database connection failed.";
        } else {
            // Check if email or number already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR number = ?");
            $stmt->bind_param("ss", $email, $number);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = "Email or number already registered.";
            } else {
                $hashed = md5($password); // For demo, use md5. For production, use password_hash().
                $stmt = $conn->prepare("INSERT INTO users (name, number, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $number, $email, $hashed);
                if ($stmt->execute()) {
                    $success = "Registration successful! You can now <a href='user_login.php'>login</a>.";
                } else {
                    $errors[] = "Registration failed. Try again.";
                }
            }
            $stmt->close();
            $conn->close();
        }
    }
}

// Generate captcha
$captcha_text = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);
$_SESSION['captcha_text'] = $captcha_text;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .register-container {
            max-width: 450px;
            margin: 60px auto;
            padding: 30px 25px 25px 25px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 16px rgba(0,0,0,0.08);
        }
        .captcha-img {
            font-size: 2rem;
            letter-spacing: 8px;
            font-weight: bold;
            color: #2c3e50;
            background: #e9ecef;
            padding: 8px 18px;
            border-radius: 6px;
            display: inline-block;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="mb-4 text-center">Register</h2>
        <?php
        if (!empty($errors)) {
            echo "<div class='alert alert-danger'><ul class='mb-0'>";
            foreach ($errors as $e) echo "<li>$e</li>";
            echo "</ul></div>";
        }
        if ($success) echo "<div class='alert alert-success'>$success</div>";
        ?>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required value="<?php if(isset($name)) echo htmlspecialchars($name); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <input type="text" name="number" class="form-control" maxlength="10" required value="<?php if(isset($number)) echo htmlspecialchars($number); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?php if(isset($email)) echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label class="form-label">Captcha</label><br>
                <span class="captcha-img"><?php echo $captcha_text; ?></span>
                <input type="text" name="captcha" class="form-control mt-2" required placeholder="Enter captcha above">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <div class="mt-3 text-center">
                Already have an account? <a href="user_login.php">Login</a>
            </div>
        </form>
    </div>
</body>
</html>