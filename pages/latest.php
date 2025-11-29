<?php include("../includes/header.php"); ?>
<div class="container mt-4">
  <h2 class="mb-4">📰 Latest Defence & Geopolitics Updates</h2>
  <?php
  include("../includes/news-cards.php");

  // Mix of latest feeds
  fetchNews("https://www.armyrecognition.com/rss/rss.xml", 6);
  fetchNews("https://www.defenseone.com/rss/all/", 6);
  fetchNews("https://breakingdefense.com/feed/", 6);
  ?>
</div>
<?php include("../includes/footer.php"); ?>
