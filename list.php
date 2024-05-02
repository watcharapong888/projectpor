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

        input[type=search],
        select {
            width: 200px;
            height: 40px;
            margin-bottom: 8px;
            border: 1px black solid;
            border-radius: 5px;
            padding: 15px;
        }

        .btn,
        button {
            padding: 8px 16px;
            margin-top: 8px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-section,
            .print-section * {
                visibility: visible;
            }

            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
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
                        <option value="ทั้งหมด">ทั้งหมด</option>
                        <option value="ใช่">กลุ่มเปราะบาง</option>
                        <option value="ไม่ใช่">ไม่อยู่ในกลุ่มเปราะบาง</option>
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
        <?php
        // Check if any GET parameters are set
        if (!empty($_GET)) {
            echo "<h3>Received GET Parameters:</h3>";
            foreach ($_GET as $key => $value) {
                echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
            }
        } else {
            echo "No GET parameters received.";
        }
        ?>
        <?php
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if any POST parameters are set
            if (!empty($_POST)) {
                echo "<h3>Received POST Parameters:</h3>";
                foreach ($_POST as $key => $value) {
                    echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
                }
            } else {
                echo "No POST parameters received.";
            }
        }
        ?>
        <br>
        <?php
        // หลังจากที่ผู้ใช้ส่งแบบฟอร์ม
        $selectedHandicap = $_POST['handicap'] ?? 'ทั้งหมด';
        $selectedAgeGroup = $_POST['age'] ?? 'all';
        $selectedChronicDisease = $_POST['disease_id'] ?? 'all';
        $handicapCondition = $selectedHandicap !== 'ทั้งหมด' ? "AND handicap = '$selectedHandicap'" : "";

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
pr.prefix as prefix,
name, 
lastname,  
date,
$dateDB AS age,
sex, 
status, 
o.occupation_id,
o.occupation as occupation, 
ds.disease_id,
ds.disease as disease, 
place, 
handicap, 
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
        <div class="table-responsive">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr class="table-success">
                    <tr class="table-success">
                        <th>#</th>
                        <th>รหัสบัตรประชาชน</th>
                        <th>คำนำหน้า</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>วันเดือนปีเกิด</th>
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
                                <td><?php echo htmlspecialchars($row['prefix']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
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
            <button onclick="printContent('myTable')" class="btn btn-primary print-button">พิมพ์</button>
        </div>
    </div>



    <script>
        function printContent(elementId) {
            // Remove print-section class from all elements
            document.querySelectorAll('.print-section').forEach(el => {
                el.classList.remove('print-section');
            });

            // Add print-section class to the desired container
            const element = document.getElementById(elementId);
            element.classList.add('print-section');

            // Call the browser's print function
            window.print();
        }
    </script>
</body>

</html>