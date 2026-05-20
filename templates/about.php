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
  <title>About — Prefa News</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($assetBase) ?>/css/main.css">
</head>
<body>

<?php require __DIR__ . '/partials/header.php'; ?>

<main class="pn-main pn-about">
  <h1 class="pn-about-title">About Prefa News</h1>
  <p class="pn-about-lead">
    Prefa News is a news portal for Santa Catarina that brings together positive
    municipal stories in one place — public initiatives, policies, and projects
    reported by city governments across the state.
  </p>

  <div class="pn-about-stat">
    <span class="pn-about-stat-number"><?= (int) $activeCityCount ?></span>
    <span class="pn-about-stat-label">
      <?= (int) $activeCityCount === 1 ? 'city' : 'cities' ?> with active content checks
    </span>
  </div>

  <section class="pn-about-section">
    <h2>How the portal works</h2>
    <ol class="pn-about-steps">
      <li>
        <strong>Monitoring cities.</strong>
        We track municipalities that are enabled in our system. Each active city
        is checked regularly for new articles from its official news sources.
      </li>
      <li>
        <strong>Collecting and ranking stories.</strong>
        New items are stored, translated when needed, and scored so the most
        relevant and positive stories appear first on the homepage.
      </li>
      <li>
        <strong>Reading the original article.</strong>
        Headlines on Prefa News are summaries. When you click a story, you are
        taken to the original publication on the city’s website for the full text.
      </li>
    </ol>
  </section>

  <section class="pn-about-section">
    <h2>What you will find here</h2>
    <p>
      The homepage lists the latest ranked news from all monitored cities. Stories
      are grouped by municipality so you can see which city each item comes from.
      Use <strong>Home</strong> in the menu to return to the feed at any time.
    </p>
  </section>

  <section class="pn-about-section">
    <h2>Coverage</h2>
    <p>
      Right now, <strong><?= (int) $activeCityCount ?></strong>
      <?= (int) $activeCityCount === 1 ? 'city is' : 'cities are' ?>
      actively monitored for new content. That number updates automatically as more
      municipalities are added to the network.
    </p>
  </section>

  <p class="pn-about-back">
    <a href="/">← Back to latest news</a>
  </p>
</main>

</body>
</html>
