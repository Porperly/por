<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost"; // ปรับตามความเหมาะสม
$username = "root"; // ปรับตามความเหมาะสม
$password = ""; // ปรับตามความเหมาะสม
$dbname = "dbhw9"; // ชื่อตามฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    // ตรวจสอบการยืนยันรหัสผ่าน
    if ($password !== $confirmPassword) {
        echo "รหัสผ่านไม่ตรงกัน";
        exit();
    }

    // ตรวจสอบอีเมลซ้ำ
    $email_check_query = "SELECT * FROM customers WHERE email = ?";
    $stmt = $conn->prepare($email_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "อีเมลนี้ถูกใช้ไปแล้ว";
        exit();
    }

    // แฮชรหัสผ่านก่อนบันทึกลงฐานข้อมูล
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO customers (username, password, first_name, last_name, gender, age, province, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiis", $username, $hashed_password, $first_name, $last_name, $gender, $age, $province, $email);

    // ตรวจสอบการเพิ่มข้อมูล
    if ($stmt->execute()) {
        echo "<script>alert('ลงทะเบียนสำเร็จ!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Travel-Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
<body>
    <div class="menu">
        <a href="index.php">
            <i class="fas fa-home"></i>
            Home
        </a>
    </div>
        <div class="container">
            <h1>Register</h1>
            <form action="regis.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required><br>

                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" required><br>

                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" required><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">--Select Gender--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br>

                <label for="age">Age:</label>
                <input type="text" id="age" name="age" required><br>

                <label for="province">Province:</label>
                <select id="province" name="province" required><br>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="กระบี่">กระบี่</option>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="ชลบุรี">ชลบุรี</option>
                    <option value="เชียงใหม่">เชียงใหม่</option>
                    <option value="เชียงราย">เชียงราย</option>
                    <option value="ตรัง">ตรัง</option>
                    <option value="นครราชสีมา">นครราชสีมา</option>
                    <option value="นครปฐม">นครปฐม</option>
                    <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                    <option value="นราธิวาส">นราธิวาส</option>
                    <option value="น่าน">น่าน</option>
                    <option value="ปทุมธานี">ปทุมธานี</option>
                    <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
                    <option value="บุรีรัมย์">บุรีรัมย์</option>
                    <option value="ปัตตานี">ปัตตานี</option>
                    <option value="พะเยา">พะเยา</option>
                    <option value="พังงา">พังงา</option>
                    <option value="ภูเก็ต">ภูเก็ต</option>
                    <option value="มหาสารคาม">มหาสารคาม</option>
                    <option value="มุกดาหาร">มุกดาหาร</option>
                    <option value="ยโสธร">ยโสธร</option>
                    <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                    <option value="ลพบุรี">ลพบุรี</option>
                    <option value="ลำปาง">ลำปาง</option>
                    <option value="ลำพูน">ลำพูน</option>
                    <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                    <option value="สกลนคร">สกลนคร</option>
                    <option value="สงขลา">สงขลา</option>
                    <option value="สุโขทัย">สุโขทัย</option>
                    <option value="สุพรรณบุรี">สุพรรณบุรี</option>
                    <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                    <option value="อุดรธานี">อุดรธานี</option>
                    <option value="อุตรดิตถ์">อุตรดิตถ์</option>
                    <option value="อุบลราชธานี">อุบลราชธานี</option>
                    <option value="เชียงราย">เชียงราย</option>
                    <option value="นครสวรรค์">นครสวรรค์</option>
                    <option value="เพชรบุรี">เพชรบุรี</option>
                    <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                    <option value="สมุทรปราการ">สมุทรปราการ</option>
                    <option value="สมุทรสงคราม">สมุทรสงคราม</option>
                    <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
                    <option value="สระแก้ว">สระแก้ว</option>
                    <option value="สระบุรี">สระบุรี</option>
                    <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                    <option value="ระนอง">ระนอง</option>
                    <option value="ระยอง">ระยอง</option>
                    <option value="อุทัยธานี">อุทัยธานี</option>
                    <option value="ยะลา">ยะลา</option>
                    <option value="มุกดาหาร">มุกดาหาร</option>
                    <option value="หนองคาย">หนองคาย</option>
                    <option value="หนองบัวลำภู">หนองบัวลำภู</option>
                    <option value="บึงกาฬ">บึงกาฬ</option>
                    <option value="ชัยภูมิ">ชัยภูมิ</option>
                    <option value="อ่างทอง">อ่างทอง</option>
                    <option value="อยุธยา">อยุธยา</option>
                    <option value="พิจิตร">พิจิตร</option>
                    <option value="นครพนม">นครพนม</option>
                    <option value="สิงห์บุรี">สิงห์บุรี</option>
                    <option value="พะเยา">พะเยา</option>
                    <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                    <option value="มุกดาหาร">มุกดาหาร</option>
                    <option value="สุโขทัย">สุโขทัย</option>
                    <option value="ตราด">ตราด</option>
                    <option value="กำแพงเพชร">กำแพงเพชร</option>
                </select><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <button type="submit" class="register-button">Register</button>
            </form>
            <div class="signin-link">
                คุณมีบัญชีแล้ว?<a href="login.php"> Login</a>
    </body>

</html>