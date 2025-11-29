<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';

// ✅ Ensure connection is valid
if (!isset($conn) || !$conn instanceof mysqli || $conn->connect_errno) {
    die("⚠ Database connection not available.");
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$today = date("Y-m-d");

// Prevent duplicate count in same session
if (!isset($_SESSION['counted_today'])) {
    $check = $conn->prepare("SELECT id FROM visitors WHERE ip_address = ? AND visit_date = ?");
    $check->bind_param("ss", $ip, $today);
    $check->execute();
    $result = $check->get_result();

    if ($result && $result->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO visitors (ip_address, visit_date) VALUES (?, ?)");
        $insert->bind_param("ss", $ip, $today);
        $insert->execute();
        $insert->close();
    }
    $check->close();

    $_SESSION['counted_today'] = true;
}

// --- Fetch statistics safely ---
$totalVisits = 0;
$todayVisits = 0;
$uniqueVisits = 0;

if ($result = $conn->query("SELECT COUNT(*) AS total FROM visitors")) {
    $row = $result->fetch_assoc();
    $totalVisits = $row['total'];
    $result->free();
}

if ($result = $conn->query("SELECT COUNT(*) AS today FROM visitors WHERE visit_date = '$today'")) {
    $row = $result->fetch_assoc();
    $todayVisits = $row['today'];
    $result->free();
}

if ($result = $conn->query("SELECT COUNT(DISTINCT ip_address) AS unique_count FROM visitors")) {
    $row = $result->fetch_assoc();
    $uniqueVisits = $row['unique_count'];
    $result->free();
}
?>
