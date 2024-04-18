<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ชุมชนด่านขุนทด</title>
</head>
<style>
  input[type=search] {
    width: 200px;
    height: 40px;
    margin-bottom: 8px;
    border: 1px black solid;
    border-radius: 5px;
    padding: 15px;
  }
</style>

<body>
  <?php include 'menu.php';
  require_once 'db.php';
  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';
  // exit();
  //ตรวจสอบตัวแปรที่ส่งมาจากฟอร์ม
  if (isset($_POST['home_id']) != null && isset($_POST['home_no']) != null && isset($_POST['swine']) != null) {
    //ไฟล์เชื่อมต่อฐานข้อมูล
    //sql insert
    $stmt = $conn->prepare("INSERT INTO address
  (
    home_id,
    home_no,
    swine,
    amphure_id,
    district_id,
    province_id,
    location,
    home_type
  )
  VALUES
  (
  :home_id,
  :home_no,
  :swine,
  :amphure_id,
  :district_id, 
  :province_id,
  :location,
  :home_type
  )
");

    $stmt->bindParam(':home_id', $_POST['home_id'], PDO::PARAM_STR);
    $stmt->bindParam(':home_no', $_POST['home_no'], PDO::PARAM_STR);
    $stmt->bindParam(':swine', $_POST['swine'], PDO::PARAM_STR);
    $stmt->bindParam(':amphure_id', $_POST['amphure_id'], PDO::PARAM_STR);
    $stmt->bindParam(':district_id', $_POST['district_id'], PDO::PARAM_STR);
    $stmt->bindParam(':province_id', $_POST['province_id'], PDO::PARAM_STR);
    $stmt->bindParam(':location', $_POST['location'], PDO::PARAM_STR);
    $stmt->bindParam(':home_type', $_POST['home_type'], PDO::PARAM_STR);

    $result = $stmt->execute();
    $conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล

    if ($result) {
      echo '<script>
    setTimeout(function() {
      swal({
      title: "เพิ่มข้อมูลสำเร็จ",
      type: "success"
      }, function() {
      window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
      window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
      });
    }, 1000);
  </script>';
    }
  }

  if (isset($_POST['homeid']) && isset($_POST['homeno']) && isset($_POST['swine']) && isset($_POST['pro']) && isset($_POST['hometype']) && isset($_POST['aph']) && isset($_POST['di'])) {
    $homeid = $_POST['homeid'];
    $homeno = $_POST['homeno'];
    $swine = $_POST['swine'];
    $pro = $_POST['pro'];
    $aph = $_POST['aph'];
    $di = $_POST['di'];
    $hometype = $_POST['hometype'];

    // SQL update
    $stmt = $conn->prepare("UPDATE address SET 
    home_id = :homeid,
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
    $stmt->execute();

    if ($stmt->rowCount() >= 0) {
      echo '<script>
           setTimeout(function() {
            swal({
                title: "แก้ไขข้อมูลสำเร็จ",
                type: "success"
            }, function() {
                window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
                window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
            });
          }, 1000);
      </script>';
    }
    $conn = null; //close connect db
  } //isset
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
                window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
                window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
              <p>ข้อมูลครัวเรือน</p>
            </h3>
          </div>
        </div>
        <form method="post" action="address.php?act=add">
          <div class="container mt-3">
            <div class="row">
              <div class="col">
                <label class="col-form-label">รหัสบ้าน:</label>
                <input type="text" class="form-control" id="" name="home_id" maxlength="11" placeholder="ระบุตัวเลขไม่เกิน 11 ตัว" required>
              </div>
              <div class="col">
                <label class="col-form-label">บ้านเลขที่:</label>
                <input type="text" class="form-control" id="" name="home_no" required>
              </div>
              <div class="col">
                <label class="col-form-label">หมู่:</label>
                <input type="text" class="form-control" id="" name="swine" required>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">จังหวัด:</label>
                <select name="province_id" class="form-select" id="inputGroupSelect01" required>
                  <option selected>กรุณาเลือกจังหวัด</option>
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
                <label class="col-form-label">อำเภอ:</label>
                <select name="amphure_id" class="form-select" id="inputGroupSelect01" required>
                  <option selected>กรุณาเลือกอำเภอ</option>
                  <?php $stmt3 = $conn->prepare("SELECT  amphure_id,name_th FROM amphures ORDER BY name_th  ASC; ");
                  $stmt3->execute();
                  $result3 = $stmt3->fetchAll();
                  foreach ($result3 as $row3) {
                  ?>
                    <option value="<?php echo $row3['amphure_id']; ?>"><?php echo $row3['name_th']; ?></option>
                  <?php }  ?>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">ตำบล:</label>
                <select name="district_id" class="form-select" id="inputGroupSelect01" required>
                  <option selected>กรุณาเลือกอำเภอ</option>
                  <?php $stmt3 = $conn->prepare("SELECT  * FROM districts ORDER BY name_th  ASC; ");
                  $stmt3->execute();
                  $result3 = $stmt3->fetchAll();
                  foreach ($result3 as $row3) {
                  ?>
                    <option value="<?php echo $row3['district_id']; ?>"><?php echo $row3['name_th']; ?></option>
                  <?php }  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">รหัสไปรษณีย์:</label>
                <input type="text" class="form-control" id="" name="addr" required>
              </div>
              <div class="col">
                <label class="col-form-label">ประเภทบ้าน:</label>
                <select name="home_type" class="form-select" id="inputGroupSelect01" required>
                  <option>บ้านส่วนตัว</option>
                  <option>บ้านเช่า</option>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">ตำแหน่งของบ้าน:</label>
                <input type="text" class="form-control" id="" name="location">
              </div>
            </div><br>
            <div class="row">
              <center><input type="submit" class="btn btn-primary" value="เพิ่มข้อมูล"> <a href="address.php" class="btn btn-secondary">ล้างข้อมูล</a></center>
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
                <th>รหัสบ้าน</th>
                <th>บ้านเลขที่</th>
                <th>หมู่</th>
                <th>ตำบล</th>
                <th>อำเภอ</th>
                <th>จังหวัด</th>
                <th>ประเภทบ้าน</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $conn->prepare(
                "SELECT 
                   ad.home_id,
                   ad.home_no,
                   ad.swine,
                   aph.name_th as aph,
                   di.name_th as di,
                   pro.name_th as pro,
                   ad.home_type ,
                   pro.province_id as provinceId ,
                   aph.amphure_id as amphureId ,
                   di.district_id as districtId
                   FROM 
                   address AS ad
                   JOIN 
                   amphures AS aph ON ad.amphure_id = aph.amphure_id 
                   JOIN 
                   districts AS di ON ad.district_id = di.district_id 
                   JOIN 
                   provinces AS pro ON ad.province_id = pro.province_id 
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
                    <td><?php echo $row['home_id']; ?></td>
                    <td><?php echo $row['home_no']; ?></td>
                    <td><?php echo $row['swine']; ?></td>
                    <td><?php echo $row['aph']; ?></td>
                    <td><?php echo $row['di']; ?></td>
                    <td><?php echo $row['pro']; ?></td>
                    <td><?php echo $row['home_type']; ?></td>
                    <td><a href="show-address.php?home_id=<?php echo $row['home_id']; ?>&home_no=<?php echo $row['home_no']; ?>&swine=<?php echo $row['swine']; ?>&aph=<?php echo $row['aph']; ?>&di=<?php echo $row['di']; ?>&pro=<?php echo $row['pro']; ?>&home_type=<?php echo $row['home_type']; ?>" class="btn btn-success">ดูข้อมูล</a></td>
                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $row['home_id']; ?>">แก้ไขข้อมูล</button></td>
                    <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['home_id']; ?>">
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
                          <form action="address.php" method="post">
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
                  <td colspan="11" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
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