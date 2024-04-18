<?php
session_start(); // เริ่ม session หากยังไม่ได้เริ่ม

// เคลียร์ข้อมูลทั้งหมดใน session
session_unset();

// ทำลาย session โดยสมบูรณ์
session_destroy();

// Redirect ไปยังหน้า login.php หรือหน้าอื่นๆ ตามที่คุณต้องการ
header("Location: login.php");
exit; // จบการทำงานของสคริปต์
?>
