<?php
session_start(); // เริ่มต้นเซสชัน
session_unset(); // ลบข้อมูลในเซสชัน
session_destroy(); // ทำลายเซสชัน

// เปลี่ยนเส้นทางไปยังหน้า index หรือหน้าเข้าสู่ระบบ
header("Location: index.php"); 
exit();
?>
