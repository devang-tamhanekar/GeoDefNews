<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ✅ Only remove admin session, not the whole session
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
}

// Redirect back to admin login page
header("Location: login.php");
exit;
