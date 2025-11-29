<?php
require_once __DIR__ . '/../config/config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($username) && !empty($password)) {
    // Hash password with MD5 (can be upgraded to password_hash later)
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, MD5(?))");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        header("Location: user-register.php?success=Account created! You can now log in.");
    } else {
        header("Location: user-register.php?error=Username already exists.");
    }
} else {
    header("Location: user-register.php?error=Please fill in all fields");
}
