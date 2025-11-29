<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GeoDef News</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .news-card-img { object-fit: cover; width: 100%; height: 100%; min-height: 180px; }
    .card-img-top { object-fit: cover; height: 180px; }
    .navbar .dropdown-menu { z-index: 2000; }
  </style>
</head>
<body>

<!-- ✅ Bootstrap JS Bundle (needed for navbar toggle & dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
