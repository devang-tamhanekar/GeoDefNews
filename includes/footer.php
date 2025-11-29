<?php
include __DIR__ . '/visitor_tracker.php';
?>
<footer class="bg-dark text-light pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row text-center text-md-start">
      <!-- About -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">GeoDef News</h5>
        <p class="small mb-0">
          Your trusted source for global defence and geopolitics updates. 
          Stay informed with reliable news from around the world.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="<?= BASE_URL ?>pages/about.php" class="text-light text-decoration-none d-block py-1">About Us</a></li>
          <li><a href="<?= BASE_URL ?>pages/contact.php" class="text-light text-decoration-none d-block py-1">Contact</a></li>
          <li><a href="<?= BASE_URL ?>pages/news-template.php?region=world" class="text-light text-decoration-none d-block py-1">News by Region</a></li>
          <li><a href="<?= BASE_URL ?>pages/about-authenticity.php" class="text-light text-decoration-none d-block py-1">Authenticity</a></li>
        </ul>
      </div>

      <!-- Follow Us -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Follow Us</h5>
        <div class="d-flex justify-content-center justify-content-md-start">
          <a href="#" class="text-light me-3 fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-light me-3 fs-5"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-light me-3 fs-5"><i class="bi bi-linkedin"></i></a>
          <a href="#" class="text-light fs-5"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div>
    <p class="text-center text-light mt-3">
      ⏰ <span id="liveDateTime"></span>
    </p>
    <!-- Visitor Counter -->
<div class="text-center small text-secondary mt-3">
  👁️ Total Visits: <span class="text-light"><?= $totalVisits ?? 0 ?></span>  
  | 📅 Today: <span class="text-light"><?= $todayVisits ?? 0 ?></span>  
  | 🧭 Unique Visitors: <span class="text-light"><?= $uniqueVisits ?? 0 ?></span>
</div>


    <hr class="border-secondary">

    <div class="text-center small">
      © <?= date('Y'); ?> GeoDef News. All rights reserved.
    </div>
  </div>
  <script>
function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    document.getElementById("liveDateTime").textContent =
        now.toLocaleDateString("en-GB", options);
}
setInterval(updateDateTime, 1000);
updateDateTime(); // run immediately
</script>

</footer>

<!-- Dark Mode Toggle Button -->
<button id="darkModeToggle" class="btn btn-dark rounded-circle shadow" title="Toggle Dark Mode">
  🌙
</button>

<!-- Back to Top Button -->
<button id="backToTop" class="btn btn-primary rounded-circle shadow" title="Back to Top">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Scripts -->
<script>
  const backToTop = document.getElementById("backToTop");
  const darkModeToggle = document.getElementById("darkModeToggle");
  const body = document.body;

  // Show Back to Top button on scroll
  window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      backToTop.style.display = "block";
    } else {
      backToTop.style.display = "none";
    }
  };

  // Back to top smooth scroll
  backToTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Load Dark Mode preference
  if (localStorage.getItem("darkMode") === "enabled") {
    body.classList.add("dark-mode");
    darkModeToggle.innerHTML = "☀️";
    darkModeToggle.classList.replace("btn-dark", "btn-warning");
  }

  // Toggle Dark Mode
  darkModeToggle.addEventListener("click", () => {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
      localStorage.setItem("darkMode", "enabled");
      darkModeToggle.innerHTML = "☀️";
      darkModeToggle.classList.replace("btn-dark", "btn-warning"); // Yellow when in dark mode
    } else {
      localStorage.setItem("darkMode", "disabled");
      darkModeToggle.innerHTML = "🌙";
      darkModeToggle.classList.replace("btn-warning", "btn-dark"); // Black when in light mode
    }
  });
</script>

<!-- Floating Button Styles -->
<style>
  #backToTop,
  #darkModeToggle {
    position: fixed;
    bottom: 25px;
    width: 45px;
    height: 45px;
    z-index: 9999;
    font-size: 1.2rem;
    padding: 0;
  }

  #backToTop {
    right: 25px;
    display: none; /* Only visible on scroll */
  }

  #darkModeToggle {
    left: 25px;
    display: block; /* Always visible */
  }

  /* 🌙 Dark Mode Styles */
  body.dark-mode {
    background-color: #121212 !important;
    color: #e0e0e0 !important;
  }

  body.dark-mode a {
    color: #ffc107 !important; /* Gold links */
  }

  body.dark-mode .navbar,
  body.dark-mode footer {
    background-color: #1e1e1e !important;
  }

  body.dark-mode .card {
    background-color: #1c1c1c !important;
    border: 1px solid #333 !important;
    color: #f0f0f0 !important;
  }

  body.dark-mode .btn-primary {
    background-color: #bb86fc !important;
    border-color: #bb86fc !important;
  }

  body.dark-mode hr {
    border-color: #333 !important;
  }
</style>


</body>
</html>