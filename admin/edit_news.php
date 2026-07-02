<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config.php';
$error = ''; $success = '';
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();
if (!$news) die("News tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $image = $_POST['image'] ?? '';
    $tags = $_POST['tags'] ?? '';

    if ($title && $date && $image) {
        $update = $conn->prepare("UPDATE news SET title=?, date=?, image=?, tags=? WHERE id=?");
        $update->bind_param("ssssi", $title, $date, $image, $tags, $id);
        if ($update->execute()) {
            $success = "News berhasil diperbarui!";
            $news['title'] = $title; $news['date'] = $date;
            $news['image'] = $image; $news['tags'] = $tags;
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
    <title>Edit News - Admin WarHex</title>
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
    <a href="news.php" class="admin-back-link"><i class="bi bi-arrow-left"></i> KEMBALI KE NEWS</a>

    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-header-tag">EDIT</span>
            <span class="admin-card-header-title">Edit News #<?= $id ?></span>
        </div>
        <div class="admin-card-body">
            <?php if($error): ?><div class="admin-alert admin-alert-danger"><?= $error ?></div><?php endif; ?>
            <?php if($success): ?><div class="admin-alert admin-alert-success"><?= $success ?></div><?php endif; ?>

            <form method="POST" action="" class="admin-form">
                <div class="form-group">
                    <label class="form-label">JUDUL BERITA</label>
                    <input type="text" name="title" class="form-input" value="<?= htmlspecialchars($news['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">TANGGAL</label>
                    <input type="text" name="date" class="form-input" value="<?= htmlspecialchars($news['date']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">PATH GAMBAR</label>
                    <input type="text" name="image" class="form-input" value="<?= htmlspecialchars($news['image']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">TAGS</label>
                    <input type="text" name="tags" class="form-input" value="<?= htmlspecialchars($news['tags']) ?>">
                </div>

                <div style="display:flex;gap:10px;margin-top:1.5rem;">
                    <button type="submit" class="admin-btn admin-btn-primary">SIMPAN PERUBAHAN</button>
                    <a href="news.php" class="admin-btn admin-btn-secondary">BATAL</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
