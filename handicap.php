<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ข้อมูลคนในชุมชน</title>
</head>
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
  .required-star {
  color: red;  /* กำหนดสีของดาว */
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
    }
    .print-button {
                display: none !important;
            }
     .btn-login {
                display: none !important;
            }

}
</style>
<body>
  <?php include 'menu.php';
  require_once 'db.php';
 ?>
  <div class="showall">
    <div class="show" >
      <div class="container mt-3">
            <h3>
              <p>กลุ่มเปราะบาง
              </p>
            </h3>
      </div>
      <div class="container mt-3"  >
      <form action="" method="POST">
    <label for="handicap">เลือกกลุ่มเปราะบาง:</label>
    <select id="handicap" name="handicap">
      <option value="ใช่">กลุ่มเปราะบาง</option>
      <option value="ไม่ใช่">ไม่อยู่ในกลุ่มเปราะบาง</option>
    </select>
    <button type="submit" class="btn btn-success">แสดงผล</button>
  </form><br>
  <?php
// รับค่าจาก dropdown หากมีการส่งค่ามา
$selectedHandicap = $_POST['handicap'] ?? 'ทั้งหมด';

// สร้างส่วนของคำสั่ง SQL สำหรับกรองข้อมูลตามกลุ่มเปราะบางที่เลือก
$handicapCondition = "";
if ($selectedHandicap !== 'ทั้งหมด') {
    $handicapCondition = " WHERE handicap = '$selectedHandicap'";
}

// เตรียมคำสั่ง SQL พร้อมเงื่อนไขที่ได้จากการเลือกของผู้ใช้
$sql = "SELECT 
    id, 
    CONCAT(pr.prefix, ' ', name, ' ', lastname) AS full_name,
    date,
    TIMESTAMPDIFF(YEAR, date, CURDATE()) AS age,
    sex, 
    handicap, 
    tel
    FROM data as dt 
    JOIN prefix AS pr ON dt.prefix_id = pr.prefix_id
    $handicapCondition";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

// ต่อจากนี้คือการแสดงผลและโค้ดที่เหลือเหมือนด้านบน
?>

        <div class="table-responsive" id="id-of-the-tr" >
          <table class="table table-striped" id="myTable" >
            <thead >
              <tr class="table-success">
                <th>#</th>
                <th>รหัสบัตรประชาชน</th>
                <th>ชื่อ</th>
                <th>อายุ</th>
                <th>เพศ</th>
                <th>กลุ่มเปราะบาง</th>
                <th>เบอร์โทร</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $conn->prepare(
                "SELECT 
                id, 
                CONCAT(pr.prefix,' ',name, ' ', lastname) AS full_name,
                date,
                TIMESTAMPDIFF(YEAR, date, CURDATE()) AS age,
                sex, 
                status, 
                o.occupation as occupation, 
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
                us.user_name as user_name,
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
                JOIN 
                user AS us ON dt.user_id = us.user_id 
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
                    <td><?php echo $row['id_card']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['sex']; ?></td>
                    <td><?php echo $row['handicap']; ?></td>
                    <td><?php echo $row['tel']; ?></td>
                  </tr>
                <?php $i++;
                }
              } else { ?>
                <tr>
                  <td colspan="16" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                </tr>
              <?php  } ?>
            </tbody>
            
          </table>
          <button onclick="printSpecificPart('id-of-the-tr')" class="btn btn-primary print-button">พิมพ์</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
    
function printSpecificPart(elementId) {
    // ลบ class print-section ออกจากทุกส่วน
    document.querySelectorAll('.print-section').forEach(e => {
        e.classList.remove('print-section');
    });

    // เพิ่ม class print-section เข้าไปที่ element ที่ต้องการพิมพ์
    const element = document.getElementById(elementId);
    element.classList.add('print-section');

    // เรียกใช้ฟังก์ชันพิมพ์ของเบราว์เซอร์
    window.print();
}

  </script>
</body>
</html>