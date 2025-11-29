<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../config/config.php';

// Fail fast if DB isn’t available
if (!isset($conn) || !$conn instanceof mysqli) {
  // If your config.php doesn’t create $conn, create it here instead:
  // $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
  // if ($conn->connect_error) { /* handle */ }
  header("Location: " . BASE_URL . "pages/contact.php?success=0");
  exit;
}

function back($ok) {
  header("Location: " . BASE_URL . "pages/contact.php?success=" . ($ok ? '1' : '0'));
  exit;
}

// Basic CSRF
if (empty($_POST['csrf']) || empty($_SESSION['csrf_contact']) || !hash_equals($_SESSION['csrf_contact'], $_POST['csrf'])) {
  back(false);
}

$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  back(false);
}

try {
  // Stronger error mode (optional in dev)
  // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
  if (!$stmt) {
    back(false);
  }
  $stmt->bind_param("sss", $name, $email, $message);
  $stmt->execute();
  $stmt->close();

  back(true);
} catch (Throwable $e) {
  // Optional: error_log($e->getMessage());
  back(false);
}
