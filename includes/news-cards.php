<?php

function fetchNews($rss_url, $limit = 6) {

    $context = stream_context_create([
        "http" => [

            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
            ]
        ]);
        $content = @file_get_contents($rss_url, false, $context);
        if (!$content) {
            echo "<p class='text-danger'>⚠️ Unable to load feed: $rss_url</p>";
            return;
        }
        $rss = @simplexml_load_string($content);
        if (!$rss) {
            echo "<p class='text-danger'>⚠️ Invalid RSS format from: $rss_url</p>";
            return;
        }
        $count = 0;
        echo "<div class='row'>";
        foreach ($rss->channel->item as $item) {
            if ($count >= $limit) break;
            $title = (string) $item->title;
            $link  = (string) $item->link;
            $desc  = strip_tags((string) $item->description);
            $pubDate = date("M d, Y", strtotime((string) $item->pubDate));



        // Extract image

        $image = "https://via.placeholder.com/350x200?text=Defence+News";
        if (isset($item->enclosure['url'])) {
            $image = (string) $item->enclosure['url'];
        } elseif (isset($item->children("media", true)->content)) {
            $image = (string) $item->children("media", true)->content->attributes()->url;

        } elseif (preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', (string)$item->description, $m)) {
            $image = $m['src'];
        }
        echo "
        <div class='col-md-4 mb-4'>
        <div class='card shadow-sm h-100'>
        <img src='$image' class='card-img-top' alt='news image' style='height:200px;object-fit:cover;'>
        <div class='card-body'>
        <h6 class='card-title fw-bold'>$title</h6>
        <p class='card-text small text-muted'>$pubDate</p>
        <p class='card-text'>$desc</p>
        <a href='$link' target='_blank' class='btn btn-primary btn-sm'>Read More</a>
        </div>
        </div>
        </div>";
        $count++;
    }
    echo "</div>";

}

?>