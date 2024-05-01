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
            /* background-color: aqua; */
            margin-left: auto;
            margin-right: auto;
        }

        iframe {
            width: 97%;
            height: 205px;
        }

        #re {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .location {
            width: 30%;
        }
    </style>
</head>

<body>
    <?php
    // เรียกใช้ไฟล์ menu.php
    include "menu.php";
    require 'db.php';
    ?>
    <div class="menushow">
        <?php
        // ตรวจสอบว่ามีค่า home_id และ home_no ที่ส่งมาจาก URL หรือไม่
        if (isset($_GET['home_id']) && isset($_GET['id_home']) && isset($_GET['home_no']) && isset($_GET['swine']) && isset($_GET['aph']) && isset($_GET['di']) && isset($_GET['pro']) && isset($_GET['location'])&& isset($_GET['zip_code']) && isset($_GET['home_type'])) {
            // ถ้ามีค่า ให้กำหนดค่าให้กับตัวแปร $home_id และ $home_no
            $home_id = $_GET['home_id'];
            $id_home = $_GET['id_home'];
            $home_no = $_GET['home_no'];
            $swine = $_GET['swine'];
            $aph = $_GET['aph'];
            $di = $_GET['di'];
            $pro = $_GET['pro'];
            $location = $_GET['location'];
            $zip_code = $_GET['zip_code'];
            $home_type = $_GET['home_type'];
        ?>
            <p style="font-size: 15pt;">ข้อมูลครัวเรือน</p>
            <div id="re">
                <div style="width: 70%;">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="table-light">รหัสบ้าน:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $id_home ?></p>
                                </td>
                                <td class="table-light">เลขที่บ้าน:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $home_no ?></p>
                                </td>
                                <!-- <td>สมาชิกในครัวเรือน</td> -->
                            </tr>
                            <tr>
                                <td class="table-light">หมู่:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $swine ?></p>
                                </td>
                                <td class="table-light">ตำบล:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $aph ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td  class="table-light">อำเภอ:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $di ?></p>
                                </td>
                                <td class="table-light">จังหวัด:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $pro ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-light">รหัสไปรษณีย์:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $zip_code ?></p>
                                </td>
                                <td class="table-light">ประเภทบ้าน:</td>
                                <td>
                                    <p style="font-weight:400;"> <?php echo $home_type ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="location">
                    <?php echo $location  ?>
                </div>
            </div>
            <p style="font-size: 15pt;">ข้อมูลสมาชิกในครัวเรือน</p>
            <div>
                <table class="table">
                    <thead>
                        <tr class="table-light">
                            <th>รหัสบัตรประชาชน</th>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
              $home_Id = $home_id;
              $stmt = $conn->prepare(
                "SELECT 
                id, 
                pr.prefix as prefix,
                name, 
                lastname,
                home_id,
                id_card
                FROM data as dt 
                JOIN 
                prefix AS pr ON dt.prefix_id = pr.prefix_id
                where 
                home_id = $home_Id
                   "
              );
              $stmt->execute();
              $result = $stmt->fetchAll();

              if ($result != null) {
                $i = 1;
                foreach ($result as $row) {
              ?>
                        <tr>
                            <td>  <p style="font-weight:400;"><?php echo $row['id_card'] ?></p></td>
                            <td>  <p style="font-weight:400;"><?php echo $row['prefix'] ?></p></td>
                            <td>  <p style="font-weight:400;"><?php echo $row['name'] ?></p></td>
                            <td>  <p style="font-weight:400;"><?php echo $row['lastname'] ?></p></td>
                        </tr>
                        <?php $i++;
                }
              } else { ?>
                <tr>
                  <td colspan="11" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                </tr>
              <?php  } ?>
                    </tbody>
                </table>
            </div>
            <center>
                <button onclick="window.print()" class="btn btn-primary print-button">พิมพ์</button>
                <a href="address.php" class="btn btn-danger print-button">ย้อนกลับ</a>
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