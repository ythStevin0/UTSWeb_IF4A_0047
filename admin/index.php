<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WarHex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;600;700;900&family=Chakra+Petch:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body class="admin-body">

<nav class="admin-navbar">
    <div style="display:flex;align-items:center;gap:28px;">
        <a href="index.php" class="admin-navbar-brand">
            <img src="../assets/logoWarHex.png" alt="WarHex">
            <span class="brand-slash">//</span> WARHEX ADMIN
        </a>
        <ul class="admin-nav-links">
            <span class="admin-nav-sep"></span>
            <li><a href="products.php">PRODUCTS</a></li>
            <span class="admin-nav-sep"></span>
            <li><a href="series.php">SERIES</a></li>
            <span class="admin-nav-sep"></span>
            <li><a href="news.php">NEWS</a></li>
            <span class="admin-nav-sep"></span>
        </ul>
    </div>
    <div class="admin-nav-right">
        <span class="admin-nav-user">Logged in as <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong></span>
        <a href="logout.php" class="admin-btn-logout">LOGOUT</a>
    </div>
</nav>

<div class="admin-container">
    <div class="admin-welcome">
        <h1 class="admin-welcome-title"><span style="color:#5aa0ff">//</span> COMMAND CENTER</h1>
        <p class="admin-welcome-sub">Select a module to manage your WarHex content.</p>
    </div>

    <div class="admin-dashboard-grid">
        <a href="products.php" class="admin-dash-card">
            <i class="bi bi-box-seam admin-dash-icon"></i>
            <span class="admin-dash-label">PRODUCTS</span>
            <p class="admin-dash-desc">Manage gear & equipment</p>
        </a>
        <a href="series.php" class="admin-dash-card">
            <i class="bi bi-collection-play admin-dash-icon"></i>
            <span class="admin-dash-label">SERIES</span>
            <p class="admin-dash-desc">Manage game series catalog</p>
        </a>
        <a href="news.php" class="admin-dash-card">
            <i class="bi bi-megaphone admin-dash-icon"></i>
            <span class="admin-dash-label">NEWS</span>
            <p class="admin-dash-desc">Manage announcements & updates</p>
        </a>
    </div>
</div>

</body>
</html>
