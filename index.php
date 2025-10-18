<?php
session_start();
if (isset($_SESSION['nip'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Perwalian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login Dosen Wali</h2>
        <?php 
        if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'){
            echo "<div class='alert alert-danger'>Login gagal! Email atau password salah.</div>";
        }
        ?>
        <form action="login.php" method="post">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>