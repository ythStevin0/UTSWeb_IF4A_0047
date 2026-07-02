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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - WarHex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;600;700;900&family=Chakra+Petch:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #0b0f19;
            overflow: hidden;
        }
        .login-overlay {
            position: static;
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
            transform: translateY(0);
            height: 100vh;
        }
    </style>
</head>
<body>

<section class="login-overlay is-open">
    <button class="login-close" onclick="window.location.href = '../index.php';" aria-label="Close" type="button">
        <i class="bi bi-x-lg"></i>
    </button>
    <div class="login-bg-deco" aria-hidden="true">
        <div class="login-deco-line login-deco-line--1"></div>
        <div class="login-deco-line login-deco-line--2"></div>
        <div class="login-deco-line login-deco-line--3"></div>
        <div class="login-deco-grid"></div>
    </div>

    <div class="login-content">
        <div class="login-brand-col">
            <a href="../index.php" class="login-brand-link">
                <img src="../assets/WarHexLogo2.png" alt="WarHex" class="login-brand-logo">
                <span class="login-brand-name">WARHEX</span>
            </a>
            <h2 class="login-brand-title">BACK TO<br>THE<br><span>BATTLEFIELD.</span></h2>
            <p class="login-brand-desc">Your account. Your battle history. Your glory. Log in to continue where you left off.</p>

            <div class="login-stats">
                <div class="login-stat">
                    <span class="login-stat-num">4M+</span>
                    <span class="login-stat-label">WARRIORS ONLINE</span>
                </div>
                <div class="login-stat-sep"></div>
                <div class="login-stat">
                    <span class="login-stat-num">5</span>
                    <span class="login-stat-label">ACTIVE SERIES</span>
                </div>
                <div class="login-stat-sep"></div>
                <div class="login-stat">
                    <span class="login-stat-num">24/7</span>
                    <span class="login-stat-label">BATTLE READY</span>
                </div>
            </div>
        </div>

        <div class="login-form-col">
            <div class="login-panel">
                <div class="login-panel-header">
                    <span class="login-panel-tag">AUTH</span>
                    <span class="login-panel-title">ADMIN LOGIN</span>
                    <span class="login-panel-line"></span>
                </div>

                <p class="login-welcome">Welcome back, admin. Enter your credentials to access the panel.</p>

                <?php if($error): ?>
                    <div style="background-color: rgba(220, 53, 69, 0.2); color: #ff6b6b; padding: 10px 15px; border-left: 4px solid #dc3545; margin-bottom: 20px; font-weight: bold; border-radius: 4px;">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="login-form">
                    <div class="login-field">
                        <label class="login-label">USERNAME</label>
                        <div class="login-input-wrap">
                            <i class="bi bi-person-fill login-input-icon"></i>
                            <input name="username" type="text" class="login-input" placeholder="admin" required autofocus>
                        </div>
                    </div>

                    <div class="login-field">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="login-label mb-0">PASSWORD</label>
                        </div>
                        <div class="login-input-wrap">
                            <i class="bi bi-lock-fill login-input-icon"></i>
                            <input name="password" type="password" class="login-input" placeholder="••••••••••••" id="loginPassword" required>
                            <button class="login-eye-btn" onclick="togglePassword()" type="button" aria-label="Toggle password">
                                <i class="bi bi-eye-fill" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-submit">
                        <span>ENTER ADMIN PANEL</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword() {
  const input = document.getElementById('loginPassword');
  const icon  = document.getElementById('eyeIcon');
  const isHidden = input.type === 'password';
  input.type      = isHidden ? 'text' : 'password';
  icon.className  = isHidden ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
}
</script>

</body>
</html>
