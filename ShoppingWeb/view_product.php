<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbhw9";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลสินค้าจาก ID ที่ได้รับผ่าน URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div class="logo">
        <img alt="traval shop" src="https://th.bing.com/th/id/OIP.sQI-YjXIpSQIQP-5oIoYCwHaJH?rs=1&pid=ImgDetMain" />
        </div>
        <div class="search-bar">
            <form method="GET" action="index.php">
                <input placeholder="คุณกำลังหาอะไรอยู่" name="keyword" type="text" />
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="right-section">
            <?php if (isset($_SESSION['username'])): ?>
                <span>ยินดีต้อนรับ, <a href="cart.php?username=<?php echo urlencode($_SESSION['username']); ?>"><?php echo htmlspecialchars($_SESSION['username']); ?></a>!</span>
                <a class="logout" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            <?php else: ?>
                <a class="cart" href="cart.php">
                    <i class="fas fa-user"></i>
                    Login
                </a>
            <?php endif; ?>
            <a class="cart" href="cart.php">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </div>
    
    <div class="menu">
        <a href="index.php">
            <i class="fas fa-home"></i>
            Home
        </a>
        <!-- ... (dropdown menus) ... -->
    </div>

    <div class="product-details">
    <?php if ($product): ?>
        <div class="product-card">
            <div class="product-image">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="product-info">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p>รายละเอียดสินค้า: <?= htmlspecialchars($product['description']) ?></p>
                <p class="price">ราคา: <?= number_format($product['price']) ?> บาท</p>
                <p class="stock">จำนวนสินค้าในสต็อก: <?= $product['stock_quantity'] ?> ชิ้น</p>
                <div class="product-buttons-item">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" name="add_to_cart">เพิ่มสินค้าลงตระกร้า</button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>ไม่พบสินค้าที่ต้องการ</p>
    <?php endif; ?>
</div>
