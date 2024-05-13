<?php include 'menu.php';
if (@$_SESSION['user_name'] == null || @$_SESSION['user_name'] == '') {
    echo '<script>
  setTimeout(function() {
   swal({
       title: "แจ้งเตือน!",
        text: "คุณไม่มีสิทธิ์เข้าถึง กรุณาเข้าสู่ระบบแล้วลองอีกครั้ง",
       type: "warning"
   }, function() {
       window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
   });
 }, 1000);
</script>';
    $conn = null;
} else {

    if (@$_GET['act'] === 'clear') {
        unset($_POST);
    }
    ?>
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
        <?php
        require_once 'db.php';
        // print_r($_POST);
        @$disease = $_POST['disease'];
        @$age = $_POST['age'];
        @$handicap = $_POST['handicap'];
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
                    <form action="list.php" method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="handicap" class="form-label">เลือกกลุ่มเปราะบาง:</label>
                                <select id="handicap" name="handicap" class="form-select">
                                    <?php
                                    if ($handicap == 'all' && $handicap != '') {
                                        echo '<option value="all">ทั้งหมด</option>';
                                    }
                                    if ($handicap == 'Yes' && $handicap != '') {
                                        echo '<option value="Yes">กลุ่มเปราะบาง</option>';
                                    }
                                    if ($handicap == 'No' && $handicap != '') {
                                        echo '<option value="No">ไม่อยู่ในกลุ่มเปราะบาง</option>';
                                    }
                                    ?>
                                    <option value="all">ทั้งหมด</option>
                                    <option value="Yes">กลุ่มเปราะบาง</option>
                                    <option value="No">ไม่อยู่ในกลุ่มเปราะบาง</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="age" class="form-label">เลือกกลุ่มอายุ:</label>
                                <select id="age" name="age" class="form-select">
                                    <?php
                                    if ($age == 'all' && $age != '') {
                                        echo '<option value="all">ทั้งหมด</option>';
                                    }
                                    if ($age == '0-20' && $age != '') {
                                        echo '<option value="0-20">0-20 ปี</option>';
                                    }
                                    if ($age == '21-40' && $age != '') {
                                        echo '<option value="21-40">21-40 ปี</option>';
                                    }
                                    if ($age == '41-60' && $age != '') {
                                        echo ' <option value="41-60">41-60 ปี</option>';
                                    }
                                    if ($age == '61+' && $age != '') {
                                        echo '<option value="61+">61 ปีขึ้นไป</option>';
                                    }
                                    ?>
                                    <option value="all">ทั้งหมด</option>
                                    <option value="0-2">วัยทารก(0-2ปี)</option>
                                    <option value="3-12">วัยเด็ก(3-12ปี)</option>
                                    <option value="13-19">วัยรุ่น(13-19ปี)</option>
                                    <option value="20-60">วัยผู้ใหญ่(20-60ปี)</option>
                                    <option value="61+">วัยชรา(61ปีขึ้นไป)</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="disease" class="form-label">เลือกกลุ่มโรคประจำตัว:</label>
                                <select id="disease" name="disease" class="form-select">
                                    <?php
                                    if ($disease == 'all' && $disease != '') {
                                        echo '<option value="all">ทั้งหมด</option>';
                                    }
                                    if ($disease != 'all' && $disease != '') {
                                        echo '<option>' . @$disease . '</option>';
                                    }
                                    ?>
                                    <option value="all">ทั้งหมด</option>
                                    <option>ไม่มีโรคประจำตัว</option>
                                    <option>โรคเบาหวาน</option>
                                    <option>โรคหัวใจ</option>
                                    <option>โรคความดัน</option>
                                    <option>โรคเส้นเลือดตีบ</option>
                                    <option>โรคไต</option>
                                    <option>โรครูมาตอยด์</option>
                                    <option>โรคมะเร็งเต้านม</option>
                                    <option>โรคมะเร็งตับ</option>
                                    <option>โรคมะเร็งลำไส้</option>
                                    <option>โรคมะเร็งกล่องเสียง</option>
                                    <option>ภาวะธาตุเหล็กเกิน</option>
                                    <option>SLE</option>
                                    <option>โรคหอบหืด</option>
                                    <option>โรคหัวใจโต</option>
                                    <option>โรคโลหิตจาง</option>
                                    <option>โรคไขมันในเลือดสูง</option>
                                    <option>โรคไทรอยด์</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <center>
                                    <button type="submit" class="btn btn-primary">คันหา</button>
                                    <a href="list.php?act=clear" class="btn btn-secondary">ล้างข้อมูล</a>
                                </center>
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
                                    <!-- <th>วันเดือนปีเกิด</th> -->
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
                                        case '0-2':
                                            $ageCondition = "AND $dateDB BETWEEN 0 AND 2";
                                            break;
                                        case '3-12':
                                            $ageCondition = "AND $dateDB BETWEEN 3 AND 12";
                                            break;
                                        case '13-19':
                                            $ageCondition = "AND $dateDB BETWEEN 13 AND 19";
                                            break;
                                        case '20-60':
                                            $ageCondition = "AND $dateDB BETWEEN 20 AND 60";
                                            break;
                                        case '61+':
                                            $ageCondition = "AND $dateDB >= 61";
                                            break;
                                    }
                                }
                                $diseaseCondition = $selectedChronicDisease !== 'all' ? "AND disease_id like'%$selectedChronicDisease%'" : "";
                                $stmt = $conn->prepare(
                                    "SELECT 
                                id, 
                                pr.prefix_id,
                                pr.prefix as prefix,
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
                                us.user_name as user_name,
                                us.user_lname as user_lname,
                                id_card,
                                zip_code
                                FROM data as dt 
                                JOIN 
                                prefix AS pr ON dt.prefix_id = pr.prefix_id
                                JOIN 
                                occupation AS o ON dt.occupation_id = o.occupation_id
                                JOIN 
                                provinces AS pro ON dt.province_id = pro.province_id 
                                JOIN 
                                user AS us ON dt.user_id = us.user_id 
                                WHERE 1 = 1
                                order by id_card
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
                                            <td><?php echo $row['age']; ?></td>
                                            <td><?php echo $row['disease']; ?></td>
                                            <td><?php echo $row['handicap']; ?></td>
                                            <td><?php echo $row['tel']; ?></td>
                                            <td>
                                                <a href="show-data.php?user_name=<?php echo $row['user_name']; ?>&user_lname=<?php echo $row['user_lname']; ?>&zip_code=<?php echo $row['zip_code']; ?>&id_card=<?php echo $row['id_card']; ?>&prefix_id=<?php echo $row['prefix']; ?>&lastname=<?php echo $row['lastname']; ?>&name=<?php echo $row['name']; ?>&date=<?php echo $row['date']; ?>&age=<?php echo $row['age']; ?>&sex=<?php echo $row['sex']; ?>&status=<?php echo $row['status']; ?>&occupation=<?php echo $row['occupation']; ?>&disease=<?php echo $row['disease']; ?>&place=<?php echo $row['place']; ?>&handicap=<?php echo $row['handicap']; ?>&tel=<?php echo $row['tel']; ?>&status=<?php echo $row['status']; ?>&home_id=<?php echo $row['home_id']; ?>&home_no=<?php echo $row['home_no']; ?>&swine=<?php echo $row['swine']; ?>&amphure=<?php echo $row['amphure']; ?>&district=<?php echo $row['district']; ?>&province_id=<?php echo $row['pro']; ?>"
                                                    class="btn btn-success print-button">
                                                    <span class="material-symbols-outlined">
                                                        description
                                                    </span>
                                                </a>
                                            </td>
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
                    const {
                        jsPDF
                    } = window.jspdf;
                    if (typeof jsPDF !== 'undefined') {
                        // ซ่อนองค์ประกอบที่มีคลาส .print-button
                        var printButtons = document.querySelectorAll('.print-button');
                        printButtons.forEach(function (button) {
                            button.style.display = 'none';
                        });

                        // ซ่อนองค์ประกอบที่มี id เป็น "login"
                        var loginElement = document.getElementById('login');
                        if (loginElement) {
                            loginElement.style.display = 'none';
                        }

                        const table = document.getElementById("myTable");
                        html2canvas(table, {
                            scale: 1
                        }).then(canvas => {
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
                            location.reload();
                        });
                        // เช็คหากใช้ jspdf ในการสร้าง PDF

                    }
                }

                document.getElementById("printButton").addEventListener("click", printTableToPDF);
            });
        </script>
    </body>

    </html>
<?php } ?>