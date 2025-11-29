<?php
// Build rss2json endpoint
function rss_to_json_url(string $rss): string {
  return "https://api.rss2json.com/v1/api.json?rss_url=" . urlencode($rss);
}

// Try to get first <img src="..."> from HTML
function first_image_from_html(?string $html): ?string {
  if (!$html) return null;
  if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
    return $m[1];
  }
  return null;
}

// Fetch + normalize items from multiple feeds with keyword filters
function fetch_items_from_feeds(array $rssFeeds, int $limit = 12, array $mustContain = [], array $regionHints = []): array {
  $items = [];
  foreach ($rssFeeds as $rss) {
    $jsonUrl = rss_to_json_url($rss);
    $json = @file_get_contents($jsonUrl);
    if (!$json) continue;

    $data = json_decode($json, true);
    if (empty($data['items']) || !is_array($data['items'])) continue;

    foreach ($data['items'] as $it) {
      if (count($items) >= $limit) break;

      $title = $it['title'] ?? '';
      $descHtml = $it['description'] ?? ($it['content'] ?? '');
      $descPlain = trim(strip_tags($descHtml));
      $hay = strtolower($title . ' ' . $descPlain);

      // defence/geopolitics filter
      $pass = empty($mustContain);
      if (!$pass) {
        foreach ($mustContain as $kw) {
          if (str_contains($hay, strtolower($kw))) { $pass = true; break; }
        }
      }
      if (!$pass) continue;

      // Optional region hint filter for general feeds
      if (!empty($regionHints)) {
        $regionPass = false;
        foreach ($regionHints as $kw) {
          if (str_contains($hay, strtolower($kw))) { $regionPass = true; break; }
        }
        if (!$regionPass) continue;
      }

      // Image
      $image = $it['enclosure']['link'] ?? ($it['thumbnail'] ?? '');
      if (!$image) $image = first_image_from_html($descHtml);
      if (!$image) $image = 'https://via.placeholder.com/600x400?text=Defence+News';

      $items[] = [
        'title' => htmlspecialchars($title),
        'link'  => htmlspecialchars($it['link'] ?? '#'),
        'desc'  => htmlspecialchars($descPlain),
        'date'  => !empty($it['pubDate']) ? date("M d, Y", strtotime($it['pubDate'])) : '',
        'image' => $image,
      ];
    }
  }
  return $items;
}

// Render cards
function render_cards(array $items) {
  foreach ($items as $it) { ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="<?php echo $it['image']; ?>" class="card-img-top" alt="News Image">
        <div class="card-body">
          <h5 class="card-title"><?php echo $it['title']; ?></h5>
          <p class="card-text small"><?php echo $it['desc']; ?></p>
          <?php if (!empty($it['date'])): ?>
            <p class="text-muted small mb-2"><?php echo $it['date']; ?></p>
          <?php endif; ?>
          <a href="<?php echo $it['link']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">Read more</a>
        </div>
      </div>
    </div>
<?php }
}
