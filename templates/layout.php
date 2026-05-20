<?php
$assetBase = (($config['app']['env'] ?? '') === 'production')
  ? '/build/assets'
  : '/assets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prefa News</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($assetBase) ?>/css/main.css">
</head>
<body>

<header class="pn-header">
  <div class="pn-header-inner">
    <div class="pn-logo">prefa<span class="pn-logo-accent">.news</span>
      <span class="pn-logo-sub">Santa Catarina</span>
    </div>
    <nav class="pn-nav">
      <a class="active" href="/">Home</a>
      <a href="/highlights">Highlights</a>
      <a href="/about">About</a>
    </nav>
    <input class="pn-search" type="text" placeholder="Search news...">
  </div>
</header>

<div class="pn-breaking" onclick="openNews(<?= (int) $heroNews['news_id'] ?>)">
  <span class="pn-breaking-label">LATEST</span>
  <span class="pn-breaking-text" id="breaking-ticker">
    <?= htmlspecialchars($heroNews['city_name']) ?> - <?= htmlspecialchars($heroNews['news_title']) ?>
  </span>
</div>

<main class="pn-main">

  <div class="pn-section-title">Latest news</div>
  <div class="pn-grid pn-grid--text">
    <?php foreach ($latestNews as $item): ?>
      <article class="pn-card pn-card--text" onclick="openNews(<?= (int) $item['news_id'] ?>)">
        <div class="pn-card-body">
          <div class="pn-card-city">
            <?= htmlspecialchars($item['city_name']) ?>
          </div>
          <h3 class="pn-card-title">
            <?= htmlspecialchars($item['news_title']) ?>
          </h3>
          <time class="pn-card-time" datetime="<?= htmlspecialchars($item['date_publish']) ?>">
            <?= htmlspecialchars($item['date_publish']) ?>
          </time>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <div id="infinite-zone"></div>
  <div id="infinite-sentinel" aria-hidden="true"></div>
  <div class="pn-loader" id="loader">
    <div class="pn-spinner"></div> Loading more news...
  </div>

</main>

<script src="<?= htmlspecialchars($assetBase) ?>/js/main.js"></script>
</body>
</html>
