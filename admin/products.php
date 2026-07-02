<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin WarHex</title>
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
            <li><a href="products.php" class="active">PRODUCTS</a></li>
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
    <div class="admin-page-header">
        <h2 class="admin-page-title"><span class="title-slash">//</span> DAFTAR PRODUK</h2>
        <a href="create.php" class="admin-btn admin-btn-success"><i class="bi bi-plus-lg"></i> TAMBAH PRODUK</a>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-header-tag">DATA</span>
            <span class="admin-card-header-title">Products Table</span>
        </div>
        <div class="admin-card-body" style="padding:0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:5%">ID</th>
                        <th style="width:12%">GAMBAR</th>
                        <th style="width:20%">NAMA PRODUK</th>
                        <th style="width:35%">DESKRIPSI</th>
                        <th style="width:15%">CSS CLASS</th>
                        <th style="width:13%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><img src="../<?= htmlspecialchars($row['image']) ?>" alt="Img" class="table-img"></td>
                            <td class="cell-bold"><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><span class="admin-badge"><?= htmlspecialchars($row['cell_class']) ?></span></td>
                            <td>
                                <div class="actions">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm">EDIT</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">HAPUS</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr class="empty-row">
                            <td colspan="6">Belum ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
