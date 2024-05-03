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

  .required-star {
    color: red;
    /* กำหนดสีของดาว */
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
    home_no,
    swine,
    amphure,
    district,
    province_id,
    location,
    home_type,
    id_home,
    zip_code
  )
  VALUES
  (
  :home_no,
  :swine,
  :amphure,
  :district, 
  :province_id,
  :location,
  :home_type,
  :home_id,
  :zip_code
  )
");

    $stmt->bindParam(':home_id', $_POST['home_id'], PDO::PARAM_STR);
    $stmt->bindParam(':home_no', $_POST['home_no'], PDO::PARAM_STR);
    $stmt->bindParam(':swine', $_POST['swine'], PDO::PARAM_STR);
    $stmt->bindParam(':amphure', $_POST['amphure'], PDO::PARAM_STR);
    $stmt->bindParam(':district', $_POST['district'], PDO::PARAM_STR);
    $stmt->bindParam(':province_id', $_POST['province_id'], PDO::PARAM_STR);
    $stmt->bindParam(':location', $_POST['location'], PDO::PARAM_STR);
    $stmt->bindParam(':home_type', $_POST['home_type'], PDO::PARAM_STR);
    $stmt->bindParam(':zip_code', $_POST['zip_code'], PDO::PARAM_STR);


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
  if (isset($_GET['act']) && $_GET['act'] === 'edit') {
    if (
      isset($_POST['homeid']) && isset($_POST['homeno']) && isset($_POST['id_home']) && isset($_POST['swine']) &&
      isset($_POST['pro']) && isset($_POST['aph']) && isset($_POST['di']) && isset($_POST['hometype']) && isset($_POST['location']) && isset($_POST['zip_code'])
    ) {
      $homeid = $_POST['homeid'];
      $id_home = $_POST['id_home'];
      $homeno = $_POST['homeno'];
      $swine = $_POST['swine'];
      $pro = $_POST['pro'];
      $aph = $_POST['aph'];
      $di = $_POST['di'];
      $hometype = $_POST['hometype'];
      $location = $_POST['location'];
      $zip_code = $_POST['zip_code'];

      // SQL update
      $stmt = $conn->prepare("UPDATE address SET 
        home_no = :homeno, 
        id_home = :id_home, 
        swine = :swine,
        amphure = :aph,
        district = :di,
        province_id = :pro,
        home_type = :hometype,
        location = :location
        zip_code = :zip_code
        WHERE id = :id");

      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);
      $stmt->bindParam(':homeno', $homeno, PDO::PARAM_STR);
      $stmt->bindParam(':swine', $swine, PDO::PARAM_STR);
      $stmt->bindParam(':pro', $pro, PDO::PARAM_STR);
      $stmt->bindParam(':aph', $aph, PDO::PARAM_STR);
      $stmt->bindParam(':di', $di, PDO::PARAM_STR);
      $stmt->bindParam(':hometype', $hometype, PDO::PARAM_STR);
      $stmt->bindParam(':location', $location, PDO::PARAM_STR);
      $stmt->bindParam(':zip_code', $location, PDO::PARAM_STR);
      try {
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
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
                          title: "ไม่มีการเปลี่ยนแปลงข้อมูล",
                          type: "info"
                      }, function() {
                          window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
                      window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "address.php"; //หน้าที่ต้องการให้กระโดดไป
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
                <label class="col-form-label">รหัสบ้าน:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="home_id" maxlength="11" placeholder="ระบุตัวเลขไม่เกิน 11 ตัว" required>
              </div>
              <div class="col">
                <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="home_no" placeholder="ตัวอย่างเช่น 44/1 " required>
              </div>
              <div class="col">
                <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="swine" placeholder="ถ้าไม่มีหมู่ให้ใส่ -" required>
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
                <input type="text" class="form-control" id="" name="amphure" required>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="district" required>
              </div>
              <div class="col">
                <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="zip_code" required>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="col-form-label">ประเภทบ้าน:<span class="required-star">*</span></label>
                <select name="home_type" class="form-select" id="inputGroupSelect01" required>
                  <option selected disabled>กรุณาเลือกประเภทบ้าน</option>
                  <option>บ้านส่วนตัว</option>
                  <option>บ้านเช่า</option>
                </select>
              </div>
              <div class="col">
                <label class="col-form-label">ตำแหน่งของบ้าน:<span class="required-star">*</span>
                  <a href="https://www.google.com/maps" target="_blank">ดูบน Google Maps</a></label>
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
                <th>รหัสไปรษณีย์</th>
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
                   ad.id,
                   ad.id_home,
                   ad.home_no,
                   ad.swine,
                   pro.name_th as pro,
                   ad.location,
                   ad.home_type ,
                   pro.province_id as provinceId ,
                   ad.amphure,
                   ad.district
                   FROM 
                   address AS ad
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
                    <td><?php echo $row['id_home']; ?></td>
                    <td><?php echo $row['home_no']; ?></td>
                    <td><?php echo $row['swine']; ?></td>
                    <td><?php echo $row['amphure']; ?></td>
                    <td><?php echo $row['district']; ?></td>
                    <td><?php echo $row['pro']; ?></td>
                    <td>
                      <!-- <?php echo $row['zip_code']; ?> -->
                    </td>
                    <td><?php echo $row['home_type']; ?></td>
                    <td><a href="show-address.php?home_id=<?php echo $row['id']; ?>&id_home=<?php echo $row['id_home']; ?>&home_no=<?php echo $row['home_no']; ?>&swine=<?php echo $row['swine']; ?>&aph=<?php echo $row['amphure']; ?>&di=<?php echo $row['district']; ?>&pro=<?php echo $row['pro']; ?>&location=<?php echo urlencode($row['location']); ?>&zip_code=<?php echo $row['zip_code']; ?>&home_type=<?php echo $row['home_type']; ?>" class="btn btn-success">ดูข้อมูล</a></td>
                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $row['id']; ?>">แก้ไขข้อมูล</button></td>
                    <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['id']; ?>">
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
                          <a href="address.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="myModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="hidden" name="homeid" value="<?php echo $row['id']; ?>">
                            <label class="col-form-label">รหัสบ้าน:<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="" name="id_home" value="<?php echo $row['id_home']; ?>">

                            <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="" name="homeno" value="<?php echo $row['home_no']; ?>">

                            <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="" name="swine" value="<?php echo $row['swine']; ?>">

                            <label class="col-form-label">จังหวัด:<span class="required-star">*</span></label>
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
                            <div class="col">
                              <label class="col-form-label">อำเภอ:<span class="required-star">*</span></label>
                              <input type="text" class="form-control" id="" name="amphure" value="<?php echo $row['amphure']; ?>" required>

                              <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                              <input type="text" class="form-control" id="" name="district" value="<?php echo $row['district']; ?>" required>
                              <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                              <input type="text" class="form-control" id="" name="zip_code" value="<?php echo $row['zip_code']; ?>" required>
                              <label class="form-label">ประเภทบ้าน:<span class="required-star">*</span></label>
                              <select name="hometype" class="form-select" id="inputGroupSelect01" required>
                                <option selected value="<?php echo $row['home_type']; ?>"><?php echo $row['home_type']; ?>
                                </option>
                                <option>บ้านส่วนตัว</option>
                                <option>บ้านเช่า</option>
                              </select>
                              <label class="col-form-label">ตำแหน่งของบ้าน:<span class="required-star">*</span></label>
                              <a href="https://www.google.com/maps" target="_blank">ดูบน Google Maps</a></label>
                              <textarea class="form-control" rows="5" id="comment" name="location"><?php echo $row['location']; ?></textarea>
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
                <?php } ?>
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