<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../includes/navbar.php';

// Simple CSRF token
if (empty($_SESSION['csrf_contact'])) {
  $_SESSION['csrf_contact'] = bin2hex(random_bytes(16));
}

$success = isset($_GET['success']) ? $_GET['success'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact - GeoDef News</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">
</head>
<body>
  <div class="container my-5" style="max-width: 720px;">
  <h2 class="mb-4 text-center fw-bold text-primary">📩 Contact Us</h2>

  <?php if ($success === '1'): ?>
    <div class="alert alert-success shadow-sm">✅ Your message was sent successfully.</div>
  <?php elseif ($success === '0'): ?>
    <div class="alert alert-danger shadow-sm">❌ We couldn’t send your message. Please try again.</div>
  <?php endif; ?>

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
      <form method="POST" action="<?= BASE_URL ?>pages/submit-contact.php" novalidate>
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_contact']) ?>">

        <!-- Name -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Name</label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-person-fill"></i></span>
            <input type="text" name="name" class="form-control" placeholder="Your full name" required maxlength="100" />
          </div>
          <small class="text-muted">Enter your full name</small>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required maxlength="255" />
          </div>
          <small class="text-muted">We’ll never share your email</small>
        </div>

        <!-- Message -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Message</label>
          <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
        </div>

        <!-- Submit -->
        <div class="d-grid">
          <button class="btn btn-primary btn-lg shadow-sm">Send Message 🚀</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
