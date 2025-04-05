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

// ฟังก์ชันในการแสดงรายการสินค้าในตะกร้า
function displayCart() {
    global $conn;
    $totalPrice = 0; // ตัวแปรสำหรับเก็บรวมราคา

    if (!empty($_SESSION['cart'])) {
        echo "<h3 style='text-align: center;'>รายการสินค้า:</h3>";
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 80%; text-align: left; border-collapse: collapse; margin: 0 auto;'>";
        echo "<thead>
                <tr>
                    <th style='background-color: #FFB3BA; color: #333;'>รูปภาพ</th>
                    <th style='background-color: #FFB3BA; color: #333;'>ชื่อสินค้า</th>
                    <th style='background-color: #FFB3BA; color: #333;'>ราคา</th>
                    <th style='background-color: #FFB3BA; color: #333;'>จำนวน</th>
                    <th style='background-color: #FFB3BA; color: #333;'>รวมราคา</th>
                </tr>
              </thead>
              <tbody>";
        foreach ($_SESSION['cart'] as $productId => $item) {
            // ดึงข้อมูลสินค้าจากฐานข้อมูล
            $sql = "SELECT name, price, image FROM products WHERE id = $productId";
            $result = $conn->query($sql);
            $product = $result->fetch_assoc();

            // คำนวณรวมราคา
            $itemTotal = $product['price'] * $item['quantity'];
            $totalPrice += $itemTotal;

            // แสดงข้อมูลในตาราง
            echo "<tr>
                    <td><img src='{$product['image']}' alt='{$product['name']}' style='width: 100px; height: auto;'></td>
                    <td>{$product['name']}</td>
                    <td>{$product['price']} บาท</td>
                    <td>{$item['quantity']}</td>
                    <td>{$itemTotal} บาท</td>
                  </tr>";
        }
        echo "</tbody>
              </table>";
        echo "<h3 style='text-align: center;'>รวมทั้งหมด: {$totalPrice} บาท</h3>"; // แสดงรวมราคาทั้งหมด
    } else {
        echo "<h3 style='text-align: center;'>ตะกร้าสินค้าว่างเปล่า</h3>";
    }
}

// ฟังก์ชันในการอัปเดตจำนวนสินค้าในสต็อก
function updateStock() {
    global $conn;

    foreach ($_SESSION['cart'] as $productId => $item) {
        $quantityPurchased = $item['quantity'];

        // ลดจำนวนสินค้าที่อยู่ใน stock_quantity
        $sql = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantityPurchased, $productId, $quantityPurchased);
        $stmt->execute();
    }
}

// ดำเนินการสั่งซื้อสำเร็จ
$purchaseCompleted = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // อัปเดตจำนวนสินค้าที่สต็อก
    updateStock();
    $purchaseCompleted = true;
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Trevel Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <style>
        .custom-button {
            display: inline-block;
            background-color: #FF6F61;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #E95A50;
        }

        /* CSS สำหรับจัดปุ่มให้อยู่ตรงกลางล่าง */
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">
            <i class="fas fa-home"></i>
            Home
        </a>
    </div>
    <h1 style="text-align: center;">สั่งซื้อ</h1>

    <?php if ($purchaseCompleted): ?>
        <h2 style="text-align: center;">ขอบคุณสำหรับการสั่งซื้อ!</h2>
        <p style="text-align: center;">รายละเอียดการสั่งซื้อของคุณ:</p>
        <?php displayCart(); ?>

        <!-- ลบสินค้าในตะกร้าหลังจากแสดงใบเสร็จ -->
        <?php unset($_SESSION['cart']); ?>

    <?php else: ?>
        <!-- แสดงฟอร์มสำหรับยืนยันการสั่งซื้อ -->
        <form method="post" action="checkout.php" style="text-align: center;">
            <button type="submit" class="custom-button">ยืนยันการสั่งซื้อ</button>
        </form>
    <?php endif; ?>

    <!-- ปุ่มกลับสู่หน้าหลัก -->
    <div class="button-container">
        <a href="index.php" class="custom-button">กลับสู่หน้าหลัก</a>
    </div>
</body>
</html>
