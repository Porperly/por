<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbhw9";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// การจัดการสิทธิ์ลูกค้า
if (isset($_POST['edit_customer_role'])) {
    $customer_id = $_POST['customer_id'];
    $role = $_POST['role'];

    // ตรวจสอบว่าบทบาทที่ส่งมาถูกต้องหรือไม่
    $valid_roles = ['customer', 'manager', 'admin'];
    if (in_array($role, $valid_roles)) {
        $sql_edit_customer_role = "UPDATE customers SET role='$role' WHERE id=$customer_id";
        if ($conn->query($sql_edit_customer_role) === TRUE) {
            echo "<script>alert('เปลี่ยนสิทธิ์สำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเปลี่ยนสิทธิ์');</script>";
        }
    } else {
        echo "<script>alert('บทบาทไม่ถูกต้อง');</script>";
    }
}

// แสดงลูกค้าทั้งหมด
$sql_customers = "SELECT * FROM customers";
$result_customers = $conn->query($sql_customers);

// การเพิ่มสินค้า
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql_add = "INSERT INTO products (name, image, price, category, description, stock_quantity) VALUES ('$name', '$image', '$price', '$category', '$description', '$stock_quantity')";
    $conn->query($sql_add);
}

// การลบสินค้า
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $sql_delete = "DELETE FROM products WHERE id = $product_id";
    $conn->query($sql_delete);
}

// การแก้ไขสินค้า
if (isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql_edit = "UPDATE products SET name='$name', image='$image', price='$price', category='$category', description='$description', stock_quantity='$stock_quantity' WHERE id=$product_id";
    $conn->query($sql_edit);
}

// แสดงรายการสินค้าทั้งหมด
$sql_products = "SELECT * FROM products";
$result_products = $conn->query($sql_products);
?>

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
    <title>Travel - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            /* Light background for contrast */
        }

        h1,
        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: black;
            /* Black background for the header */
            color: white;
            /* White text color */
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
            /* Light gray border for cells */
        }

        tr:hover {
            background-color: #f1f1f1;
            /* Light gray background on row hover */
        }

        .description {
            display: none;
            /* ซ่อนรายละเอียดเริ่มต้น */
        }

        .table-header {
            display: flex;
            align-items: center;
            /* จัดให้ปุ่มอยู่กึ่งกลางแนวตั้ง */
        }

        .toggle-button {
            margin-left: 20px;
            /* เพิ่มระยะห่างระหว่างข้อความกับปุ่ม */
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            /* Blue button background */
            color: white;
            /* White text color */
            cursor: pointer;
            /* Pointer cursor on hover */
            border-radius: 4px;
            /* Rounded corners */
        }

        .toggle-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 4px;
            /* Rounded corners */
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            /* Green button background */
            color: white;
            /* White text color */
            cursor: pointer;
            /* Pointer cursor on hover */
            border-radius: 4px;
            /* Rounded corners */
        }

        button:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        .back-button {
            display: block;
            margin-top: 10px;
            /* ระยะห่างจากปุ่ม "เปิด/ปิด ตารางสินค้า" */
            text-decoration: none;
            color: white;
            background-color: red;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            width: fit-content;
        }

        .back-button:hover {
            background-color: #5a6268;
            /* Darker gray on hover */
        }

        .btn-secondary {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background-color: gray;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            width: fit-content;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            /* Darker gray on hover */
        }
    </style>
    <script>
        function toggleDescription(productId) {
            const descriptionElement = document.getElementById('description-' + productId);
            if (descriptionElement.style.display === 'none' || descriptionElement.style.display === '') {
                descriptionElement.style.display = 'block'; // แสดงรายละเอียด
            } else {
                descriptionElement.style.display = 'none'; // ซ่อนรายละเอียด
            }
        }

        function toggleForm() {
            var form = document.getElementById("addProductForm");
            var button = document.getElementById("toggleFormButton");
            if (form.style.display === "none") {
                form.style.display = "block";
                button.textContent = "ซ่อนฟอร์มเพิ่มสินค้าใหม่";
            } else {
                form.style.display = "none";
                button.textContent = "เพิ่มสินค้าใหม่";
            }
        }

        function toggleTable() {
            var table = document.getElementById("product-table");
            var button = document.getElementById("toggleTableButton"); // เพิ่มการเลือกปุ่ม
            if (table.style.display === "none") {
                table.style.display = "table"; // แสดงตารางเมื่อซ่อนอยู่
                button.textContent = "ซ่อนสินค้าในระบบ"; // เปลี่ยนข้อความปุ่มเมื่อแสดงตาราง
            } else {
                table.style.display = "none"; // ซ่อนไว้เมื่อแสดงอยู่
                button.textContent = "แสดงสินค้าในระบบ"; // เปลี่ยนข้อความปุ่มเมื่อซ่อนตาราง
            }
        }
    </script>
</head>

<body>
    <h2>จัดการสิทธิของผู้ใช้</h2>
    <table>
        <tr>
            <th>ชื่อผู้ใช้</th>
            <th>อีเมล</th>
            <th>สิทธิ์</th>
        </tr>
        <?php while ($customer = $result_customers->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['username']); ?></td>
                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                        <select name="role">
                            <option value="customer" <?php echo ($customer['role'] === 'customer') ? 'selected' : ''; ?>>customer</option>
                            <option value="manager" <?php echo ($customer['role'] === 'manager') ? 'selected' : ''; ?>>manager</option>
                            <option value="admin" <?php echo ($customer['role'] === 'admin') ? 'selected' : ''; ?>>admin</option>
                        </select>
                        <button type="submit" name="edit_customer_role">บันทึก</button>
                    </form
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>จัดการสินค้า</h2>
    <button id="toggleTableButton" onclick="toggleTable()">แสดงสินค้าในระบบ</button>
    <table id="product-table" style="display: none;">
        <tr>
            <th>ชื่อสินค้า</th>
            <th>รูปภาพ</th>
            <th>ราคา</th>
            <th>หมวดหมู่</th>
            <th>รายละเอียด</th>
            <th>จำนวนคงคลัง</th>
            <th>จัดการ</th>
        </tr>
        <?php while ($product = $result_products->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50"></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td>
                    <button onclick="toggleDescription(<?php echo $product['id']; ?>)">แสดง/ซ่อนรายละเอียด</button>
                    <div id="description-<?php echo $product['id']; ?>" class="description">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </div>
                </td>
                <td><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                <td>
                    <a href="?delete=<?php echo $product['id']; ?>">ลบ</a>
                    <button onclick="document.getElementById('editProduct-<?php echo $product['id']; ?>').style.display='block';">แก้ไข</button>
                    <div id="editProduct-<?php echo $product['id']; ?>" style="display:none;">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>
                            <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                            <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                            <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                            <input type="number" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>
                            <button type="submit" name="edit_product">บันทึกการเปลี่ยนแปลง</button>
                            <button type="button" onclick="document.getElementById('editProduct-<?php echo $product['id']; ?>').style.display='none';">ยกเลิก</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <button id="toggleFormButton" onclick="toggleForm()">เพิ่มสินค้าใหม่</button>
    <div id="addProductForm" style="display: none;">
        <h3>เพิ่มสินค้าใหม่</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="ชื่อสินค้า" required>
            <input type="text" name="image" placeholder="URL รูปภาพ" required>
            <input type="number" name="price" placeholder="ราคา" required>
            <input type="text" name="category" placeholder="หมวดหมู่" required>
            <textarea name="description" placeholder="รายละเอียด" required></textarea>
            <input type="number" name="stock_quantity" placeholder="จำนวนคงคลัง" required>
            <button type="submit" name="add_product">เพิ่มสินค้า</button>
        </form>
    </div>
    
    <a href="logout.php" class="back-button">ออกจากระบบ</a>
</body>

</html>
