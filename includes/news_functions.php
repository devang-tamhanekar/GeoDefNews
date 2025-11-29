<?php
/**
 * Safely fetch and display news from an RSS feed (direct echo)
 * @param string $feedUrl  The RSS feed URL
 * @param int    $limit    Max number of articles to show
 */
function display_news($feedUrl, $limit = 6) {
    // Safely load feed
    $rss = @simplexml_load_file($feedUrl);

    if ($rss && isset($rss->channel->item)) {
        $count = 0;
        foreach ($rss->channel->item as $item) {
            if ($count >= $limit) break;

            // Sanitize all outputs
            $title       = htmlspecialchars($item->title);
            $link        = htmlspecialchars($item->link);
            $description = strip_tags($item->description);
            $pubDate     = date("F j, Y, g:i a", strtotime($item->pubDate));

            // Extract image safely
            $image = "";
            $namespaces = $item->getNameSpaces(true);
            if (isset($namespaces['media'])) {
                $media = $item->children($namespaces['media']);
                if (isset($media->thumbnail)) {
                    $image = htmlspecialchars((string)$media->thumbnail->attributes()->url);
                }
            } elseif (isset($item->enclosure['url'])) {
                $image = htmlspecialchars((string)$item->enclosure['url']);
            }

            // Default image fallback
            if (empty($image)) {
                $image = BASE_URL . "assets/images/default-news.jpg";
            }
?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="<?php echo $image; ?>" class="card-img-top news-card-img" alt="<?php echo $title; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <p class="card-text"><?php echo substr($description, 0, 150) . "..."; ?></p>
                <a href="<?php echo $link; ?>" target="_blank" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
                <?php echo $pubDate; ?>
            </div>
        </div>
    </div>
<?php
            $count++;
        }
    } else {
        echo "<div class='alert alert-info text-center'>⚠ Unable to fetch news right now.</div>";
    }
}

/**
 * Fetch news items from an RSS feed (returns array, used for "View More")
 * @param string $feedUrl  The RSS feed URL
 * @param int    $limit    Max number of articles to fetch
 * @return array           List of news items
 */
function get_news_items($feedUrl, $limit = 30) {
    $items = [];
    $rss = @simplexml_load_file($feedUrl);

    if ($rss && isset($rss->channel->item)) {
        $count = 0;
        foreach ($rss->channel->item as $item) {
            if ($count >= $limit) break;

            $title       = htmlspecialchars($item->title);
            $link        = htmlspecialchars($item->link);
            $description = strip_tags($item->description);
            $pubDate     = date("F j, Y, g:i a", strtotime($item->pubDate));

            // Extract image safely
            $image = "";
            $namespaces = $item->getNameSpaces(true);
            if (isset($namespaces['media'])) {
                $media = $item->children($namespaces['media']);
                if (isset($media->thumbnail)) {
                    $image = htmlspecialchars((string)$media->thumbnail->attributes()->url);
                }
            } elseif (isset($item->enclosure['url'])) {
                $image = htmlspecialchars((string)$item->enclosure['url']);
            }

            // Default image fallback
            if (empty($image)) {
                $image = BASE_URL . "assets/images/default-news.jpg";
            }

            $items[] = [
                'title' => $title,
                'link' => $link,
                'description' => substr($description, 0, 150) . "...",
                'pubDate' => $pubDate,
                'image' => $image
            ];

            $count++;
        }
    }

    return $items;
}
?>
