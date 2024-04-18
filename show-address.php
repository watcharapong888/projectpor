<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูล</title>

    <style>
        @media print {
            .print-button {
                display: none !important;
            }

            .btn-login {
                display: none !important;
            }
        }

        .menushow {
            width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <?php
    // เรียกใช้ไฟล์ menu.php
    include "menu.php";
    ?>
    <div class="menushow">
        <?php
        // ตรวจสอบว่ามีค่า home_id และ home_no ที่ส่งมาจาก URL หรือไม่
        if (isset($_GET['home_id']) && isset($_GET['home_no']) && isset($_GET['swine']) && isset($_GET['aph']) && isset($_GET['di']) && isset($_GET['pro']) && isset($_GET['home_type'])) {
            // ถ้ามีค่า ให้กำหนดค่าให้กับตัวแปร $home_id และ $home_no
            $home_id = $_GET['home_id'];
            $home_no = $_GET['home_no'];
            $swine = $_GET['swine'];
            $aph = $_GET['aph'];
            $di = $_GET['di'];
            $pro = $_GET['pro'];
            $home_type = $_GET['home_type'];

            // แสดงค่าที่ถูกส่งมาจาก URL
            echo "<h1>แสดงข้อมูล</h1>";
            echo "<h4>รหัสบ้าน: $home_id </h4>";
            echo "<h4>เลขที่บ้าน: $home_no </h4>";
            echo "<h4>หมู่: $swine </h4>";
            echo "<h4>ตำบล: $aph </h4>";
            echo "<h4>อำเภอ: $di </h4>";
            echo "<h4>จังหวัด: $pro </h4>";
            echo "<h4>ประเภทบ้าน: $home_type </h4>";
        ?><br>
            <center>
                <button onclick="window.print()" class="btn btn-primary print-button">พิมพ์</button>
                <a href="address.php" class="btn btn-danger print-button">ย้อนกลับ</a>
            </center>
        <?php
        } else {
            // หากไม่มีค่าที่ส่งมา ให้แสดงข้อความว่าไม่พบข้อมูล
            echo "ไม่พบข้อมูล";
        }
        ?>
    </div>
</body>

</html>