<?php
// includes/search_index.php
// Returns a JSON index of recent articles from all allowed feeds.
// Created for homepage client-side search.

// load config and allowed feeds
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json; charset=utf-8');

$feeds = $GLOBALS['allowed_feeds'] ?? [];
$max_per_feed = 8;
$articles = [];

foreach ($feeds as $region => $feedUrl) {
    if (empty($feedUrl)) continue;

    // Load RSS safely
    $rss = @simplexml_load_file($feedUrl);
    if (!$rss) continue;

    // Determine items node (supports RSS and some Atom layouts)
    $items = [];
    if (isset($rss->channel->item)) {
        $items = $rss->channel->item;
    } elseif (isset($rss->item)) {
        $items = $rss->item;
    } else {
        continue;
    }

    $count = 0;
    foreach ($items as $item) {
        if ($count >= $max_per_feed) break;

        $title = (string)($item->title ?? '');
        $link = (string)($item->link ?? '');
        $description = strip_tags((string)($item->description ?? ''));
        // prefer pubDate, fallback to updated/lastBuildDate if present
        $pubRaw = (string)($item->pubDate ?? $item->updated ?? '');
        $timestamp = $pubRaw ? strtotime($pubRaw) : 0;
        $pubDate = $timestamp ? date("F j, Y, g:i a", $timestamp) : '';

        // Extract image if present
        $image = '';
        $namespaces = $item->getNameSpaces(true);
        if (!empty($namespaces['media'])) {
            $media = $item->children($namespaces['media']);
            if (isset($media->thumbnail)) {
                $image = (string)$media->thumbnail->attributes()->url;
            }
        }
        if (empty($image) && isset($item->enclosure['url'])) {
            $image = (string)$item->enclosure['url'];
        }
        if (empty($image)) {
            // fallback default image
            $image = rtrim(BASE_URL, '/') . '/assets/images/default-news.jpg';
        }

        $articles[] = [
            'region' => $region,
            'title' => $title,
            'link' => $link,
            'description' => $description,
            'pubDate' => $pubDate,
            'timestamp' => $timestamp,
            'image' => $image
        ];

        $count++;
    }
}

// Sort by timestamp descending so latest articles appear first
usort($articles, function($a, $b) {
    return ($b['timestamp'] ?? 0) <=> ($a['timestamp'] ?? 0);
});

// Output JSON
echo json_encode(['status' => 'ok', 'articles' => $articles], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
exit;
