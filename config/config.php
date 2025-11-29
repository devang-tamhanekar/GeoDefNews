<?php
// Detect protocol (http/https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// ✅ Fix: Always point to your project root folder
$projectFolder = '/geodef-news/';

// Final base URL (always ends with /)
define('BASE_URL', $protocol . "://" . $host . $projectFolder);

// --- Database Configuration ---
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'geodef_news');
define('DB_PORT', 3306);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');

// --- News Feeds Configuration ---
$GLOBALS['allowed_feeds'] = [
    "world"   => "https://feeds.bbci.co.uk/news/world/rss.xml",
    "asia"    => "https://feeds.bbci.co.uk/news/world/asia/rss.xml",
    "america" => "https://feeds.bbci.co.uk/news/world/us_and_canada/rss.xml",
    "europe"  => "https://feeds.bbci.co.uk/news/world/europe/rss.xml",

    // Authenticity section feeds (examples, you can update later)
    "sources"        => "https://www.defense.gov/DesktopModules/ArticleCS/RSS.ashx?ContentType=1&Site=945&max=20", // US DoD official news
    "verify"         => "https://www.factcheck.org/feed/", // Replaces AFP (broken)

];

?>
