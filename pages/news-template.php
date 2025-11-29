<?php 
// Config, Functions & Navbar
require_once __DIR__ . '/../config/config.php'; 
require_once __DIR__ . '/../includes/news_functions.php'; 
include(__DIR__ . '/../includes/navbar.php'); 

// Region Handling
$region = $_GET['region'] ?? 'world'; 
$region = htmlspecialchars($region); 
$feedUrl = $GLOBALS['allowed_feeds'][$region] ?? null;
$page_title = ucfirst($region) . " News"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($page_title) ?> - GeoDef News</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">
  <style>
    /* === Same card style as homepage === */
    .card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .card-img-top {
      height: 220px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    .card:hover .card-img-top {
      transform: scale(1.08);
    }
    .card-body { padding: 1rem 1.2rem; }
    .card-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #0d1b2a;
    }
    .card-text {
      color: #555;
      font-size: 0.9rem;
    }
    .btn-primary {
      background: #00e1ff;
      border: none;
      font-weight: 600;
      border-radius: 8px;
      transition: background 0.3s;
    }
    .btn-primary:hover { background: #009bbf; }
    .card-footer {
      background: linear-gradient(90deg, #0d1b2a, #1b263b);
      color: #fff;
      font-size: 0.8rem;
    }
    .section-title {
      font-weight: 700;
      font-size: 1.9rem;
      margin-bottom: 1.8rem;
      text-align: center;
      color: #0d1b2a;
      position: relative;
    }
    .section-title::after {
      content: "";
      width: 60px;
      height: 4px;
      background: #00e1ff;
      display: block;
      margin: 10px auto 0;
      border-radius: 2px;
    }
  </style>
</head>
<body>
  <main class="container my-5">
    <h2 class="section-title"><?= htmlspecialchars($page_title) ?></h2>
    <div id="newsContainer" class="row">
  <?php
  if ($feedUrl && function_exists('get_news_items')) {
      $newsItems = get_news_items($feedUrl, 30); // fetch up to 30 items
      if (!empty($newsItems)) {
          foreach ($newsItems as $index => $item) {
              ?>
              <div class="col-md-4 mb-4 news-item" style="<?= $index >= 9 ? 'display:none;' : '' ?>">
                <div class="card h-100 shadow-sm">
                  <?php if (!empty($item['image'])): ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="News Image">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                    <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" class="btn btn-primary">Read More</a>
                  </div>
                  <div class="card-footer">
                    Published: <?= htmlspecialchars($item['pubDate']) ?>
                  </div>
                </div>
              </div>
              <?php
          }
      } else {
          echo "<div class='alert alert-warning text-center'>⚠ No news found for {$page_title}.</div>";
      }
  } else {
      echo "<div class='alert alert-warning text-center'>⚠ {$page_title} feed is not configured or unavailable.</div>";
  }
  ?>
</div>

<!-- View More Button -->
<?php if (!empty($newsItems) && count($newsItems) > 9): ?>
  <div class="text-center">
    <button id="viewMoreBtn" class="btn btn-primary">View More</button>
  </div>
<?php endif; ?>

  </main>

  <?php require __DIR__ . '/../includes/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  const viewMoreBtn = document.getElementById("viewMoreBtn");
  if (viewMoreBtn) {
    let visibleCount = 9;
    viewMoreBtn.addEventListener("click", () => {
      const items = document.querySelectorAll(".news-item");
      for (let i = visibleCount; i < visibleCount + 6 && i < items.length; i++) {
        items[i].style.display = "block";
      }
      visibleCount += 6;
      if (visibleCount >= items.length) {
        viewMoreBtn.style.display = "none";
      }
    });
  }
</script>


</body>
</html>
