<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to dashboard/messages
if (isset($_SESSION['admin'])) {
    header("Location: view-messages.php");
    exit;
}

// Handle form submit
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // Temporary hardcoded credentials (change later if needed)
    $adminUser = "admin";
    $adminPass = "12345";

    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION["admin"] = $username;
        header("Location: view-messages.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
    }
}
?>

<?php require __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<!-- Admin Login Page -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background: linear-gradient(135deg, #0d1b2a, #1b263b);">
  <div class="card shadow-lg p-4 w-100" style="max-width: 420px; border-radius: 15px; background-color: #f8f9fa;">
    
    <!-- Logo / Heading -->
    <div class="text-center mb-4">
      <div style="font-size: 2.5rem;">🔐</div>
      <h3 class="mt-2">Admin Login</h3>
      <p class="text-muted">Secure access to GeoDef News dashboard</p>
    </div>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label fw-bold">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin username" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label fw-bold">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
      </div>

      <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 8px;">Login</button>
    </form>

    <!-- Footer -->
    <div class="text-center mt-4">
      <small class="text-muted">© <?= date('Y') ?> GeoDef News | Admin Panel</small>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
