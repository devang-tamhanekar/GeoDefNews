<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Only allow logged-in admins
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// ✅ Use global config for DB connection
require_once __DIR__ . '/../config/config.php';

// Fetch messages
$sql = "SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);

require __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="container my-5">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📩 Contact Form Messages</h2>
    <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="card shadow-lg border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col" style="width: 35%;">Message</th>
                <th scope="col">Submitted At</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                  <td class="fw-bold"><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['name']); ?></td>
                  <td>
                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none">
                      <?php echo htmlspecialchars($row['email']); ?>
                    </a>
                  </td>
                  <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                  <td><span class="badge bg-secondary"><?php echo $row['created_at']; ?></span></td>
                  <td class="text-center">
                    <a href="delete-message.php?id=<?php echo $row['id']; ?>" 
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Are you sure you want to delete this message?');">
                       <i class="bi bi-trash"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info shadow-sm">No messages found.</div>
  <?php endif; ?>
</div>

<?php
require __DIR__ . '/../includes/footer.php';
?>
