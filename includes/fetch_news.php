<?php
/**
 * News Functions
 * --------------
 * This file contains a collection of functions for fetching and displaying news
 * from RSS feeds.
 */

// Include the config file to use the BASE_URL constant
require_once __DIR__ . '/../config/config.php';

/**
 * Fetches and displays news articles from an RSS feed.
 *
 * @param string $rssUrl The URL of the RSS feed.
 * @param int $maxNews The maximum number of articles to display.
 * @return void
 */
function display_news(string $rssUrl, int $maxNews = 12): void
{
    // Do not suppress errors; let them be handled by the server configuration
    libxml_use_internal_errors(true);
    $rss = simplexml_load_file($rssUrl);

    if (!$rss) {
        $errors = libxml_get_errors();
        $error_message = '';
        foreach ($errors as $error) {
            $error_message .= "Line {$error->line}, Column {$error->column}: " . trim($error->message) . "\n";
        }
        libxml_clear_errors();

        // Check if the file is accessible before displaying a vague error.
        if (!file_get_contents($rssUrl)) {
             echo "<p class='text-warning text-center'>⚠ The RSS feed at URL: {$rssUrl} could not be reached.</p>";
        } else {
             echo "<p class='text-warning text-center'>⚠ Unable to fetch news. Please check the feed URL for validity.</p>";
        }
        return;
    }

    $items = $rss->channel->item ?? [];
    if (count($items) == 0) {
        echo "<p class='text-warning text-center'>⚠ No news available at this time.</p>";
        return;
    }

    $count = 0;
    foreach ($items as $item) {
        if ($count >= $maxNews) {
            break;
        }

        // Sanitize all output to prevent Cross-Site Scripting (XSS) attacks
        $title = htmlspecialchars((string) $item->title);
        $link = htmlspecialchars((string) $item->link);
        $pubDate = date("d M Y, H:i", strtotime((string) $item->pubDate));

        // Try to get description/summary and sanitize it
        $description = strip_tags((string) $item->description);
        $description = strlen($description) > 200 ? substr($description, 0, 200) . "..." : $description;
        $description = htmlspecialchars($description);

        // --- IMAGE HANDLING ---
        // Use a more robust default image path using the BASE_URL constant
        $default_image = BASE_URL . "images/default-news.jpg";
        $image = $default_image;
        
        $namespaces = $item->getNamespaces(true);

        // Check for media:content (common in BBC)
        if (isset($namespaces['media'])) {
            $media = $item->children($namespaces['media']);
            if (isset($media->content) && $media->content->attributes()['url']) {
                $image = htmlspecialchars((string) $media->content->attributes()['url']);
            }
        }

        // Check for enclosure if no media:content
        if ($image === $default_image && isset($item->enclosure['url'])) {
            $image = htmlspecialchars((string) $item->enclosure['url']);
        }
        
        // Output a single news card
        echo "
        <div class='col-md-6 col-lg-4 mb-4'>
            <div class='card shadow-sm'>
                <img src='{$image}' class='card-img-top' alt='News Image'>
                <div class='card-body'>
                    <h5 class='card-title'><a href='{$link}' target='_blank' class='text-decoration-none text-dark'>{$title}</a></h5>
                    <p class='card-text text-muted'>{$description}</p>
                </div>
                <div class='card-footer text-end'>
                    <small class='text-muted'>{$pubDate}</small>
                </div>
            </div>
        </div>
        ";
        $count++;
    }
}
