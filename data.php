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
    $user_id = 2;
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
      
      $stmt->bindParam(':prefix_id', $_POST['prefix_id'], PDO::PARAM_INT); 
      $stmt->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
      $stmt->bindParam(':lname', $_POST['lname'], PDO::PARAM_STR);
      $stmt->bindParam(':bdate', $_POST['bdate'], PDO::PARAM_STR);
      $stmt->bindParam(':sex', $_POST['sex'], PDO::PARAM_STR);
      $stmt->bindParam(':status', $_POST['status'], PDO::PARAM_STR); 
      $stmt->bindParam(':occupation', $_POST['occupation'], PDO::PARAM_INT); 
      $stmt->bindParam(':disease_id', $disease_id, PDO::PARAM_INT);
      $stmt->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
      $stmt->bindParam(':handicap', $_POST['handicap'], PDO::PARAM_STR);
      $stmt->bindParam(':tel', $_POST['tel'], PDO::PARAM_STR);
      $stmt->bindParam(':home_id', $_POST['home_id'], PDO::PARAM_INT);
      $stmt->bindParam(':home_no', $_POST['home_no'], PDO::PARAM_STR);
      $stmt->bindParam(':swine', $_POST['swine'], PDO::PARAM_INT);
      $stmt->bindParam(':amphure_id', $_POST['amphure_id'], PDO::PARAM_INT);
      $stmt->bindParam(':district_id', $_POST['district_id'], PDO::PARAM_INT);
      $stmt->bindParam(':province_id', $_POST['province_id'], PDO::PARAM_INT);
      $stmt->bindParam(':m_rank', $m_rank, PDO::PARAM_INT);
      $stmt->bindParam(':stay', $stay, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':card_id', $_POST['card_id'], PDO::PARAM_STR);
      
      $result = $stmt->execute();
    $conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล

    if ($result) {
      echo '<script>
    setTimeout(function() {
      swal({
      title: "เพิ่มข้อมูลสำเร็จ",
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
    <div class="show">
      <div class="container mt-3">
        <div class="card">
          <div class="card-header">
            <h3>
              <p>ข้อมูลคนในชุมชน</p>
            </h3>
          </div>
        </div>
        <form method="post" action="data.php?act=add">
          <div class="container mt-3">
            <div class="row">
              <div class="col">
                <label class="col-form-label">รหัสบัตรประชาชน:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="card_id" maxlength="13" placeholder="ระบุตัวเลขไม่เกิน 13 ตัว" required>
              </div>
              <div class="col">
                <label class="col-form-label">คำนำหน้า:<span class="required-star">*</span></label>
                <select name="prefix_id" class="fstdropdown-select" id="select_box" required>
                  <option selected disabled>กรุณาเลือกคำนำหน้า</option>
                  <?php $stmt2 = $conn->prepare("SELECT  * FROM prefix ORDER BY prefix  ASC; ");
                  $stmt2->execute();
                  $result2 = $stmt2->fetchAll();
                  foreach ($result2 as $row2) {
                  ?>
                    <option value="<?php echo $row2['prefix_id']; ?>"><?php echo $row2['prefix']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">ชื่อ:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="fname" required>
              </div>
              <div class="col">
                <label class="col-form-label">นามสกุล:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="lname" required>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">วัน-เดือน-ปีเกิด:<span class="required-star">*</span></label>
                <input type="date" class="form-control" id="" name="bdate" required>
              </div>
              <div class="col">
                <label class="col-form-label">เพศ:<span class="required-star">*</span></label>
                <select name="sex" class="form-select" id="inputGroupSelect01" required>
                  <option selected disabled>--กรุณาเลือก--</option>
                  <option>ชาย</option>
                  <option>หญิง</option>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">สถานะ:<span class="required-star">*</span></label>
                <select name="status" class="form-select" id="inputGroupSelect01" required>
                  <option value="" selected disabled>-- กรุณาเลือก --</option>
                  <option value="โสด">โสด</option>
                  <option value="สมรส">สมรส</option>
                  <option value="หย่าร้าง">หย่าร้าง</option>
                </select>

              </div>
              <div class="col">
                <label class="col-form-label">อาชีพ:<span class="required-star">*</span></label>
                <select name="occupation" class="fstdropdown-select" id="inputGroupSelect01" required>
                  <option selected disabled>กรุณาเลือกอาชีพ</option>
                  <?php $stmt2 = $conn->prepare("SELECT  * FROM occupation ORDER BY occupation  ASC; ");
                  $stmt2->execute();
                  $result2 = $stmt2->fetchAll();
                  foreach ($result2 as $row2) {
                  ?>
                    <option value="<?php echo $row2['occupation_id']; ?>"><?php echo $row2['occupation']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">โรคประจำตัว:<span class="required-star">*</span></label>
                <div id="re">
                  <?php $stmt2 = $conn->prepare("SELECT  * FROM disease ORDER BY disease  ASC; ");
                  $stmt2->execute();
                  $result2 = $stmt2->fetchAll();
                  foreach ($result2 as $row2) {
                  ?>
                    <div class="form-check">
                      <div>
                        <input class="form-check-input" type="checkbox" id="check1" name="disease_id[]" value="<?php echo $row2['disease_id'] ?? ''; ?>">
                        <label class="form-check-label" style="font-weight:400;"><?php echo $row2['disease']; ?></label>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">กลุ่มเปราะบาง:<span class="required-star">*</span></label>
                <select name="handicap" class="form-select" id="inputGroupSelect01" required>
                  <option selected disabled>--กรุณาเลือก--</option>
                  <option>ใช่</option>
                  <option>ไม่ใช่</option>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">สถานที่รับยา:<span class="required-star">*</span></label>
                <select name="place" class="form-select" id="inputGroupSelect01" required>
                  <option selected disabled>--กรุณาเลือก--</option>
                  <option>ไม่มีโรคประจำตัว</option>
                  <option>โรงพยาบาลด่านขุนทด (รพ.เก่า)</option>
                  <option>โรงพยาบาลหลวงพ่อคูณปริสุทฺโธ (รพ.ใหม่)</option>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">เบอร์โทร:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="tel" required>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">รหัสบ้านตามทะเบียนบ้าน:<span class="required-star">*</span></label>
                <select name="home_id" class="fstdropdown-select" id="inputGroupSelect01" required>
                  <option selected disabled>--กรุณาเลือก--</option>
                  <?php $stmt3 = $conn->prepare("SELECT  * FROM address ORDER BY home_id  ASC; ");
                  $stmt3->execute();
                  $result3 = $stmt3->fetchAll();
                  foreach ($result3 as $row3) {
                  ?>
                    <option value="<?php echo $row3['home_id']; ?>"><?php echo $row3['home_id']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div> <br>
            <div class="card">
              <div class="card-header">
                <h3>
                  <p>ที่อยู่ปัจจุบัน</p>
                </h3>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="home_no" required>
              </div>
              <div class="col">
                <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="swine" required>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">จังหวัด:<span class="required-star">*</span></label>
                <select name="province_id" class="fstdropdown-select" id="select_box" required>
                  <option selected disabled>กรุณาเลือกจังหวัด</option>
                  <?php $stmt2 = $conn->prepare("SELECT  * FROM provinces ORDER BY name_th  ASC; ");
                  $stmt2->execute();
                  $result2 = $stmt2->fetchAll();
                  foreach ($result2 as $row2) {
                  ?>
                    <option value="<?php echo $row2['province_id']; ?>"><?php echo $row2['name_th']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">อำเภอ:<span class="required-star">*</span></label>
                <select name="amphure_id" class="fstdropdown-select" id="select_box" required>
                  <option selected disabled>กรุณาเลือกอำเภอ</option>
                  <?php $stmt3 = $conn->prepare("SELECT  amphure_id,name_th FROM amphures ORDER BY name_th  ASC; ");
                  $stmt3->execute();
                  $result3 = $stmt3->fetchAll();
                  foreach ($result3 as $row3) {
                  ?>
                    <option value="<?php echo $row3['amphure_id']; ?>"><?php echo $row3['name_th']; ?></option>
                  <?php }  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                <select name="district_id" class="fstdropdown-select" id="select_box" required>
                  <option selected disabled>กรุณาเลือกตำบล</option>
                  <?php $stmt4 = $conn->prepare("SELECT  district_id ,name_th FROM districts ORDER BY name_th  ASC; ");
                  $stmt4->execute();
                  $result4 = $stmt4->fetchAll();
                  foreach ($result4 as $row4) {
                  ?>
                    <option value="<?php echo $row4['district_id']; ?>"><?php echo $row4['name_th']; ?></option>
                  <?php }  ?>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="addr" required>
              </div>
            </div>
            <br>
          </div>
          <div class="row">
            <center><input type="submit" class="btn btn-primary" value="เพิ่มข้อมูล"> <a href="data.php" class="btn btn-secondary">ล้างข้อมูล</a></center>
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
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $conn->prepare(
                "SELECT 
                id, 
                pr.prefix as prefix,
                name, 
                lastname,  
                date,
                $dateDB AS age,
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
                $user AS us ON dt.user_id = us.user_id 
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
                    <td><?php echo $row['prefix']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['sex']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['occupation']; ?></td>
                    <td><?php echo $row['disease']; ?></td>
                    <td><?php echo $row['handicap']; ?></td>
                    <td><?php echo $row['place']; ?></td>
                    <td><?php echo $row['tel']; ?></td>
                    <td><a id="ff" href="show-address.php?home_id=<?php echo $row['home_id']; ?>" class="btn btn-success">ดูข้อมูล</a></td>
                    <td><button id="ff" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $row['id']; ?>">แก้ไขข้อมูล</button></td>
                    <td> <button id="ff" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['id']; ?>">
                        ลบข้อมูล
                      </button></td>
                  </tr>
                  <div class="modal fade" id="Modaldeletel<?php echo $row['home_id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <b class="modal-title">ลบข้อมูลหรือไม่</b>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          หากลบข้อมูลแล้วจะไม่สามารถย้อนคืนได้
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <a href="address.php?delete_id=<?php echo $row['home_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="myModal<?php echo $row['home_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <p>แก้ไขครัวเรือน</p>
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="address.php?act=edit" method="post">
                            <label class="col-form-label">รหัสบ้าน:</label>
                            <input type="text" class="form-control" id="" name="homeid" value="<?php echo $row['home_id']; ?>">

                            <label class="col-form-label">บ้านเลขที่:</label>
                            <input type="text" class="form-control" id="" name="homeno" value="<?php echo $row['home_no']; ?>">

                            <label class="col-form-label">หมู่:</label>
                            <input type="text" class="form-control" id="" name="swine" value="<?php echo $row['swine']; ?>">

                            <label class="col-form-label">จังหวัด:</label>
                            <select name="pro" class="form-select" id="inputGroupSelect01" required>
                              <option selected value="<?php echo $row['provinceId']; ?>"><?php echo $row['pro']; ?></option>
                              <?php $stmt2 = $conn->prepare("SELECT  * FROM provinces ORDER BY name_th  ASC; ");
                              $stmt2->execute();
                              $result2 = $stmt2->fetchAll();
                              foreach ($result2 as $row2) {
                              ?>
                                <option value="<?php echo $row2['province_id']; ?>"><?php echo $row2['name_th']; ?></option>
                              <?php } ?>
                            </select>

                            <label class="col-form-label">อำเภอ:</label>
                            <select name="aph" class="form-select" id="inputGroupSelect01" required>
                              <option selected value="<?php echo $row['amphureId']; ?>"><?php echo $row['aph']; ?></option>
                              <?php $stmt3 = $conn->prepare("SELECT  amphure_id,name_th FROM amphures ORDER BY name_th  ASC; ");
                              $stmt3->execute();
                              $result3 = $stmt3->fetchAll();
                              foreach ($result3 as $row3) {
                              ?>
                                <option value="<?php echo $row3['amphure_id']; ?>"><?php echo $row3['name_th']; ?></option>
                              <?php }  ?>
                            </select>

                            <label class="col-form-label">ตำบล:</label>
                            <select name="di" class="form-select" id="inputGroupSelect01" required>
                              <option selected value="<?php echo $row['districtId']; ?>"><?php echo $row['di']; ?></option>
                              <?php $stmt4 = $conn->prepare("SELECT  district_id ,name_th FROM districts ORDER BY name_th  ASC; ");
                              $stmt4->execute();
                              $result4 = $stmt4->fetchAll();
                              foreach ($result4 as $row4) {
                              ?>
                                <option value="<?php echo $row4['district_id']; ?>"><?php echo $row4['name_th']; ?></option>
                              <?php }  ?>
                            </select>

                            <label class="col-form-label">รหัสไปรษณีย์:</label>
                            <input type="text" class="form-control" id="" name="">

                            <label class="form-label">ประเภทบ้าน:</label>
                            <select name="hometype" class="form-select" id="inputGroupSelect01" required>
                              <option selected value="<?php echo $row['home_type']; ?>"><?php echo $row['home_type']; ?></option>
                              <option>บ้านส่วนตัว</option>
                              <option>บ้านเช่า</option>
                            </select>
                            <label class="col-form-label">ตำแหน่งของบ้าน:</label>
                            <input type="text" class="form-control" name="" id="">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                          <button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

                <?php $i++;
                }
              } else { ?>
                <tr>
                  <td colspan="16" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>