<?php
session_start();
require 'config.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau Password salah!';
        }
    } else {
        $error = 'Username atau Password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - WarHex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0f19; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: #131a2a; border: 1px solid #334155; border-radius: 8px; padding: 2rem; width: 100%; max-width: 400px; }
        .form-control { background: #1e293b; border-color: #334155; color: #fff; }
        .form-control:focus { background: #1e293b; color: #fff; border-color: #6366f1; box-shadow: none; }
        .btn-primary { background-color: #eab308; border-color: #eab308; color: #000; font-weight: bold; }
        .btn-primary:hover { background-color: #ca8a04; border-color: #ca8a04; color: #000; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4 text-uppercase fw-bold">Admin Login</h3>
    
    <?php if($error): ?>
        <div class="alert alert-danger p-2 text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">LOG IN</button>
    </form>
</div>

</body>
</html>
