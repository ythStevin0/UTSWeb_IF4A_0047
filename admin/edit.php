<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    $cell_class = $_POST['cell_class'] ?? 'prod-cell--b';

    if ($title && $description && $image) {
        $update_stmt = $conn->prepare("UPDATE products SET title=?, description=?, image=?, cell_class=? WHERE id=?");
        $update_stmt->bind_param("ssssi", $title, $description, $image, $cell_class, $id);
        if ($update_stmt->execute()) {
            $success = "Produk berhasil diperbarui!";
            // Update local variable to reflect changes immediately
            $product['title'] = $title;
            $product['description'] = $description;
            $product['image'] = $image;
            $product['cell_class'] = $cell_class;
        } else {
            $error = "Gagal memperbarui produk: " . $conn->error;
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
    <title>Edit Produk - Admin</title>
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
        <div class="card-header bg-primary text-white fw-bold">
            Edit Produk #<?= $product['id'] ?>
        </div>
        <div class="card-body">
            <?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label>Nama Produk (Title)</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Path Gambar</label>
                    <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($product['image']) ?>" required>
                </div>
                <div class="mb-4">
                    <label>CSS Class Bento</label>
                    <input type="text" name="cell_class" class="form-control" value="<?= htmlspecialchars($product['cell_class']) ?>">
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
