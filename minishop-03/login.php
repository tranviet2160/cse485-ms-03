<?php
session_start();

// Nếu đã đăng nhập thì đẩy thẳng vào dashboard
if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'MiniShop@03') {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = 'admin';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login - MiniShop</title></head>
<body>
    <h2>Đăng nhập Hệ thống</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>