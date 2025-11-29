<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
} 

require_once __DIR__ . '/../config/config.php'; 

$regions = [
    'world'   => '🌍 World',
    'asia'    => '🌏 Asia',
    'europe'  => '🌍 Europe',
    'america' => '🌎 America'
];

// Get current file name
$current_page   = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$current_region = $_GET['region'] ?? null;
?>
<!-- ✅ Favicon & Meta setup -->
<head>
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>images/favicon.png">
  <meta name="theme-color" content="#0d1b2a"> <!-- Mobile tab color -->
</head>

<style>
/* ===== Navbar Styling ===== */
.navbar-custom {
  background: linear-gradient(135deg, #0d1b2a, #1b263b, #415a77);
  box-shadow: 0 4px 10px rgba(0,0,0,0.4);
}

.navbar-brand {
  font-size: 1.4rem;
  letter-spacing: 1px;
  color: #f8f9fa !important;
  transition: color 0.3s ease;
  display: flex;
  align-items: center;
  font-weight: 700;
}
.navbar-brand:hover {
  color: #00c6ff !important;
}

/* ===== Rotating Globe Logo ===== */
.logo-globe {
  width: 34px;
  height: 34px;
  margin-right: 10px;
  animation: spin 6s linear infinite;
}
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.nav-link {
  position: relative;
  font-weight: 500;
  color: #e0e0e0 !important;
  transition: color 0.3s ease;
}
.nav-link:hover,
.nav-link.active {
  color: #00c6ff !important;
}
.nav-link::after {
  content: "";
  position: absolute;
  width: 0%;
  height: 2px;
  left: 0;
  bottom: 0;
  background: #00c6ff;
  transition: width 0.3s ease;
}
.nav-link:hover::after,
.nav-link.active::after {
  width: 100%;
}

.dropdown-menu {
  background: #1b263b;
  border-radius: 10px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}
.dropdown-item {
  color: #e0e0e0 !important;
  transition: background 0.3s, color 0.3s;
}
.dropdown-item:hover,
.dropdown-item.active {
  background: #00c6ff;
  color: #fff !important;
  border-radius: 6px;
}
/* ===== Dark Mode Styling ===== */
body.dark-mode {
  background-color: #0d1b2a;
  color: #e0e0e0;
}

.dark-mode .navbar-custom {
  background: linear-gradient(135deg, #1b263b, #0d1b2a, #000814);
}

.dark-mode .card {
  background-color: #1b263b;
  color: #e0e0e0;
  border: 1px solid #00c6ff;
}

.dark-mode .card-footer {
  background: #000814;
}

.dark-mode .section-title {
  color: #00c6ff;
}

.dark-mode .btn-primary {
  background: #00c6ff;
  color: #000;
}
/* ===== Dark Mode Banner & Ticker ===== */
.dark-mode .banner-container img {
  filter: brightness(50%) contrast(110%);
}

.dark-mode .banner-overlay {
  background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.95));
}

.dark-mode .banner-text h1 {
  color: #00c6ff;
  text-shadow: 0 0 15px rgba(0,198,255,0.8);
}

.dark-mode .banner-text p {
  color: #cfd9df;
}

.dark-mode .breaking-news {
  background: #1b263b;
  color: #00c6ff;
  border-top: 2px solid #00c6ff;
  border-bottom: 2px solid #00c6ff;
}

</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <!-- Brand with Rotating Globe Logo -->
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>index.php">
      <img src="<?= BASE_URL ?>images/favicon.png" alt="GeoDef Logo" class="logo-globe">
      GeoDef News
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#geoNavbar" aria-controls="geoNavbar"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="geoNavbar">
      <ul class="navbar-nav ms-auto">        

        <!-- Authenticity dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle<?= in_array($current_page, ['sources.php','verify.php','about-authenticity.php']) ? ' active' : '' ?>"
             href="#" 
             id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Authenticity
          </a>
          <ul class="dropdown-menu" aria-labelledby="authDropdown">
            <li><a class="dropdown-item<?= $current_page=='sources.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/sources.php">Sources (RSS Links)</a></li>
            <li><a class="dropdown-item<?= $current_page=='verify.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/verify.php">Live Feed Verification</a></li>
            <li><a class="dropdown-item<?= $current_page=='about-authenticity.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/about-authenticity.php">How We Verify</a></li>
          </ul>
        </li>

        <!-- Home -->
        <li class="nav-item">
          <a class="nav-link<?= $current_page=='index.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>index.php">Home</a>
        </li>
        
        <!-- News by Region Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle<?= ($current_page=='news-template.php') ? ' active' : '' ?>" 
             href="#" id="newsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            News by Region
          </a>
          <ul class="dropdown-menu" aria-labelledby="newsDropdown">
            <?php foreach ($regions as $key => $display_name): ?>
              <li>
                <a class="dropdown-item<?= ($current_region === $key) ? ' active' : '' ?>" 
                   href="<?= BASE_URL ?>pages/news-template.php?region=<?= $key ?>">
                  <?= $display_name ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>

        <!-- About -->
        <li class="nav-item">
          <a class="nav-link<?= $current_page=='about.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/about.php">About</a>
        </li>

        <!-- Contact -->
        <li class="nav-item">
          <a class="nav-link<?= $current_page=='contact.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/contact.php">Contact</a>
        </li>
                <!-- User Section -->
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="#">
              👤 <?= htmlspecialchars($_SESSION['user']); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>pages/user-logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link<?= $current_page=='user-login.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/user-login.php">User Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= $current_page=='user-register.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/user-register.php">Register</a>
          </li>
        <?php endif; ?>


        <!-- Admin Section -->
        <?php if (!empty($_SESSION['admin'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>pages/view-messages.php">View Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-warning" href="<?= BASE_URL ?>pages/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link<?= $current_page=='login.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>pages/login.php">Admin Login</a>
          </li>
        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</nav>
<!-- ✅ Ensure Bootstrap JS is loaded -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
