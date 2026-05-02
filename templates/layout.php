<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prefa News</title>
  <link rel="stylesheet" href="/assets/css/main.css">
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

<div class="pn-breaking">
  <span class="pn-breaking-label">LATEST</span>
  <span class="pn-breaking-text" id="breaking-ticker">
    <?= htmlspecialchars($heroNews['news_title']) ?>
  </span>
</div>

<main class="pn-main">

  <div class="pn-section-title">Top stories</div>
  <div class="pn-hero">

    <div class="pn-hero-main" onclick="openNews(<?= (int) $heroNews['news_id'] ?>)">
      <div style="position:relative;">
        <img src="<?= htmlspecialchars($heroNews['url_img']) ?>"
             alt="<?= htmlspecialchars($heroNews['news_title']) ?>"
             class="pn-hero-img">
        <div class="pn-hero-badge">Exclusive</div>
      </div>
      <div class="pn-hero-body">
        <div class="pn-hero-city">
          📍 <?= htmlspecialchars($heroNews['city_name']) ?>
        </div>
        <div class="pn-hero-title">
          <?= htmlspecialchars($heroNews['news_title']) ?>
        </div>
        <div class="pn-hero-meta">
          <?= htmlspecialchars($heroNews['date_publish']) ?>
        </div>
      </div>
    </div>

    <div class="pn-sidebar">
      <?php foreach ($sidebarNews as $item): ?>
        <div class="pn-sidebar-item" onclick="openNews(<?= (int) $item['news_id'] ?>)">
          <img src="<?= htmlspecialchars($item['url_img']) ?>"
               alt="" class="pn-sidebar-thumb">
          <div class="pn-sidebar-info">
            <div class="pn-sidebar-city">
              📍 <?= htmlspecialchars($item['city_name']) ?>
            </div>
            <div class="pn-sidebar-title">
              <?= htmlspecialchars($item['news_title']) ?>
            </div>
            <div class="pn-sidebar-time">
              <?= htmlspecialchars($item['date_publish']) ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

  <div class="pn-section-title">Latest news</div>
  <div class="pn-grid">
    <?php foreach ($latestNews as $item): ?>
      <div class="pn-card" onclick="openNews(<?= (int) $item['news_id'] ?>)">
        <img src="<?= htmlspecialchars($item['url_img']) ?>"
             alt="" class="pn-card-thumb">
        <div class="pn-card-body">
          <div class="pn-card-city">
            📍 <?= htmlspecialchars($item['city_name']) ?>
          </div>
          <div class="pn-card-title">
            <?= htmlspecialchars($item['news_title']) ?>
          </div>
          <div class="pn-card-time">
            <?= htmlspecialchars($item['date_publish']) ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div id="infinite-zone"></div>
  <div id="infinite-sentinel" aria-hidden="true"></div>
  <div class="pn-loader" id="loader">
    <div class="pn-spinner"></div> Loading more news...
  </div>

</main>

<script src="/assets/js/main.js"></script>
</body>
</html>