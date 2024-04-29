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
}
</style>

<body>
  <?php include 'menu.php';
  require_once 'db.php';
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  // exit();
  //ตรวจสอบตัวแปรที่ส่งมาจากฟอร์ม
  if (isset($_POST['card_id']) && $_GET['act'] === 'add') {
    $disease_ids = $_POST['disease_id']; 
    $disease_id = implode(',', $disease_ids);
    $m_rank = 4 ;
    $stay = 41 ;
    $user_id = 1;
    $stmt = $conn->prepare("INSERT INTO data
  (
    prefix_id,
    name,
    lastname,
    date,
    sex,
    status,
    occupation_id ,
    disease_id,
    place,
    handicap,
    tel,
    home_id,
    home_no,
    swine,
    amphure_id,
    district_id,
    province_id,
    m_rank,
    stay,
    user_id,
    id_card
  )
  VALUES
  (
  :prefix_id,
  :fname,
  :lname,
  :bdate, 
  :sex,
  :status,
  :occupation,
  :disease_id,
  :place,
  :handicap,
  :tel,
  :home_id,
  :home_no,
  :swine,
  :amphure_id,
  :district_id,
  :province_id,
  :m_rank,
  :stay,
  :user_id,
  :card_id
  )
");
      
      $stmt->bindParam(':prefix_id', $_POST['prefix_id'], PDO::PARAM_STR);
      $stmt->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
      $stmt->bindParam(':lname', $_POST['lname'], PDO::PARAM_STR);
      $stmt->bindParam(':bdate', $_POST['bdate'], PDO::PARAM_STR);
      $stmt->bindParam(':sex', $_POST['sex'], PDO::PARAM_STR);
      $stmt->bindParam(':status', $_POST['status'], PDO::PARAM_STR);
      $stmt->bindParam(':occupation', $_POST['occupation'], PDO::PARAM_STR);
      $stmt->bindParam(':disease_id', $disease_id, PDO::PARAM_STR);
      $stmt->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
      $stmt->bindParam(':handicap', $_POST['handicap'], PDO::PARAM_STR);
      $stmt->bindParam(':tel', $_POST['tel'], PDO::PARAM_STR);
      $stmt->bindParam(':home_id', $_POST['home_id'], PDO::PARAM_STR);
      $stmt->bindParam(':home_no', $_POST['home_no'], PDO::PARAM_STR);
      $stmt->bindParam(':swine', $_POST['swine'], PDO::PARAM_STR);
      $stmt->bindParam(':amphure_id', $_POST['amphure_id'], PDO::PARAM_STR);
      $stmt->bindParam(':district_id', $_POST['district_id'], PDO::PARAM_STR);
      $stmt->bindParam(':province_id', $_POST['province_id'], PDO::PARAM_STR);
      $stmt->bindParam(':m_rank', $m_rank, PDO::PARAM_INT);
      $stmt->bindParam(':stay', $stay, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':card_id', $_POST['card_id'], PDO::PARAM_STR);
      
      $result = $stmt->execute();
    $conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล

//     if ($result) {
//       echo '<script>
//     setTimeout(function() {
//       swal({
//       title: "เพิ่มข้อมูลสำเร็จ",
//       type: "success"
//       }, function() {
//       window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
//       });
//     }, 1000);
//   </script>';
//     } else {
//       echo '<script>
//     setTimeout(function() {
//       swal({
//       title: "เกิดข้อผิดพลาด",
//       type: "error"
//       }, function() {
//       window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
//       });
//     }, 1000);
//   </script>';
//     }
  }
  if (isset($_GET['act']) && $_GET['act'] === 'edit') {
    if (
      isset($_POST['homeid']) && isset($_POST['homeno']) && isset($_POST['swine']) &&
      isset($_POST['pro']) && isset($_POST['aph']) && isset($_POST['di']) && isset($_POST['hometype'])
    ) {
      $homeid = $_POST['homeid'];
      $homeno = $_POST['homeno'];
      $swine = $_POST['swine'];
      $pro = $_POST['pro'];
      $aph = $_POST['aph'];
      $di = $_POST['di'];
      $hometype = $_POST['hometype'];

      // SQL update
      $stmt = $conn->prepare("UPDATE address SET 
        home_no = :homeno, 
        swine = :swine,
        amphure_id = :aph,
        district_id = :di,
        province_id = :pro,
        home_type = :hometype
        WHERE home_id = :homeid");

      $stmt->bindParam(':homeid', $homeid, PDO::PARAM_INT);
      $stmt->bindParam(':homeno', $homeno, PDO::PARAM_STR);
      $stmt->bindParam(':swine', $swine, PDO::PARAM_STR);
      $stmt->bindParam(':pro', $pro, PDO::PARAM_STR);
      $stmt->bindParam(':aph', $aph, PDO::PARAM_STR);
      $stmt->bindParam(':di', $di, PDO::PARAM_STR);
      $stmt->bindParam(':hometype', $hometype, PDO::PARAM_STR);

      try {
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "แก้ไขข้อมูลสำเร็จ",
                          type: "success"
                      }, function() {
                          window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
        } else {
          echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "ไม่มีการเปลี่ยนแปลงข้อมูล",
                          type: "info"
                      }, function() {
                          window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
        }
      } catch (PDOException $e) {
        echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "เกิดข้อผิดพลาด",
                      text: "' . $e->getMessage() . '",
                      type: "error"
                  }, function() {
                      window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
      }
    } else {
      echo '<script>
             setTimeout(function() {
              swal({
                  title: "ข้อมูลไม่ครบถ้วน",
                  type: "error"
              }, function() {
                  window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
  }

  if (@isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare('DELETE FROM address WHERE home_id=:id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      echo '<script>
           setTimeout(function() {
            swal({
                title: "ลบข้อมูลสำเร็จ",
                type: "success"
            }, function() {
                window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
            });
          }, 1000);
      </script>';
    } else {
      echo '<script>
           setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                type: "error"
            }, function() {
                window.location = "data.php"; //หน้าที่ต้องการให้กระโดดไป
            });
          }, 1000);
      </script>';
    }
    $conn = null;
  } //isset
  ?>
  <br>
  <div class="showall">
    <div class="show" >
      <div class="container mt-3">
            <h3>
              <p>ข้อมูลผู้ที่มีโรคประจำตัว
              </p>
            </h3>
      </div>
      <div class="container mt-3"  >
        <div class="table-responsive" id="id-of-the-tr" >
          <table class="table table-striped" id="myTable" >
            <thead >
              <tr class="table-success">
                <th>#</th>
                <th>รหัสบัตรประชาชน</th>
                <th>ชื่อ</th>
                <th>อายุ</th>
                <th>เพศ</th>
                <th>โรคประจำตัว</th>
                <th>สถานที่รับยา</th>
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
                    <td><?php echo $row['disease']; ?></td>
                    <td><?php echo $row['place']; ?></td>
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