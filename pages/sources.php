<?php
require_once __DIR__ . '/../config/config.php';
include(__DIR__ . '/../includes/navbar.php');
// Function to render feed headlines
function render_feed($feed_url) {
    $rss = @simplexml_load_file($feed_url);
    if ($rss && isset($rss->channel->item)) {
        echo "<h4 class='mt-4'>" . htmlspecialchars($rss->channel->title) . "</h4>";
        echo "<ul class='list-group mb-4'>";
        $count = 0;
        foreach ($rss->channel->item as $item) {
            if ($count >= 8) break; // limit to 8 items
            echo "<li class='list-group-item'>
                    <a href='" . htmlspecialchars($item->link) . "' target='_blank'>
                        " . htmlspecialchars($item->title) . "
                    </a>
                    <br><small class='text-muted'>" . date("M d, Y H:i", strtotime($item->pubDate)) . "</small>
                  </li>";
            $count++;
        }
        echo "</ul>";
    } else {
        echo "<p class='text-danger'>⚠ Unable to load feed.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticity - Sources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center">RSS Sources Used by GeoDef News</h2>
    <p class="text-muted text-center">Below are the official RSS feeds we use. All content is fetched directly from these sources without modification.</p>
        <!-- Tabs for sources -->
    <ul class="nav nav-tabs" id="sourceTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bbc-tab" data-bs-toggle="tab" data-bs-target="#bbc" type="button">🌍 BBC World</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="aj-tab" data-bs-toggle="tab" data-bs-target="#aj" type="button">📰 Al Jazeera</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="toi-tab" data-bs-toggle="tab" data-bs-target="#toi" type="button">🇮🇳 Times of India</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reuters-tab" data-bs-toggle="tab" data-bs-target="#reuters" type="button">🔒 Army Technology</button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="bbc" role="tabpanel">
            <?php render_feed("https://feeds.bbci.co.uk/news/world/rss.xml"); ?>
        </div>
        <div class="tab-pane fade" id="aj" role="tabpanel">
            <?php render_feed("https://www.aljazeera.com/xml/rss/all.xml"); ?>
        </div>
        <div class="tab-pane fade" id="toi" role="tabpanel">
            <?php render_feed("https://timesofindia.indiatimes.com/rssfeeds/-2128936835.cms"); ?>
        </div>
        <div class="tab-pane fade" id="reuters" role="tabpanel">
            <?php render_feed("https://www.army-technology.com/feed/"); ?>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>