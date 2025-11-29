<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
require __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background: linear-gradient(135deg, #1e3c72, #2a5298);">
  <div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px;">
    <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #00c6ff, #0072ff); border-top-left-radius: 15px; border-top-right-radius: 15px;">
      <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> User Registration</h4>
      <small>Create your GeoDef News account</small>
    </div>
    <div class="card-body bg-light p-4" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
      
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <form method="POST" action="user-register-handler.php">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="username" class="form-control" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <button type="submit" class="btn btn-success w-100">
          <i class="bi bi-person-check"></i> Register
        </button>
      </form>
    </div>
    <div class="card-footer text-center bg-white" style="border-top: 1px solid #ddd; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
      Already have an account? <a href="user-login.php" class="text-primary">Login here</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
