<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/news_functions.php';

$region = $_GET['region'] ?? 'world';
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$feed_url = $GLOBALS['allowed_feeds'][$region] ?? null;

if ($feed_url && function_exists('display_news')) {
    // Load 6 more news starting from offset
    display_news($feed_url, 6, $offset);
} else {
    echo "";
}
?>
