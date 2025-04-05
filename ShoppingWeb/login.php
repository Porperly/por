<!DOCTYPE html>
<html lang="th">
<body>
    <div class="menu">
        <a href="index.php">
            <i class="fas fa-home"></i>
            Home
        </a>
    </div>
<head>
    <meta charset="UTF-8">
    <title>Trevel Shop - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <form id="loginForm" action="showdata.php" method="POST">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" placeholder="ชื่อผู้ใช้" required><br>
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" placeholder="รหัสผ่าน" required><br>
            <div class="login-actions">
                <button type="submit" class="login-button">เข้าสู่ระบบ</button>
                <a class="register-link" href="regis.php">คุณยังไม่มีบัญชี? สมัครสมาชิก</a>
            </div>
        </form>
    </div>
</body>

</html>
