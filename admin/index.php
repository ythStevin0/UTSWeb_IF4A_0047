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
    <title>Admin Dashboard - WarHex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-5">
    <a class="navbar-brand fw-bold text-warning" href="#">WARHEX ADMIN</a>
    <div class="d-flex">
        <span class="navbar-text me-3 text-white">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Produk (Products)</h2>
        <a href="create.php" class="btn btn-success">Tambah Produk Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Gambar</th>
                        <th width="20%">Nama Produk</th>
                        <th width="35%">Deskripsi</th>
                        <th width="15%">CSS Class (Bento)</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <img src="../<?= htmlspecialchars($row['image']) ?>" alt="Img" style="width: 80px; height: auto; object-fit: contain;">
                            </td>
                            <td class="fw-bold"><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($row['cell_class']) ?></span></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm mb-1">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
