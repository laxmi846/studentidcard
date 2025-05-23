<?php
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        $conn = new mysqli("localhost", "root", "", "student_id_management");
        if ($conn->connect_error) {
            $error = "Database connection failed.";
        } else {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            if ($stmt->execute()) {
                $success = "Thank you for contacting us! We will get back to you soon.";
            } else {
                $error = "Failed to send your message. Please try again.";
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>