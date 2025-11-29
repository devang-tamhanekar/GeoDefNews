<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate inputs
    if ($name && $email && $message) {
        // Format entry
        $entry = "Name: $name | Email: $email | Message: $message | Date: " . date("Y-m-d H:i:s") . "\n";
        
        // Save into a file (messages.txt in root folder)
        file_put_contents("messages.txt", $entry, FILE_APPEND);

        // Redirect back with success flag
        header("Location: pages/contact.php?success=1");
        exit;
    } else {
        // Redirect back with error flag
        header("Location: pages/contact.php?error=1");
        exit;
    }
} else {
    // If file is opened directly, just send user back
    header("Location: pages/contact.php");
    exit;
}
