<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Only allow logged-in admins
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Check if id is passed
if (!isset($_GET['id'])) {
    header("Location: view-messages.php");
    exit;
}

$messageId = intval($_GET['id']);

// ✅ Use centralized DB connection
require_once __DIR__ . '/../config/config.php';

// Delete query
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$stmt->close();

// Close connection
$conn->close();

// Redirect back
header("Location: view-messages.php");
exit;
?>
