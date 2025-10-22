<?php session_start(); if(isset($_SESSION['role'])) { header('Location: ' . $_SESSION['role'] . '_dashboard.php'); exit(); } ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Gerbang ITK</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container login-box">
        <h2>Selamat Datang di Gerbang ITK</h2>
        <?php if(isset($_GET['error'])) { echo '<p style="color:red;">Email atau password salah!</p>'; } ?>
        <form action="login_proses.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>