<?php
/** @var string $assetBase */
/** @var string $currentPage home|about|highlights */
$currentPage = $currentPage ?? 'home';
?>
<header class="pn-header">
  <div class="pn-header-inner">
    <a class="pn-logo" href="/">prefa<span class="pn-logo-accent">.news</span>
      <span class="pn-logo-sub">Santa Catarina</span>
    </a>
    <nav class="pn-nav">
      <a class="<?= $currentPage === 'home' ? 'active' : '' ?>" href="/">Home</a>
      <a class="<?= $currentPage === 'highlights' ? 'active' : '' ?>" href="/highlights">Highlights</a>
      <a class="<?= $currentPage === 'about' ? 'active' : '' ?>" href="/about">About</a>
    </nav>
    <input class="pn-search" type="text" placeholder="Search news...">
  </div>
</header>
