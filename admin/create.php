<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    $cell_class = $_POST['cell_class'] ?? 'prod-cell--b';

    if ($title && $description && $image) {
        $stmt = $conn->prepare("INSERT INTO products (title, description, image, cell_class) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $image, $cell_class);
        if ($stmt->execute()) {
            $success = "Produk berhasil ditambahkan!";
        } else {
            $error = "Gagal menambah produk: " . $conn->error;
        }
    } else {
        $error = "Mohon lengkapi semua field yang wajib.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-5">
    <a class="navbar-brand fw-bold text-warning" href="index.php">WARHEX ADMIN</a>
    <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            Tambah Produk Baru
        </div>
        <div class="card-body">
            <?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label>Nama Produk (Title)</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Path Gambar (misal: assets/WarHex1.png)</label>
                    <input type="text" name="image" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label>CSS Class Bento (Opsional, bawaan prod-cell--b)</label>
                    <input type="text" name="cell_class" class="form-control" value="prod-cell--b">
                    <small class="text-muted">Pilihan: prod-cell--b, prod-cell--d prod-cell--reverse, prod-cell--e, prod-cell--f</small>
                </div>
                
                <button type="submit" class="btn btn-success">Simpan Produk</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
