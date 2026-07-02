<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config.php';
$result = $conn->query("SELECT * FROM series ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series - Admin WarHex</title>
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
            <li><a href="series.php" class="active">SERIES</a></li>
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
    <div class="admin-page-header">
        <h2 class="admin-page-title"><span class="title-slash">//</span> DAFTAR SERIES</h2>
        <a href="create_series.php" class="admin-btn admin-btn-success"><i class="bi bi-plus-lg"></i> TAMBAH SERIES</a>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-header-tag">DATA</span>
            <span class="admin-card-header-title">Series Table</span>
        </div>
        <div class="admin-card-body" style="padding:0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>GAMBAR</th>
                        <th>JUDUL</th>
                        <th>GENRE</th>
                        <th>TAHUN</th>
                        <th>KATEGORI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><img src="../<?= htmlspecialchars($row['image']) ?>" alt="Img" class="table-img"></td>
                            <td class="cell-bold"><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['genre']) ?></td>
                            <td><?= htmlspecialchars($row['release_year']) ?></td>
                            <td><span class="admin-badge"><?= htmlspecialchars($row['category']) ?></span></td>
                            <td>
                                <div class="actions">
                                    <a href="edit_series.php?id=<?= $row['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm">EDIT</a>
                                    <a href="delete_series.php?id=<?= $row['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Hapus series ini?');">HAPUS</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr class="empty-row">
                            <td colspan="7">Belum ada data series.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
