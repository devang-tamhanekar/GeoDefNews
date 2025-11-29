<?php
require_once __DIR__ . '/../config/config.php';
include(__DIR__ . '/../includes/navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify News Authenticity - GeoDef News</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-3">News Authenticity Verification</h2>
    <p class="text-muted">Below are the latest headlines fetched live from each official source. Links open on the publisher’s website.</p>

    <?php foreach ($GLOBALS['allowed_feeds'] as $region => $url): ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong><?= ucfirst($region) ?> — <?= parse_url($url, PHP_URL_HOST) ?></strong>
          <a class="btn btn-sm btn-outline-secondary" target="_blank" href="<?= htmlspecialchars($url) ?>">Open RSS</a>
        </div>
        <ul class="list-group list-group-flush">
          <?php
            $rss = @simplexml_load_file($url);
            if ($rss && isset($rss->channel->item)) {
              $count = 0;
              foreach ($rss->channel->item as $item) {
                if ($count >= 5) break;
                $title = htmlspecialchars((string)$item->title);
                $link  = htmlspecialchars((string)$item->link);
                echo "<li class='list-group-item'><a href='{$link}' target='_blank'>{$title}</a></li>";
                $count++;
              }
            } else {
              echo "<li class='list-group-item text-danger'>⚠ Unable to load feed from ".htmlspecialchars($url)."</li>";
            }
          ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>

  <?php include(__DIR__ . '/../includes/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
