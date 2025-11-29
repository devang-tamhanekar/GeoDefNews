<?php
require_once __DIR__ . '/../config/config.php';
include(__DIR__ . '/../includes/navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>How We Ensure Authenticity - GeoDef News</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-3">How We Ensure News Authenticity</h2>
    <p>GeoDef News does not write or alter original articles. All headlines displayed on our site are fetched in real time from the official RSS feeds of reputable publishers:</p>
    <ul>
      <li>BBC News (World)</li>
      <li>Al Jazeera (Asia)</li>
      <li>Euronews (Europe)</li>
      <li>NPR (America)</li>
    </ul>
    <p>We use a whitelist in our configuration file (<code>config/config.php</code>) named <code>$GLOBALS['allowed_feeds']</code>. Only URLs in this list can be loaded by our pages, preventing untrusted sources. You can review:</p>
    <ul>
      <li><strong>Sources:</strong> All RSS links on <a href="<?= BASE_URL ?>pages/sources.php">Sources (RSS Links)</a></li>
      <li><strong>Live verification:</strong> Headlines directly loaded from each feed on <a href="<?= BASE_URL ?>pages/verify.php">Live Feed Verification</a></li>
    </ul>
    <p>When you click any headline on our site, you’re taken to the publisher’s official website, so you can confirm the content and context at its source.</p>
  </div>

  <?php include(__DIR__ . '/../includes/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
