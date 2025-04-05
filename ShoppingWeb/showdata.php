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

// ฟังก์ชันออกจากระบบ
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// ฟังก์ชันล็อกอิน
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM customers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            // เก็บข้อมูลใน session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // หากเป็น manager
            if ($user['role'] === 'manager') {
                // ส่งไปหน้า manage
                header('Location: manage.php');
                exit();
            } else {
                // ส่งไปหน้าแสดงข้อมูลสมาชิกสำหรับลูกค้าและ admin
                header('Location: showdata.php');
                exit();
            }
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('ไม่พบบัญชีนี้.'); window.history.back();</script>";
    }
}

// ฟังก์ชันแก้ไขข้อมูล
if (isset($_POST['update'])) {
    $username = $_SESSION['username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE customers SET first_name='$firstName', last_name='$lastName', gender='$gender', age='$age', province='$province', email='$email' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ข้อมูลของคุณถูกอัปเดตเรียบร้อยแล้ว!');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <title>Trevel Shop</title>
</head>

<body>
    <div class="container mt-5">
        <h2>ยินดีต้อนรับ, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- ปุ่มสำหรับ Manager -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'manager'): ?>
            <a href="manage.php" class="btn btn-primary">ไปยังหน้าจัดการ</a>
        <?php endif; ?>

        <!-- ฟังก์ชันแสดงข้อมูลลูกค้า (สำหรับลูกค้า) -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'customer'): ?>
            <h3>ข้อมูลของฉัน</h3>
            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM customers WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();  // ดึงข้อมูลผู้ใช้คนเดียวออกมา

                // แสดงข้อมูลในแบบฟอร์มเพื่อให้แก้ไข
                echo '<form method="POST" action="">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="' . $row['first_name'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="' . $row['last_name'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="Male" ' . ($row['gender'] == 'Male' ? 'selected' : '') . '>Male</option>
                                <option value="Female" ' . ($row['gender'] == 'Female' ? 'selected' : '') . '>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" value="' . $row['age'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province:</label>
                            <input type="text" class="form-control" id="province" name="province" value="' . $row['province'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="' . $row['email'] . '" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-success">อัปเดตข้อมูล</button>
                      </form>';
            } else {
                echo "<p>ไม่พบข้อมูลของคุณ</p>";
            }
            ?>
            <a href="index.php" class="btn btn-secondary">กลับสู่หน้าหลัก</a>
        <?php endif; ?>

    </div>
</body>

</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbhw9";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ฟังก์ชันออกจากระบบ
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// ฟังก์ชันเพิ่มผู้ใช้
if (isset($_POST['add_user'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];
    $new_gender = $_POST['new_gender'];
    $new_age = $_POST['new_age'];
    $new_province = $_POST['new_province'];
    $new_email = $_POST['new_email'];
    $new_role = $_POST['new_role'];

    $sql = "INSERT INTO customers (username, password, first_name, last_name, gender, age, province, email, role) VALUES ('$new_username', '$new_password', '$new_first_name', '$new_last_name', '$new_gender', '$new_age', '$new_province', '$new_email', '$new_role')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('เพิ่มผู้ใช้เรียบร้อย!');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มผู้ใช้: " . $conn->error . "');</script>";
    }
}

// ฟังก์ชันลบผู้ใช้
if (isset($_POST['delete_user'])) {
    $delete_username = $_POST['delete_username'];

    $sql = "DELETE FROM customers WHERE username = '$delete_username'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ลบผู้ใช้เรียบร้อย!');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบผู้ใช้: " . $conn->error . "');</script>";
    }
}

// ฟังก์ชันแก้ไขข้อมูล
if (isset($_POST['update'])) {
    $username = $_POST['username']; // ชื่อผู้ใช้ที่ต้องการแก้ไข
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE customers SET first_name='$firstName', last_name='$lastName', gender='$gender', age='$age', province='$province', email='$email', role='$role' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ข้อมูลของคุณถูกอัปเดตเรียบร้อยแล้ว!');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error . "');</script>";
    }
    // ฟังก์ชันเพิ่มผู้ใช้
if (isset($_POST['add_user'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];
    $new_gender = $_POST['new_gender'];
    $new_age = $_POST['new_age'];
    $new_province = $_POST['new_province'];
    $new_email = $_POST['new_email'];
    $new_role = $_POST['new_role'];

    // ตรวจสอบว่ารหัสผ่านทั้งสองช่องตรงกัน
    if ($new_password !== $confirm_password) {
        echo "<script>alert('รหัสผ่านไม่ตรงกัน!');</script>";
    } else if (strlen($new_password) < 8 || 
               !preg_match('/[A-Z]/', $new_password) || 
               !preg_match('/[a-z]/', $new_password) || 
               !preg_match('/[0-9]/', $new_password)) {
        echo "<script>alert('รหัสผ่านต้องมีอย่างน้อย 8 ตัว, มีตัวพิมพ์ใหญ่, ตัวพิมพ์เล็ก, และตัวเลข!');</script>";
    } else {
        // แฮชรหัสผ่านที่ถูกต้อง
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO customers (username, password, first_name, last_name, gender, age, province, email, role) 
                VALUES ('$new_username', '$hashed_password', '$new_first_name', '$new_last_name', '$new_gender', '$new_age', '$new_province', '$new_email', '$new_role')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('เพิ่มผู้ใช้เรียบร้อย!');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มผู้ใช้: " . $conn->error . "');</script>";
        }
    }
}
}

 // ตรวจสอบว่ารหัสผ่านทั้งสองช่องตรงกัน
 
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            width: 100%;
            overflow-x: hidden; /* ป้องกันการเลื่อนด้านข้าง */
        }
        .container {
            width: 100%; /* ให้คอนเทนเนอร์มีความกว้าง 100% */
            max-width: 100%; /* จำกัดความกว้างสูงสุดเป็น 100% */
        }
        table {
            width: 100%; /* กำหนดความกว้างตารางเป็น 100% */
            table-layout: fixed; /* ป้องกันการเลื่อน */
        }
        th, td {
            text-align: center; /* จัดตำแหน่งข้อมูลให้อยู่กลาง */
            overflow: hidden; /* ซ่อนข้อมูลที่เกินออกไป */
            white-space: nowrap; /* ไม่ให้ข้อความ wrap */
            text-overflow: ellipsis; /* แสดง "..." เมื่อข้อความเกิน */
        }
        th {
            background-color: #f8f9fa; /* สีพื้นหลังของหัวตาราง */
        }
        .form-group {
            width: 100%; /* กำหนดความกว้างของฟอร์มให้เป็น 100% */
            max-width: 100%; /* จำกัดความกว้างสูงสุดเป็น 100% */
        }
        button {
            width: 100%; /* ปุ่มกว้าง 100% */
        }
    </style>
    <title>Trevel Shop</title>
</head>

<body>
    <div class="container mt-5">
       

        <!-- ปุ่มสำหรับ Admin -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <h3>จัดการผู้ใช้</h3>

            <!-- ฟอร์มเพิ่มผู้ใช้ -->
             
            <form method="POST" action="">
                <h4>เพิ่มผู้ใช้ใหม่</h4>
                <div class="form-group">
                    <label for="new_username">ชื่อผู้ใช้:</label>
                    <input type="text" class="form-control" id="new_username" name="new_username" required>
                </div>
                <div class="form-group">
                    <label for="new_password">รหัสผ่าน:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">ยืนยันรหัสผ่าน:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <label for="new_first_name">ชื่อจริง:</label>
                    <input type="text" class="form-control" id="new_first_name" name="new_first_name" required>
                </div>
                <div class="form-group">
                    <label for="new_last_name">นามสกุล:</label>
                    <input type="text" class="form-control" id="new_last_name" name="new_last_name" required>
                </div>
                <div class="form-group">
                    <label for="new_gender">เพศ:</label>
                    <select class="form-control" id="new_gender" name="new_gender" required>
                        <option value="Male">ชาย</option>
                        <option value="Female">หญิง</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_age">อายุ:</label>
                    <input type="number" class="form-control" id="new_age" name="new_age" required>
                </div>
                <div class="form-group">
                    <label for="new_province">จังหวัด:</label>
                    <input type="text" class="form-control" id="new_province" name="new_province" required>
                </div>
                <div class="form-group">
                    <label for="new_email">อีเมล:</label>
                    <input type="email" class="form-control" id="new_email" name="new_email" required>
                </div>
                <div class="form-group">
                    <label for="new_role">บทบาท:</label>
                    <select class="form-control" id="new_role" name="new_role" required>
                        <option value="customer">ลูกค้า</option>
                        <option value="manager">ผู้จัดการ</option>
                        <option value="admin">ผู้ดูแล</option>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">เพิ่มผู้ใช้</button>
            </form>

            <!-- ฟอร์มลบผู้ใช้ -->
            <form method="POST" action="" class="mt-4">
                <h4>ลบผู้ใช้</h4>
                <div class="form-group">
                    <label for="delete_username">เลือกชื่อผู้ใช้ที่ต้องการลบ:</label>
                    <select class="form-control" id="delete_username" name="delete_username" required>
                        <option value="">-- เลือกผู้ใช้ --</option>
                        <?php
                        $sql = "SELECT username FROM customers";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['username']) . '">' . htmlspecialchars($row['username']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="delete_user" class="btn btn-danger">ลบผู้ใช้</button>
            </form>

            <!-- แสดงข้อมูลสมาชิก -->
            <h4 class="mt-4">ข้อมูลสมาชิก</h4>
            <?php
            $sql = "SELECT * FROM customers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead><tr>
                        <th>ชื่อผู้ใช้</th>
                        <th>ชื่อจริง</th>
                        <th>นามสกุล</th>
                        <th>เพศ</th>
                        <th>อายุ</th>
                        <th>จังหวัด</th>
                        <th>อีเมล</th>
                        <th>บทบาท</th>
                        <th>แก้ไข</th>
                    </tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['age']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['province']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                    echo '<td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-username="' . htmlspecialchars($row['username']) . '" data-firstname="' . htmlspecialchars($row['first_name']) . '" data-lastname="' . htmlspecialchars($row['last_name']) . '" data-gender="' . htmlspecialchars($row['gender']) . '" data-age="' . htmlspecialchars($row['age']) . '" data-province="' . htmlspecialchars($row['province']) . '" data-email="' . htmlspecialchars($row['email']) . '" data-role="' . htmlspecialchars($row['role']) . '">แก้ไข</button></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p>ไม่มีข้อมูลสมาชิก</p>";
            }
            ?>

            <!-- Modal แก้ไขข้อมูลสมาชิก -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลสมาชิก</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="">
                                <input type="hidden" name="username" id="username" value="">
                                <div class="form-group">
                                    <label for="first_name">ชื่อจริง:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">นามสกุล:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">เพศ:</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="Male">ชาย</option>
                                        <option value="Female">หญิง</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="age">อายุ:</label>
                                    <input type="number" class="form-control" id="age" name="age" required>
                                </div>
                                <div class="form-group">
                                    <label for="province">จังหวัด:</label>
                                    <input type="text" class="form-control" id="province" name="province" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">อีเมล:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">บทบาท:</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="customer">ลูกค้า</option>
                                        <option value="manager">ผู้จัดการ</option>
                                        <option value="admin">ผู้ดูแล</option>
                                    </select>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <a href="?logout=true" class="btn btn-danger mt-4">ออกจากระบบ</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var username = button.data('username');
            var firstname = button.data('firstname');
            var lastname = button.data('lastname');
            var gender = button.data('gender');
            var age = button.data('age');
            var province = button.data('province');
            var email = button.data('email');
            var role = button.data('role');

            var modal = $(this);
            modal.find('#username').val(username);
            modal.find('#first_name').val(firstname);
            modal.find('#last_name').val(lastname);
            modal.find('#gender').val(gender);
            modal.find('#age').val(age);
            modal.find('#province').val(province);
            modal.find('#email').val(email);
            modal.find('#role').val(role);
        });
    </script>
</body>

</html>
