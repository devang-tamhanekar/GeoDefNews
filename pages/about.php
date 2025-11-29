<?php require __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container my-5">
  <!-- Hero Section -->
  <div class="text-center mb-5">
    <h1 class="fw-bold">About <span class="text-primary">GeoDef News</span></h1>
    <p class="text-muted">Your trusted source for global defence & geopolitics updates</p>
  </div>

  <!-- Intro -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <img src="<?= BASE_URL ?>images/about-banner.jpg" alt="About GeoDef News" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h3 class="fw-semibold mb-3">Who We Are</h3>
      <p>
        Welcome to <strong>GeoDef News</strong> — a dedicated platform bringing you the latest updates on 
        <em>defence strategies, international relations, and global geopolitics</em>.  
        This project, built with <code>PHP</code>, <code>Bootstrap</code>, and modern web technologies, 
        is designed to deliver information in a clean, structured, and responsive way.
      </p>
    </div>
  </div>

  <!-- Mission & Vision -->
  <div class="row text-center mb-5">
    <div class="col-md-6">
      <div class="p-4 border rounded shadow-sm h-100">
        <i class="bi bi-bullseye text-primary fs-1 mb-3"></i>
        <h4 class="fw-bold">Our Mission</h4>
        <p>
          To simplify complex defence and geopolitical developments, making them accessible and easy 
          to understand for students, researchers, and curious readers worldwide.
        </p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-4 border rounded shadow-sm h-100">
        <i class="bi bi-globe-americas text-success fs-1 mb-3"></i>
        <h4 class="fw-bold">Our Vision</h4>
        <p>
          To become a reliable source of global insights where readers can keep track of 
          rapidly changing international dynamics — all in one place.
        </p>
      </div>
    </div>
  </div>

  <!-- Coverage -->
  <div class="mb-5">
    <h3 class="fw-semibold text-center mb-4">🌍 What We Cover</h3>
    <div class="row text-center">
      <div class="col-md-3 mb-4">
        <i class="bi bi-flag text-danger fs-2"></i>
        <p class="fw-bold mb-0">Regional Conflicts</p>
      </div>
      <div class="col-md-3 mb-4">
        <i class="bi bi-shield-lock text-primary fs-2"></i>
        <p class="fw-bold mb-0">Defence Updates</p>
      </div>
      <div class="col-md-3 mb-4">
        <i class="bi bi-bank text-warning fs-2"></i>
        <p class="fw-bold mb-0">Global Policies</p>
      </div>
      <div class="col-md-3 mb-4">
        <i class="bi bi-broadcast text-success fs-2"></i>
        <p class="fw-bold mb-0">Live Developments</p>
      </div>
    </div>
  </div>

  <!-- Closing Note -->
  <div class="text-center">
    <h4 class="fw-bold">Why Trust GeoDef News?</h4>
    <p class="text-muted">
      Because we focus on <strong>accuracy, simplicity, and accessibility</strong>.  
      While this project began as a college initiative, it strives to grow into a platform 
      where anyone can stay informed about defence & geopolitical affairs.
    </p>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
