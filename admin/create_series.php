<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config.php';
$error = ''; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $release_year = $_POST['release_year'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';

    if ($title && $genre && $release_year && $image) {
        $stmt = $conn->prepare("INSERT INTO series (title, genre, release_year, image, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $genre, $release_year, $image, $category);
        if ($stmt->execute()) {
            $success = "Series berhasil ditambahkan!";
        } else {
            $error = "Gagal: " . $conn->error;
        }
    } else {
        $error = "Lengkapi semua field wajib.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Series - Admin WarHex</title>
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
    </div>
    <div class="admin-nav-right">
        <a href="logout.php" class="admin-btn-logout">LOGOUT</a>
    </div>
</nav>

<div class="admin-container" style="max-width:650px;">
    <a href="series.php" class="admin-back-link"><i class="bi bi-arrow-left"></i> KEMBALI KE SERIES</a>

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-header-tag">NEW</span>
            <span class="admin-card-header-title">Tambah Series Baru</span>
        </div>
        <div class="admin-card-body">
            <?php if($error): ?><div class="admin-alert admin-alert-danger"><?= $error ?></div><?php endif; ?>
            <?php if($success): ?><div class="admin-alert admin-alert-success"><?= $success ?></div><?php endif; ?>

            <form method="POST" action="" class="admin-form">
                <div class="form-group">
                    <label class="form-label">JUDUL SERIES</label>
                    <input type="text" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">GENRE</label>
                    <input type="text" name="genre" class="form-input" placeholder="MECHA / ACTION" required>
                </div>
                <div class="form-group">
                    <label class="form-label">TAHUN RILIS</label>
                    <input type="text" name="release_year" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">PATH GAMBAR</label>
                    <input type="text" name="image" class="form-input" placeholder="assets/WarHex1.png" required>
                </div>
                <div class="form-group">
                    <label class="form-label">KATEGORI FILTER</label>
                    <input type="text" name="category" class="form-input" placeholder="ACTION,MECHA">
                    <span class="form-hint">Pisahkan dengan koma. Contoh: ACTION,MECHA</span>
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="admin-btn admin-btn-success">SIMPAN SERIES</button>
                    <a href="series.php" class="admin-btn admin-btn-secondary">BATAL</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
