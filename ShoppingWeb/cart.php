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

// ฟังก์ชันในการเพิ่มสินค้าลงในตะกร้า
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = 1; // กำหนดให้เป็น 1 ชิ้นต่อการเพิ่ม

    // ตรวจสอบว่ามีสินค้าในตะกร้าแล้วหรือยัง
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = ['quantity' => $quantity];
    }

    // redirect กลับมาหน้าเดิมเพื่อหลีกเลี่ยงการส่งข้อมูลซ้ำเมื่อ refresh หน้า
    header('Location: cart.php');
    exit();
}

// ฟังก์ชันในการแสดงรายการสินค้าในตะกร้า
function displayCart() {
    global $conn;
    $totalPrice = 0; // ตัวแปรสำหรับเก็บรวมราคา

    if (!empty($_SESSION['cart'])) {
        echo "<h3>รายการสินค้าในตะกร้า:</h3>";
        echo "<table class='cart-table'>
                <thead>
                    <tr>
                        <th>รูปภาพ</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>รวมราคา</th>
                        <th>การจัดการ</th>
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
                    <td><img src='{$product['image']}' alt='{$product['name']}' class='product-image1'></td>
                    <td>{$product['name']}</td>
                    <td>{$product['price']} บาท</td>
                    <td>
                        <form method='post' action='cart.php'>
                            <input type='number' name='quantity' value='{$item['quantity']}' min='1'>
                            <input type='hidden' name='product_id' value='{$productId}'>
                            <button type='submit' name='update_cart' class='update-button'>ปรับจำนวน</button>
                        </form>
                    </td>
                    <td>{$itemTotal} บาท</td>
                    <td>
                        <form method='post' action='cart.php'>
                            <input type='hidden' name='remove_product_id' value='{$productId}'>
                            <button type='submit' name='remove_from_cart' class='remove-button'>ลบ</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody>
              </table>";
        echo "<h3>รวมทั้งหมด: {$totalPrice} บาท</h3>"; // แสดงรวมราคาทั้งหมด
    } else {
        echo "<h3>ตะกร้าสินค้าว่างเปล่า</h3>";
    }
}

// ฟังก์ชันในการปรับจำนวนสินค้าในตะกร้า
if (isset($_POST['update_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // ปรับจำนวนสินค้าตามที่ผู้ใช้กรอก
    if ($quantity > 0) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    } else {
        unset($_SESSION['cart'][$productId]); // หากจำนวนเป็น 0 ให้ลบสินค้าออกจากตะกร้า
    }
    header('Location: cart.php');
    exit();
}

// ฟังก์ชันในการลบสินค้าออกจากตะกร้า
if (isset($_POST['remove_from_cart'])) {
    $removeProductId = $_POST['remove_product_id'];
    unset($_SESSION['cart'][$removeProductId]);
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="style.css"> <!-- เชื่อมต่อ CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* CSS สำหรับการจัดตำแหน่งปุ่ม */
        .button-container {
            display: flex; /* ใช้ Flexbox */
            justify-content: center; /* จัดแนวกลางในแนวนอน */
            margin-top: 20px; /* เพิ่มระยะห่างด้านบน */
        }

        .checkout-button {
            background-color: #FF6F61; /* สีพื้นหลังปุ่ม */
            color: white; /* สีข้อความในปุ่ม */
            padding: 10px 20px; /* ขนาดของปุ่ม */
            border: none; /* ไม่มีกรอบ */
            cursor: pointer; /* แสดงมือเมื่อวางเมาส์ */
            border-radius: 5px; /* ทำให้มุมปุ่มกลม */
            font-size: 16px; /* ขนาดตัวอักษร */
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

    <h1>ตะกร้าสินค้า</h1>

    <!-- แสดงรายการสินค้าที่เพิ่มลงในตะกร้า -->
    <?php displayCart(); ?>

    <br>

    <!-- ปุ่ม Checkout อยู่ใน Container สำหรับจัดตำแหน่ง -->
    <div class="button-container">
        <form method="post" action="checkout.php">
            <button type="submit" name="checkout" class="checkout-button">สั่งซื้อ</button>
        </form>
    </div>
</body>
</html>

