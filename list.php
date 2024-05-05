<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <title>ข้อมูลคนในชุมชน</title>
</head>
<style>
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

    .required-star {
        color: red;
        /* กำหนดสีของดาว */
    }
</style>

<body>
    <?php include 'menu.php';
    require_once 'db.php';
    ?>
    <br>
    <div class="showall">
        <div class="show">
            <div class="container mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <p>รายชื่อคนในชุมชน</p>
                        </h3>
                    </div>
                </div>
                <br>
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
                            <label for="disease" class="form-label">เลือกกลุ่มโรคประจำตัว:</label>
                            <select id="disease" name="disease" class="form-select">
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
            </div>

            <div class="container mt-3">
                <div class="table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr class="table-success">
                                <th>#</th>
                                <th>รหัสบัตรประชาชน</th>
                                <th>ชื่อ</th>
                                <th>วันเดือนปีเกิด</th>
                                <th>อายุ</th>
                                <th>โรคประจำตัว</th>
                                <th>กลุ่มเปราะบาง</th>
                                <th>เบอร์โทร</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $selectedHandicap = $_POST['handicap'] ?? 'all';
                            $selectedAgeGroup = $_POST['age'] ?? 'all';
                            $selectedChronicDisease = $_POST['disease'] ?? 'all';
                            $handicapCondition = $selectedHandicap !== 'all' ? "AND handicap = '$selectedHandicap'" : "";
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
                            $diseaseCondition = $selectedChronicDisease !== 'all' ? "AND disease = '$selectedChronicDisease'" : "";
                            $stmt = $conn->prepare(
                                "SELECT 
                                id, 
                                pr.prefix_id,
                                Concat(pr.prefix,' ',name,' ',lastname)as fullname,
                                name, 
                                lastname,  
                                date,
                                TIMESTAMPDIFF(YEAR, date, CURDATE()) AS age,
                                sex, 
                                status, 
                                o.occupation_id,
                                o.occupation as occupation, 
                                dt.disease_id as disease, 
                                place, 
                                handicap, 
                                tel, 
                                home_id, 
                                home_no, 
                                swine, 
                                district,
                                amphure ,
                                pro.province_id,
                                pro.name_th as pro, 
                                m_rank, 
                                stay, 
                                id_card,
                                zip_code
                                FROM data as dt 
                                JOIN 
                                prefix AS pr ON dt.prefix_id = pr.prefix_id
                                JOIN 
                                occupation AS o ON dt.occupation_id = o.occupation_id
                                JOIN 
                                provinces AS pro ON dt.province_id = pro.province_id 
                WHERE 1 = 1
$handicapCondition
$ageCondition
$diseaseCondition
                   "
                            );
                            $stmt->execute();
                            $result = $stmt->fetchAll();

                            if ($result != null) {
                                $i = 1;
                                foreach ($result as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php
                                        $id_card = $row['id_card'];
                                        if (strlen($id_card) >= 3) {
                                            $masked_id = substr($id_card, 0, -3) . 'XXX';
                                            if (strlen($masked_id) == 13) {
                                                $display_id_card = substr($masked_id, 0, 1) . '-' .
                                                    substr($masked_id, 1, 4) . '-' .
                                                    substr($masked_id, 5, 5) . '-' .
                                                    substr($masked_id, 10, 3);
                                            } else {
                                                $display_id_card = $masked_id;
                                            }
                                        } else {
                                            $display_id_card = str_repeat('*', strlen($id_card));
                                        }
                                        echo $display_id_card ?></td>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <?php
                                        if (!function_exists('DateThai')) {
                                            function DateThai($strDate)
                                            {
                                                $strDay = date("j", strtotime($strDate));
                                                $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                                                $strMonthThai = $strMonthCut[date("n", strtotime($strDate))];
                                                $strYearThai = date("Y", strtotime($strDate)) + 543;
                                                return "$strDay $strMonthThai $strYearThai";
                                            }
                                        }
                                        $strDate = $row['date'];
                                        echo '<td>' . DateThai($strDate) . '</td>';
                                        ?>
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo $row['disease']; ?></td>
                                        <td><?php echo $row['handicap']; ?></td>
                                        <td><?php echo $row['tel']; ?></td>
                                        <td><a href="show-data.php?id_card=<?php echo $id_card; ?>"
                                                class="btn btn-success">ดูข้อมูล</a></td>
                                    </tr>
                                    <?php $i++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="16" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><button id="printButton" class="btn btn-primary">พิมพ์ตารางเป็น PDF</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        document.addEventListener('DOMContentLoaded', function () {
            function printTableToPDF() {
                const { jsPDF } = window.jspdf;
                const table = document.getElementById("myTable");
                html2canvas(table, { scale: 1 }).then(canvas => {
                    const imgData = canvas.toDataURL('image/jpeg');
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'pt',
                        format: 'a4'
                    });
                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const pageHeight = pdf.internal.pageSize.getHeight();
                    const ratio = pageWidth / canvas.width;
                    const canvasHeight = canvas.height * ratio;
                    if (canvasHeight > pageHeight) {
                        pdf.addImage(imgData, 'JPEG', 0, 0, pageWidth, pageHeight);
                    } else {
                        pdf.addImage(imgData, 'JPEG', 0, 0, pageWidth, canvasHeight);
                    }

                    pdf.save('ข้อมูลคนในชุมชน.pdf');
                });
            }

            document.getElementById("printButton").addEventListener("click", printTableToPDF);
        });

    </script>
</body>

</html>