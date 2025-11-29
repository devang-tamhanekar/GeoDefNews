<?php 
require_once __DIR__ . '/config/config.php';
include(__DIR__ . '/includes/navbar.php');
require_once __DIR__ . '/includes/news_functions.php';

// Check if the news function exists before calling it
if (!function_exists('display_news')) {
    echo "<p class='text-danger text-center'>⚠ The 'display_news' function is not available. Please ensure news_functions.php is correctly configured.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoDef News - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>images/favicon.png">
    <style>
        /* ===== Search Bar ===== */
        .search-bar {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 2px solid #0d1b2a;
        }
        .search-bar input {
            border-radius: 30px;
            padding: 10px 20px;
            border: 1px solid #ccc;
            width: 70%;
        }
        .search-bar button {
            border-radius: 30px;
            padding: 10px 25px;
            background: #00e1ff;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .search-bar button:hover {
            background: #009bbf;
        }

        /* ===== Breaking News Bar ===== */
    .breaking-news {
        background: linear-gradient(90deg, #ffd60a, #ffb703);
        color: #000;
        font-weight: 600;
        font-size: 1rem;
        overflow: hidden;
        border-bottom: 2px solid #0d1b2a;
    }

    .ticker-wrap {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .ticker {
        display: flex;
        animation: ticker 35s linear infinite;
        gap: 50px;
    }

    .ticker-item {
        white-space: nowrap;
        padding: 9px 0;
        font-size: 1.1rem;
        font-weight: 500;
    }

    @keyframes ticker {
        0%   { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

        /* ===== Banner Section ===== */
        .banner-container {
            position: relative;
            overflow: hidden;
        }
        .banner-container img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            filter: brightness(65%) contrast(110%);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate(-50%, -40%); }
            to   { opacity: 1; transform: translate(-50%, -50%); }
        }
        /* === Banner Section === */
        .banner-container {
            position: relative;
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("<?= BASE_URL ?>images/banner.png") center/cover no-repeat;
            overflow: hidden;
            box-shadow: inset 0 0 60px rgba(0,0,0,0.6);
        }

 
        /* Banner Text */
        .banner-text {
            position: relative;
            z-index: 3;
            text-align: center;
            color: #fff;
        }

        /* Main Heading (3D Text) */
        .banner-title {
            font-size: 4.2rem;
            font-weight: 900;
            text-transform: uppercase;
            color: #00e1ff;
            text-shadow: 
            2px 2px 0 #0d1b2a,
            4px 4px 0 #1b263b,
            6px 6px 12px rgba(0,0,0,0.6);
            letter-spacing: 2px;
            nimation: floatTitle 4s ease-in-out infinite;
        }

        /* Subheading (Polished 3D) */
        .banner-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: #f8f9fa;
            margin-top: 12px;
            text-shadow: 
            1px 1px 0 #0d1b2a,
            2px 2px 4px rgba(0,0,0,0.7);
            animation: fadeInUp 2.5s ease;
        }

        /* Animation for floating effect */
        @keyframes floatTitle {
            0%   { transform: translateY(0); }
            50%  { transform: translateY(-8px); }
            100% { transform: translateY(0); }
        }


        @keyframes radarPulse {
            0% { transform: scale(0.5); opacity: 0.7; }
            70% { transform: scale(1.5); opacity: 0.2; }
            100% { transform: scale(2); opacity: 0; }
        }

        /* ===== Section Title ===== */
        .section-title {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            color: #0d1b2a;
            position: relative;
        }
        .section-title::after {
            content: "";
            width: 70px;
            height: 4px;
            background: #00e1ff;
            display: block;
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* ===== News Cards ===== */
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
            height: 200px;
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

        /* ===== More News Button ===== */
        .more-news-btn {
            text-align: center;
            margin-top: 2rem;
        }
        /* ===== Loading Skeleton ===== */
        .skeleton {
            background: #e0e0e0;
            border-radius: 10px;
            animation: pulse 1.5s infinite ease-in-out;
        }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }
        .skeleton-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: #f4f4f4;
            height: 350px;
        }
        .skeleton-img {
            height: 200px;
            width: 100%;
        }
        .skeleton-text {
            height: 15px;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <!-- 🔎 Search Bar -->
    <div class="search-bar text-center">
        <form method="GET" action="">
            <input type="text" name="q" placeholder="Search news across all regions..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Breaking News -->
     <div class="breaking-news">
        <div class="ticker-wrap">
            <div class="ticker">
                <?php
                $feed_url = $GLOBALS['allowed_feeds']['world'] ?? null;
                if ($feed_url) {
                    $rss = @simplexml_load_file($feed_url);
                    if ($rss && isset($rss->channel->item)) {
                        $count = 0;
                        foreach ($rss->channel->item as $item) {
                            if ($count >= 8) break; // Limit to 8 headlines
                            echo "<div class='ticker-item'>📰 " . htmlspecialchars($item->title) . "</div>";
                            $count++;
                        }
                    } else {
                        echo "<div class='ticker-item'>⚠ Unable to load live feed at the moment.</div>";
                    }
                }
                ?>
                </div>
            </div>
        </div>        

    <!-- Banner -->
     <div class="banner-container">
        <div class="radar-overlay"></div>
        <div class="banner-overlay"></div>

    <!-- 3D Banner Content -->
    <div class="banner-text">
<h1 class="banner-title">GeoDef News</h1>
        <p class="banner-subtitle">Unveiling Global Defence &amp; Geopolitics</p>
    </div>
</div>

        <!-- Search Results (if any) -->
    <?php if (!empty($_GET['q'])): ?>
    <div class="container mt-5 mb-5">
        <h2 class="section-title">Search Results for "<?= htmlspecialchars($_GET['q']) ?>"</h2>
        <div class="row">
            <?php
            $query = strtolower($_GET['q']);
            $resultsFound = false;

            foreach ($GLOBALS['allowed_feeds'] as $region => $feed_url) {
                $rss = @simplexml_load_file($feed_url);
                if ($rss && isset($rss->channel->item)) {
                    foreach ($rss->channel->item as $item) {
                        if (stripos($item->title, $query) !== false || stripos($item->description, $query) !== false) {
                            
                            // Try to extract image
                            $image = '';
                            if (isset($item->enclosure['url'])) {
                                $image = (string)$item->enclosure['url'];
                            } elseif ($item->children('media', true)->content) {
                                $image = (string)$item->children('media', true)->content->attributes()->url;
                            }

                            echo "<div class='col-md-4 mb-4'>
                                    <div class='card'>";
                            if ($image) {
                                echo "<img src='" . htmlspecialchars($image) . "' class='card-img-top' alt='news image'>";
                            } else {
                                echo "<img src='" . BASE_URL . "images/default-news.jpg' class='card-img-top' alt='default image'>";
                            }
                            echo "      <div class='card-body'>
                                            <h5 class='card-title'>" . htmlspecialchars($item->title) . "</h5>
                                            <p class='card-text'>" . htmlspecialchars(substr(strip_tags($item->description), 0, 100)) . "...</p>
                                            <a href='" . htmlspecialchars($item->link) . "' target='_blank' class='btn btn-primary'>Read More</a>
                                        </div>
                                        <div class='card-footer'>Region: " . ucfirst($region) . "</div>
                                    </div>
                                  </div>";
                            $resultsFound = true;
                        }
                    }
                }
            }

            if (!$resultsFound) {
                echo "<p class='text-danger text-center'>⚠ No results found for your search.</p>";
            }
            ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Latest News -->
    <div class="container mt-5 mb-5">
        <h2 class="section-title">Latest Defence & Geopolitics News</h2>
        <div class="row" id="news-container">
    <!-- Skeleton cards (shown while news loads) -->
    <?php for ($i = 0; $i < 6; $i++): ?>
        <div class="col-md-4 mb-4 skeleton-wrapper">
            <div class="skeleton-card">
                <div class="skeleton skeleton-img"></div>
                <div class="p-3">
                    <div class="skeleton skeleton-text" style="width:80%"></div>
                    <div class="skeleton skeleton-text" style="width:60%"></div>
                    <div class="skeleton skeleton-text" style="width:40%"></div>
                </div>
            </div>
        </div>
    <?php endfor; ?>

    <?php
    $feed_url = $GLOBALS['allowed_feeds']['world'] ?? null;
    if ($feed_url && function_exists('display_news')) {
        display_news($feed_url, 6);

            } else {
                echo "<p class='text-danger text-center'>⚠ World News feed is not configured or the news functions are not available.</p>";
            }
            ?>
        </div>
        <div class="more-news-btn">
            <a href="<?= BASE_URL ?>pages/news-template.php?region=world" class="btn btn-primary btn-lg">
                🌍 View More World News
            </a>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Hide skeletons once news cards are rendered
    const skeletons = document.querySelectorAll(".skeleton-wrapper");
    if (skeletons.length) {
        setTimeout(() => {
            skeletons.forEach(el => el.style.display = "none");
        }, 1200); // wait 1.2s before hiding (looks natural)
    }
});
</script>


    <?php require __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
