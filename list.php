<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลคนในชุมชน</title>
    <style>
        th,
        td {
            font-size: 9pt;
        }

        #ff {
            font-size: 5.5pt;
        }

        input[type=search] {
            width: 200px;
            height: 40px;
            margin-bottom: 8px;
            border: 1px black solid;
            border-radius: 5px;
            padding: 15px;
        }

        #re {
            display: flex;
            flex-wrap: wrap;
        }

        #re>div {
            margin-right: 10px;
        }


        @media print {

            @page {
                size: landscape;
            }

            body * {
                visibility: hidden;
                /* ซ่อนเนื้อหาอื่นบนหน้าเว็บเมื่อพิมพ์ */
            }

            .print-section,
            .print-section * {
                visibility: visible;
                /* แสดงเฉพาะส่วนที่ต้องการพิมพ์ */
            }

            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                /* กำหนดความกว้างเต็มหน้ากระดาษ */
                margin: 0;
                padding: 15px;
                /* ตั้งค่าระยะขอบในการพิมพ์ */
                font-size: 14px;
                /* ตั้งขนาดตัวอักษร */
            }
        }
    </style>
</head>

<body>
    <?php include 'menu.php';
    require_once 'db.php'; ?>
    <div class="container mt-3">
        <h3>
            <p>รายชื่อทั้งหมดคนในชุมชน</p>
        </h3>
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="handicap" class="form-label">เลือกกลุ่มเปราะบาง:</label>
                    <select id="handicap" name="handicap" class="form-select">
                        <option value="all">ทั้งหมด</option>
                        <option value="Yes">กลุ่มเปราะบาง</option>
                        <option value="No">ไม่อยู่ในกลุ่มเปราะบาง</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">เลือกกลุ่มอายุ:</label>
                    <select id="age" name="age" class="form-select">
                        <option value="all">ทั้งหมด</option>
                        <option value="0-20">0-20 ปี</option>
                        <option value="21-40">21-40 ปี</option>
                        <option value="41-60">41-60 ปี</option>
                        <option value="61+">61 ปีขึ้นไป</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="disease_id" class="form-label">เลือกกลุ่มโรคประจำตัว:</label>
                    <select id="disease_id" name="disease_id" class="form-select">
                        <option value="all">ทั้งหมด</option>
                        <option value="12">ไม่มีโรคประจำตัว</option>
                        <option value="1">โรคเบาหวาน</option>
                        <option value="2">โรคหัวใจ</option>
                        <option value="3">โรคความดัน</option>
                        <option value="4">โรคเส้นเลือดตีบ</option>
                        <option value="5">โรคไต</option>
                        <option value="6">โรครูมาตอยด์</option>
                        <option value="7">โรคมะเร็งเต้านม</option>
                        <option value="9">โรคมะเร็งตับ</option>
                        <option value="8">โรคมะเร็งลำไส้</option>
                        <option value="10">โรคมะเร็งกล่องเสียง</option>
                        <option value="11">ภาวะธาตุเหล็กเกิน</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">แสดงผล</button>
                </div>
            </div>
        </form>
        <br>
        <?php
        // หลังจากที่ผู้ใช้ส่งแบบฟอร์ม
        $selectedHandicap = $_POST['handicap'] ?? 'all';
        $selectedAgeGroup = $_POST['age'] ?? 'all';
        $selectedChronicDisease = $_POST['disease_id'] ?? 'all';
        $handicapCondition = $selectedHandicap !== 'all' ? "AND dt.handicap = '$selectedHandicap'" : "";
        $ageCondition = "";
        if ($selectedAgeGroup != 'all') {
            switch ($selectedAgeGroup) {
                case '0-20':
                    $ageCondition = "AND $dateDB BETWEEN 0 AND 20";
                    break;
                case '21-40':
                    $ageCondition = "AND $dateDB BETWEEN 21 AND 40";
                    break;
                case '41-60':
                    $ageCondition = "AND $dateDB BETWEEN 41 AND 60";
                    break;
                case '61+':
                    $ageCondition = "AND $dateDB >= 61";
                    break;
            }
        }
        $diseaseCondition = $selectedChronicDisease !== 'all' ? "AND ds.disease_id = '$selectedChronicDisease'" : "";
        $sql = "SELECT 
id, 
pr.prefix_id,
CONCAT(pr.prefix, ' ', name, ' ', lastname) AS full_name,
date,
$dateDB AS age,
sex, 
status, 
o.occupation_id,
o.occupation as occupation, 
ds.disease_id,
ds.disease as disease, 
place, 
dt.handicap, 
tel, 
home_id, 
home_no, 
swine, 
aph.name_th as aph, 
di.name_th as di, 
pro.name_th as pro, 
m_rank, 
stay, 
id_card
FROM data as dt 
JOIN 
prefix AS pr ON dt.prefix_id = pr.prefix_id
JOIN 
occupation AS o ON dt.occupation_id = o.occupation_id
JOIN 
disease  AS ds ON dt.disease_id = ds.disease_id
JOIN 
amphures AS aph ON dt.amphure_id = aph.amphure_id 
JOIN 
districts AS di ON dt.district_id = di.district_id 
JOIN 
provinces AS pro ON dt.province_id = pro.province_id 
WHERE 1 = 1
$handicapCondition
$ageCondition
$diseaseCondition";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        ?>
        <div class="container mt-3">
            <div class="table-responsive" id="print">
                <table class="table table-striped" id="myTable" >
                    <thead>
                        <tr class="table-success">
                            <th>#</th>
                            <th>รหัสบัตรประชาชน</th>
                            <th>ชื่อ</th>
                            <th>วันเกิด</th>
                            <th>อายุ</th>
                            <th>เพศ</th>
                            <th>สถานะ</th>
                            <th>อาชีพ</th>
                            <th>โรคประจำตัว</th>
                            <th>กลุ่มเปราะบาง</th>
                            <th>สถานที่รับยา</th>
                            <th>เบอร์โทร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        if (!empty($result)) {
                            $i = 1;
                            foreach ($result as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row['id_card']); ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sex']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['occupation']); ?></td>
                                    <td><?php echo htmlspecialchars($row['disease']); ?></td>
                                    <td><?php echo htmlspecialchars($row['handicap']); ?></td>
                                    <td><?php echo htmlspecialchars($row['place']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tel']); ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="17" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
               
            </div>
        </div> <button onclick="printContent('print')" class="btn btn-primary print-button">พิมพ์</button>
    </div>


    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        function printContent(elementId) {
            document.querySelectorAll('.print-section').forEach(el => {
                el.classList.remove('print-section');
            });
            const element = document.getElementById(elementId);
            element.classList.add('print-section');

            window.print(); // เรียกใช้งาน window.print หลังจากตั้งค่าคลาสที่ต้องการ
        }


    </script>
</body>

</html>