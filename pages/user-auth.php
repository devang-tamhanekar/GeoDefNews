<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php'; // ✅ Make sure this connects to DB

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($username) && !empty($password)) {
    // Prepare SQL safely
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = MD5(?) LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    } else {
        header("Location: user-login.php?error=Invalid credentials");
        exit;
    }
} else {
    header("Location: user-login.php?error=Please fill in all fields");
    exit;
}
