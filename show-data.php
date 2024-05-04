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

            #login {
                display: none !important;
            }
        }

        #font {
            font-weight: 400;
        }
    </style>
</head>

<body>
    <?php
    // เรียกใช้ไฟล์ menu.php
    include "menu.php";
    require 'db.php';
    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';
    ?>
    <div class="menushow">
        <?php
        if (
            isset($_GET['zip_code']) &&
            isset($_GET['id_card']) &&
            isset($_GET['prefix_id']) &&
            isset($_GET['lastname']) &&
            isset($_GET['name']) &&
            isset($_GET['date']) &&
            isset($_GET['age']) &&
            isset($_GET['sex']) &&
            isset($_GET['status']) &&
            isset($_GET['occupation']) &&
            isset($_GET['disease']) &&
            isset($_GET['place']) &&
            isset($_GET['handicap']) &&
            isset($_GET['tel']) &&
            isset($_GET['home_id']) &&
            isset($_GET['home_no']) &&
            isset($_GET['swine']) &&
            isset($_GET['amphure']) &&
            isset($_GET['district']) &&
            isset($_GET['province_id'])
            // isset($_GET['m_rank']) &&
            // isset($_GET['stay']) && 
            // isset($_GET['id'])
        ) {
            $zip_code = $_GET['zip_code'];
            $id_card = $_GET['id_card'];
            $prefix_id = $_GET['prefix_id'];
            $lastname = $_GET['lastname'];
            $name = $_GET['name'];
            $date = $_GET['date'];
            $age = $_GET['age'];
            $sex = $_GET['sex'];
            $status = $_GET['status'];
            $occupation = $_GET['occupation'];
            $disease = $_GET['disease'];
            $place = $_GET['place'];
            $handicap = $_GET['handicap'];
            $tel = $_GET['tel'];
            $home_id = $_GET['home_id'];
            $home_no = $_GET['home_no'];
            $swine = $_GET['swine'];
            $amphure = $_GET['amphure'];
            $district = $_GET['district'];
            $province_id = $_GET['province_id'];
        ?>
            <p style="font-size: 13pt;">ข้อมูล</p>
            <table class="table">
                <tbody>
                    <tr>
                        <td style="width: 20%;" class="table-light">รหัสบัตรประชาชน:</td>
                        <td style="width: 10%;">
                            <p id='font'> <?php echo $id_card ?></p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-light">คำนำหน้า:</td>
                        <td>
                            <p id='font'> <?php echo $prefix_id ?></p>
                        </td>
                        <td class="table-light">ชื่อ:</td>
                        <td>
                            <p id='font'> <?php echo $name ?></p>
                        </td>
                        <td class="table-light">นามสกุล:</td>
                        <td>
                            <p id='font'> <?php echo $lastname ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-light">วัน-เดือน-ปีเกิด:</td>
                        <td>
                            <p id='font'> <?php echo $date ?></p>
                        </td>
                        <td class="table-light">อายุ:</td>
                        <td>
                            <p id='font'> <?php echo $age ?></p>
                        </td>
                        <td class="table-light">เพศ:</td>
                        <td>
                            <p id='font'> <?php echo $sex ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-light">เบอร์โทร:</td>
                        <td>
                            <p id='font'> <?php echo $tel ?></p>
                        </td>
                        <td class="table-light">สถานะ:</td>
                        <td>
                            <p id='font'> <?php echo $status ?></p>
                        </td>
                        <td class="table-light">อาชีพ:</td>
                        <td>
                            <p id='font'> <?php echo $occupation ?></p>
                        </td>

                    </tr>
                    <tr>
                        <td class="table-light">โรคประจำตัว:</td>
                        <td>
                            <p id='font'> <?php echo $disease ?></p>
                        </td>
                        <td class="table-light">กลุ่มเปราะบาง:</td>
                        <td>
                            <p id='font'>
                                <?php
                                if ( $handicap == 'Yes') {
                                    echo 'ใช่';
                                }
                                else if ( $handicap == 'No') {
                                    echo 'ไม่ใช่';
                                } else {
                                    echo $handicap;
                                }; ?>
                            </p>
                        </td>
                        <td class="table-light">สถานที่รับยา:</td>
                        <td>
                            <p id='font'> <?php echo $place ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p style="font-size: 13pt;">ที่อยู่ปัจจุบัน</p>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="table-light">บ้านเลขที่:</td>
                        <td>
                            <p id='font'> <?php echo $province_id ?></p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-light">หมู่:</td>
                        <td>
                            <p id='font'> <?php echo $swine ?></p>
                        </td>
                        <td class="table-light">จังหวัด:</td>
                        <td>
                            <p id='font'> <?php echo $province_id ?></p>
                        </td>
                        <td class="table-light">อำเภอ:</td>
                        <td>
                            <p id='font'> <?php echo $amphure ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-light">ตำบล:</td>
                        <td>
                            <p id='font'> <?php echo $district ?></p>
                        </td>
                        <td class="table-light">รหัสไปรษณีย์:</td>
                        <td>
                            <p id='font'> <?php echo $zip_code ?></p>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <center>
                <button onclick="window.print()" class="btn btn-primary print-button">พิมพ์</button>
                <a href="data.php" class="btn btn-danger print-button">ย้อนกลับ</a>
                <br><br>
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