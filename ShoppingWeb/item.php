<?php
session_start();

// เชื่อมต่อฐานข้อมูล MySQL
$conn = new mysqli('localhost', 'root', '', 'dbhw9');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงหมวดหมู่จากพารามิเตอร์ URL
$category = isset($_GET['category']) ? $_GET['category'] : 'แผ่นรองนอน'; // ค่าเริ่มต้น

// Query สำหรับดึงข้อมูลสินค้าตามหมวดหมู่ที่เลือก
$sql = "SELECT * FROM products WHERE category = '$category'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Trevel Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <span>ยินดีต้อนรับ, <a href="showdata.php?username=<?php echo urlencode($_SESSION['username']); ?>"><?php echo htmlspecialchars($_SESSION['username']); ?></a>!</span>
                <a class="logout" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            <?php else: ?>
                <a class="login" href="login.php">
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
        <div class="dropdown">
            <button class="dropbtn">ที่นอน</button>
            <div class="dropdown-content">
                <div class="menu-column">
                    <a href="item.php?category=ที่นอน">เครื่องนอน</a>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">เสื้อผ้าและรองเท้า</button>
            <div class="dropdown-content">
                <div class="menu-column">
                    <a href="item.php?category=เสื้อผ้า">เสื้อผ้า</a>
                    <a href="item.php?category=รองเท้า">รองเท้า</a>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">อุปกรณ์เสริม</button>
            <div class="dropdown-content">
                <div class="menu-column">
                    <a href="item.php?category=อุปกรณ์เสริม">อุปกรณ์อื่นๆ</a>
                </div>
            </div>
        </div>
    </div>

    <div class="product-list-item">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="150" height="250">
                    <h3><?= $product['name'] ?></h3>
                    <p>ราคา: <?= $product['price'] ?> บาท</p>
                    <!-- ปุ่ม Add to Cart และ View Details -->
                    <div class="add-to-cart">
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" name="add_to_cart">เพิ่มสินค้าลงตระกร้า</button>
                        </form>
                        <a href="view_product.php?id=<?= $product['id'] ?>" class="view-details">ดูรายละเอียดสินค้า</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>ไม่มีสินค้าในหมวดหมู่นี้</p>
        <?php endif; ?>
    </div>
</body>

</html>
