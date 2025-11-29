<?php
// Start session if needed
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "geodef_news";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect back to contact page with success
header("Location: contact.php?success=1");
exit;
?>
