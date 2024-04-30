<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลคนในชุมชน</title>
    <style>
        th, td {
            font-size: 9pt;
        }

        input[type=search], select {
            width: 200px;
            height: 40px;
            margin-bottom: 8px;
            border: 1px black solid;
            border-radius: 5px;
            padding: 15px;
        }

        .btn, button {
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
            .print-section, .print-section * {
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
    <?php include 'menu.php'; require_once 'db.php'; ?>
    <div class="container mt-3">
        <h3><p>ข้อมูลกลุ่มเปราะบาง</p></h3>
       
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
            <label for="ageGroup" class="form-label">เลือกกลุ่มอายุ:</label>
            <select id="ageGroup" name="ageGroup" class="form-select">
                <option value="all">ทั้งหมด</option>
                <option value="0-20">0-20 ปี</option>
                <option value="21-40">21-40 ปี</option>
                <option value="41-60">41-60 ปี</option>
                <option value="61+">61 ปีขึ้นไป</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="chronicDisease" class="form-label">เลือกกลุ่มโรคประจำตัว:</label>
            <select id="chronicDisease" name="chronicDisease" class="form-select">
            <option value="all">ทั้งหมด</option>
        <option value="ไม่มีโรคประจำตัว">ไม่มีโรคประจำตัว</option>
        <option value="โรคเบาหวาน">โรคเบาหวาน</option>
        <option value="โรคหัวใจ">โรคหัวใจ</option>
        <option value="โรคความดัน">โรคความดัน</option>
        <option value="โรคเส้นเลือดตีบ">โรคเส้นเลือดตีบ</option>
        <option value="โรคไต">โรคไต</option>
        <option value="โรครูมาตอยด์">โรครูมาตอยด์</option>
        <option value="โรคมะเร็งเต้านม">โรคมะเร็งเต้านม</option>
        <option value="โรคมะเร็งตับ">โรคมะเร็งตับ</option>
        <option value="โรคมะเร็งลำไส้">โรคมะเร็งลำไส้</option>
        <option value="โรคมะเร็งกล่องเสียง">โรคมะเร็งกล่องเสียง</option>
        <option value="ภาวะธาตุเหล็กเกิน">ภาวะธาตุเหล็กเกิน</option>
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
$selectedHandicap = $_POST['handicap'] ?? 'ทั้งหมด';
$selectedAgeGroup = $_POST['ageGroup'] ?? 'all';
$selectedChronicDisease = $_POST['chronicDisease'] ?? 'all';

$handicapCondition = $selectedHandicap !== 'ทั้งหมด' ? "AND handicap = '$selectedHandicap'" : "";
$ageCondition = "";
if ($selectedAgeGroup != 'all') {
    switch ($selectedAgeGroup) {
        case '0-20':
            $ageCondition = "AND TIMESTAMPDIFF(YEAR, date, CURDATE()) BETWEEN 0 AND 20";
            break;
        case '21-40':
            $ageCondition = "AND TIMESTAMPDIFF(YEAR, date, CURDATE()) BETWEEN 21 AND 40";
            break;
        case '41-60':
            $ageCondition = "AND TIMESTAMPDIFF(YEAR, date, CURDATE()) BETWEEN 41 AND 60";
            break;
        case '61+':
            $ageCondition = "AND TIMESTAMPDIFF(YEAR, date, CURDATE()) >= 61";
            break;
    }
}

$diseaseCondition = $selectedChronicDisease !== 'all' ? "AND ds.disease = '$selectedChronicDisease'" : "";

$sql = "SELECT 
    dt.id, 
    CONCAT(pr.prefix, ' ', dt.name, ' ', dt.lastname) AS full_name,
    dt.date,
    TIMESTAMPDIFF(YEAR, dt.date, CURDATE()) AS age,
    dt.sex, 
    dt.handicap,
    ds.disease,
    dt.tel,
    dt.id_card,
    dt.status,
o.occupation,
dt.place
FROM data as dt 
JOIN prefix AS pr ON dt.prefix_id = pr.prefix_id
JOIN disease AS ds ON dt.disease_id = ds.disease_id
JOIN occupation AS o ON dt.occupation_id = o.occupation_id
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
                    <th>#</th>
                <th>รหัสบัตรประชาชน</th>
                <th>ชื่อ</th>
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
                    if ($result) {
                        $i = 1;
                        foreach ($result as $row) {
                            echo "<tr>
                            <td>{$i}</td>
                                    <td>{$row['id_card']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['age']}</td>
                                    <td>{$row['sex']}</td>
                                    <td>{$row['status']}</td>
                                    <td>{$row['occupation']}</td>
                                    <td>{$row['disease']}</td>
                                    <td>{$row['handicap']}</td>
                                    <td>{$row['place']}</td>
                                    <td>{$row['tel']}</td>
                                  </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align: center;'>ไม่มีข้อมูล</td></tr>";
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
