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
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // exit();
    //ตรวจสอบตัวแปรที่ส่งมาจากฟอร์ม
    if (isset($_GET['id_home']) && isset($_GET['act']) && $_GET['act'] === 'adhome') {
      $idhome = $_GET['id_home'];
      $stmthome = $conn->prepare("SELECT 
       ad.id,
       ad.id_home,
       ad.home_no,
       ad.swine,
       pro.name_th as pro,
       ad.location,
       ad.home_type ,
       pro.province_id as provinceId ,
       ad.amphure,
       ad.district,
       ad.zip_code
       FROM 
       address AS ad
       JOIN 
       provinces AS pro ON ad.province_id = pro.province_id 
       where ad.id_home = :idhome
       ");
      $stmthome->bindParam(':idhome', $idhome, PDO::PARAM_INT);
      $stmthome->execute();
      if ($stmthome->rowCount() == 1) {
        $rowhome = $stmthome->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id_home'] = $rowhome['id_home'];
        $_SESSION['home_no'] = $rowhome['home_no'];
        $_SESSION['swine'] = $rowhome['swine'];
        $_SESSION['amphure'] = $rowhome['amphure'];
        $_SESSION['district'] = $rowhome['district'];
        $_SESSION['pro'] = $rowhome['pro'];
        $_SESSION['provinceId'] = $rowhome['provinceId'];
        $_SESSION['zip_code'] = $rowhome['zip_code'];
        $_SESSION['disabled'] = 'disabled';
        echo '<script>window.location.href = "data.php";</script>';
      }
    }



    if (isset($_POST['card_id']) && $_GET['act'] === 'add') {
      $stmt = $conn->prepare("SELECT id_card FROM data WHERE id_card = :card_id");
      $stmt->bindParam(':card_id', $_POST['card_id'], PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() >= 1) {
        $card_id_use = 'เลขบัตรประชาชนซ้ำ';
      } else {
        $card_id_use = 'เลขบัตรประชาชนไม่ซ้ำ';
      }
      if ($card_id_use == 'เลขบัตรประชาชนไม่ซ้ำ') {
        if (
          isset($_POST['card_id']) &&
          isset($_POST['prefix_id']) &&
          isset($_POST['fname']) &&
          isset($_POST['lname']) &&
          isset($_POST['bdate']) &&
          isset($_POST['sex']) &&
          isset($_POST['status']) &&
          isset($_POST['occupation']) &&
          isset($_POST['disease_id']) &&
          isset($_POST['handicap']) &&
          isset($_POST['place']) &&
          isset($_POST['tel']) &&
          isset($_POST['home_no']) &&
          isset($_POST['home_id']) &&
          isset($_POST['swine']) &&
          isset($_POST['province_id']) &&
          isset($_POST['amphure']) &&
          isset($_POST['district']) &&
          isset($_POST['zip_code']) &&
          isset($_POST['m_rank'])
        ) {
          $disease_ids = $_POST['disease_id'];
          $disease_id = implode(',', $disease_ids);
          $m_rank = $_POST['m_rank'];
          $user_id = @$_SESSION['user_id'];
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
            amphure,
            district,
            province_id,
            m_rank,
            stay,
            user_id,
            id_card,
            zip_code
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
          :card_id,
          :zip_code
          )
         ");

          $stmt->bindParam(':prefix_id', $_POST['prefix_id'], PDO::PARAM_INT);
          $stmt->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
          $stmt->bindParam(':lname', $_POST['lname'], PDO::PARAM_STR);
          $stmt->bindParam(':bdate', $_POST['bdate'], PDO::PARAM_STR);
          $stmt->bindParam(':sex', $_POST['sex'], PDO::PARAM_STR);
          $stmt->bindParam(':status', $_POST['status'], PDO::PARAM_STR);
          $stmt->bindParam(':occupation', $_POST['occupation'], PDO::PARAM_INT);
          $stmt->bindParam(':disease_id', $disease_id, PDO::PARAM_STR);
          $stmt->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
          $stmt->bindParam(':handicap', $_POST['handicap'], PDO::PARAM_STR);
          $stmt->bindParam(':tel', $_POST['tel'], PDO::PARAM_STR);
          $stmt->bindParam(':home_id', $_POST['home_id'], PDO::PARAM_INT);
          $stmt->bindParam(':home_no', $_POST['home_no'], PDO::PARAM_STR);
          $stmt->bindParam(':swine', $_POST['swine'], PDO::PARAM_STR);
          $stmt->bindParam(':amphure_id', $_POST['amphure'], PDO::PARAM_STR);
          $stmt->bindParam(':district_id', $_POST['district'], PDO::PARAM_STR);
          $stmt->bindParam(':province_id', $_POST['province_id'], PDO::PARAM_INT);
          $stmt->bindParam(':m_rank', $m_rank, PDO::PARAM_STR);
          $stmt->bindParam(':stay', $_POST['stay'], PDO::PARAM_STR);
          $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $stmt->bindParam(':card_id', $_POST['card_id'], PDO::PARAM_STR);
          $stmt->bindParam(':zip_code', $_POST['zip_code'], PDO::PARAM_STR);

          $result = $stmt->execute();
          $conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล

          if ($result) {
            unset($_SESSION['home_no']);
            unset($_SESSION['id_home']);
            unset($_SESSION['swine']);
            unset($_SESSION['amphure']);
            unset($_SESSION['district']);
            unset($_SESSION['pro']);
            unset($_SESSION['zip_code']);
            unset($_SESSION['disabled']);

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
      } else {
        echo '<script>
        setTimeout(function() {
         swal({
             title: "เลขบัตรประชาชนซ้ำ",
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
        isset($_POST['id']) &&
        isset($_POST['id_card']) &&
        isset($_POST['prefix_id']) &&
        isset($_POST['fname']) &&
        isset($_POST['lname']) &&
        isset($_POST['bdate']) &&
        isset($_POST['sex']) &&
        isset($_POST['status']) &&
        isset($_POST['occupation']) &&
        isset($_POST['disease_id']) &&
        isset($_POST['handicap']) &&
        isset($_POST['place']) &&
        isset($_POST['tel']) &&
        isset($_POST['home_no']) &&
        isset($_POST['home_id']) &&
        isset($_POST['swine']) &&
        isset($_POST['province_id']) &&
        isset($_POST['amphure']) &&
        isset($_POST['district']) &&
        isset($_POST['zip_code']) &&
        isset($_POST['stay']) &&
        isset($_POST['m_rank'])
      ) {
        $id = $_POST['id'];
        $id_card = $_POST['id_card'];
        $prefix_id = $_POST['prefix_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $bdate = $_POST['bdate'];
        $sex = $_POST['sex'];
        $status = $_POST['status'];
        $occupation_id = $_POST['occupation'];
        $disease_ids = $_POST['disease_id'];
        $disease_id = implode(',', $disease_ids);
        $handicap = $_POST['handicap'];
        $place = $_POST['place'];
        $tel = $_POST['tel'];
        $home_no = $_POST['home_no'];
        $home_id = $_POST['home_id'];
        $swine = $_POST['swine'];
        $province_id = $_POST['province_id'];
        $amphure_id = $_POST['amphure'];
        $district_id = $_POST['district'];
        $zip_code = $_POST['zip_code'];
        $m_rank = $_POST['m_rank'];
        $stay = $_POST['stay'];
        $user_id = @$_SESSION['user_id'];

        // SQL update
        $stmt = $conn->prepare("UPDATE data SET 
            id_card = :id_card,
            prefix_id = :prefix_id,
            name = :fname,
            lastname = :lname,
            date = :bdate,
            sex = :sex,
            status = :status,
            occupation_id = :occupation_id,
            disease_id = :disease_id,
            handicap = :handicap,
            place = :place,
            tel = :tel,
            home_no = :home_no,
            home_id = :home_id,
            swine = :swine,
            province_id = :province_id,
            amphure = :amphure_id,
            district = :district_id,
            zip_code = :zip_code,
            m_rank = :m_rank,
            stay = :stay,
            user_id = :user_id
            WHERE id = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_card', $id_card, PDO::PARAM_STR);
        $stmt->bindParam(':prefix_id', $prefix_id, PDO::PARAM_STR);
        $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
        $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
        $stmt->bindParam(':bdate', $bdate, PDO::PARAM_STR);
        $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':occupation_id', $occupation_id, PDO::PARAM_INT);
        $stmt->bindParam(':disease_id', $disease_id, PDO::PARAM_STR);
        $stmt->bindParam(':handicap', $handicap, PDO::PARAM_STR);
        $stmt->bindParam(':place', $place, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $tel, PDO::PARAM_INT);
        $stmt->bindParam(':home_no', $home_no, PDO::PARAM_STR);
        $stmt->bindParam(':home_id', $home_id, PDO::PARAM_STR);
        $stmt->bindParam(':swine', $swine, PDO::PARAM_STR);
        $stmt->bindParam(':province_id', $province_id, PDO::PARAM_INT);
        $stmt->bindParam(':amphure_id', $amphure_id, PDO::PARAM_STR);
        $stmt->bindParam(':district_id', $district_id, PDO::PARAM_STR);
        $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
        $stmt->bindParam(':m_rank', $m_rank, PDO::PARAM_STR);
        $stmt->bindParam(':stay', $stay, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

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
      $stmt = $conn->prepare('DELETE FROM data WHERE id=:id');
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
    if (@$_GET['act'] === 'clear') {
      unset($_SESSION['home_no']);
      unset($_SESSION['id_home']);
      unset($_SESSION['swine']);
      unset($_SESSION['amphure']);
      unset($_SESSION['district']);
      unset($_SESSION['pro']);
      unset($_SESSION['zip_code']);
      unset($_SESSION['disabled']);
    }
    ?>
    <br>
    <div class="showall">
      <div class="show">
        <div class="container mt-3">
          <div class="card">
            <div class="card-header">
              <h3>
                <p>ที่อยู่ปัจจุบัน</p>
              </h3>
            </div>
          </div>
          <form method="post" action="data.php?act=add">
            <div class="container mt-3">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="pill" href="#home">ที่อยู่ปัจจุบันตามทะเบียนบ้าน</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo @$_SESSION['disabled'] ?>" data-bs-toggle="pill" href="#menu1">ที่อยู่ปัจจุบันอื่น</a>
                </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div id="home" class="tab-pane active">
                  <div class="row">
                    <div class="col">
                      <br>
                      <div class="d-grid">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#homeModal">
                          เลือกที่อยู่ตามทะเบียนบ้าน
                        </button>
                      </div>
                    </div>
                    <div class="col">
                      <br>
                      <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['id_home'] ?>" disabled>
                    </div>
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>
                  </div>
                  <?php if (@$_SESSION['id_home']) { ?>
                    <input type="hidden" class="form-control" name="home_id" id="" value="<?php echo @$_SESSION['id_home'] ?>">
                    <input type="hidden" class="form-control" name="home_no" id="" value="<?php echo @$_SESSION['home_no'] ?>">
                    <input type="hidden" class="form-control" name="stay" id="" value="อยู่ตามทะเบียบบ้าน">
                    <input type="hidden" class="form-control" name="swine" id="" value="<?php echo @$_SESSION['swine'] ?>">
                    <input type="hidden" class="form-control" name="province_id" id="" value="<?php echo @$_SESSION['provinceId'] ?>">
                    <input type="hidden" class="form-control" name="amphure" id="" value="<?php echo @$_SESSION['amphure'] ?>">
                    <input type="hidden" class="form-control" name="district" id="" value="<?php echo @$_SESSION['district'] ?>">
                    <input type="hidden" class="form-control" name="zip_code" id="" value="<?php echo @$_SESSION['zip_code'] ?>">
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label"> การอยู่อาศัย:<span class="required-star">*</span></label>
                        <select class="form-select" id="inputGroupSelect01" disabled>
                          <option selected>อยู่ตามทะเบียบบ้าน</option>
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label">ตำแหน่งในบ้าน :<span class="required-star">*</span></label>
                        <select name="m_rank" class="form-select" id="inputGroupSelect01" required>
                          <option selected disabled>--กรุณาเลือก--</option>
                          <option>เจ้าบ้าน</option>
                          <option>ผู้อาศัย</option>
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['home_no'] ?>" disabled>
                      </div>
                      <div class="col">
                        <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['swine'] ?>" disabled>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label">จังหวัด:<span class="required-star">*</span></label>
                        <select class="form-select" id="inputGroupSelect01" disabled>
                          <option selected value="<?php echo @$_SESSION['provinceId']; ?>">
                            <?php echo @$_SESSION['pro']; ?>
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label">อำเภอ:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['amphure'] ?>" disabled>
                      </div>
                      <div class="col">
                        <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['district'] ?>" disabled>
                      </div>
                      <div class="col">
                        <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['zip_code'] ?>" disabled>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div id="menu1" class="tab-pane">
                  <?php if (@!$_SESSION['id_home']) { ?>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label">รหัสบ้านตามทะเบียนบ้าน:<span class="required-star">*</span></label>
                        <select name="home_id" class="fstdropdown-select" id="inputGroupSelect01" required>
                          <option selected disabled>--กรุณาเลือก--</option>
                          <?php $stmt3 = $conn->prepare("SELECT  * FROM address ORDER BY id_home  ASC; ");
                          $stmt3->execute();
                          $result3 = $stmt3->fetchAll();
                          foreach ($result3 as $row3) {
                          ?>
                            <option value="<?php echo $row3['id_home']; ?>"><?php echo $row3['id_home']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col">
                      </div>
                      <div class="col">
                      </div>
                      <div class="col">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label"> การอยู่อาศัย:<span class="required-star">*</span></label>
                        <select name="stay" class="form-select" id="inputGroupSelect01" required>
                          <option selected>ไม่อยู่ตามทะเบียบบ้าน</option>
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label">ตำแหน่งในบ้าน :<span class="required-star">*</span></label>
                        <select name="m_rank" class="form-select" id="inputGroupSelect01" required>
                          <option selected disabled>--กรุณาเลือก--</option>
                          <option>เจ้าบ้าน</option>
                          <option>ผู้อาศัย</option>
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['home_no'] ?>" name="home_no" required>
                      </div>
                      <div class="col">
                        <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['swine'] ?>" name="swine" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label">จังหวัด:<span class="required-star">*</span></label>
                        <select name="province_id" class="fstdropdown-select" id="select_box" required>
                          <option selected value="<?php echo @$_SESSION['provinceId']; ?>" disabled>
                            <?php
                            if (@$_SESSION['pro']) {
                              echo @$_SESSION['pro'];
                            } else {
                              echo '--กรุณาเลือก--';
                            }
                            ?>
                          </option>
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
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['amphure'] ?>" name="amphure" required>
                      </div>
                      <div class="col">
                        <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['district'] ?>" name="district" required>
                      </div>
                      <div class="col">
                        <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="" value="<?php echo @$_SESSION['zip_code'] ?>" name="zip_code" required>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <br>
              <div class="card">
                <div class="card-header">
                  <h3>
                    <p>ข้อมูลคนในชุมชน</p>
                  </h3>
                </div>
              </div>
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
                          <input class="form-check-input" type="checkbox" id="check1" name="disease_id[]" value="<?php echo $row2['disease'] ?? ''; ?>">
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
                    <option value="Yes">ใช่</option>
                    <option value="No">ไม่ใช่</option>
                  </select>
                </div>
                <div class="col">
                  <label class="col-form-label">สถานที่รับยา:<span class="required-star">*</span></label>
                  <select name="place" class="form-select" id="inputGroupSelect01" required>
                    <option selected disabled>--กรุณาเลือก--</option>
                    <option>ไม่มีโรคประจำตัว</option>
                    <option>โรงพยาบาลมหาราช</option>
                    <option>โรงพยาบาลเทคโนโลยีสุรนารี</option>
                    <option>โรงพยาบาลด่านขุนทด (รพ.เก่า)</option>
                    <option>โรงพยาบาลหลวงพ่อคูณปริสุทฺโธ (รพ.ใหม่)</option>
                  </select>
                </div>
                <div class="col">
                  <label class="col-form-label">เบอร์โทร:<span class="required-star">*</span></label>
                  <input type="text" class="form-control" id="" name="tel" placeholder="ถ้าไม่มีให้ใส่ -" required>
                </div>
              </div>
              <br>
            </div>
            <div class="row">
              <center><input type="submit" class="btn btn-primary" value="เพิ่มข้อมูล"> <a href="data.php?act=clear" class="btn btn-secondary">ล้างข้อมูล</a></center>
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
                  <th>เจ้าหน้าที่</th>
                  <!-- <th>เพศ</th>
                <th>สถานะ</th>
                <th>อาชีพ</th>
                <th>โรคประจำตัว</th>
                <th>กลุ่มเปราะบาง</th>
                <th>สถานที่รับยา</th>
                <th>เบอร์โทร</th> -->
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
                pr.prefix_id,
                pr.prefix as prefix,
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
                      <td><?php echo $row['prefix']; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['lastname']; ?></td>
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
                      <td><?php echo $row['user_name'] ?></td>
                      <td><a href="show-data.php?user_name=<?php echo $row['user_name']; ?>&user_lname=<?php echo $row['user_lname']; ?>&zip_code=<?php echo $row['zip_code']; ?>&id_card=<?php echo $row['id_card']; ?>&prefix_id=<?php echo $row['prefix']; ?>&lastname=<?php echo $row['lastname']; ?>&name=<?php echo $row['name']; ?>&date=<?php echo $row['date']; ?>&age=<?php echo $row['age']; ?>&sex=<?php echo $row['sex']; ?>&status=<?php echo $row['status']; ?>&occupation=<?php echo $row['occupation']; ?>&disease=<?php echo $row['disease']; ?>&place=<?php echo $row['place']; ?>&handicap=<?php echo $row['handicap']; ?>&tel=<?php echo $row['tel']; ?>&status=<?php echo $row['status']; ?>&home_id=<?php echo $row['home_id']; ?>&home_no=<?php echo $row['home_no']; ?>&swine=<?php echo $row['swine']; ?>&amphure=<?php echo $row['amphure']; ?>&district=<?php echo $row['district']; ?>&province_id=<?php echo $row['pro']; ?>" class="btn btn-success">ดูข้อมูล</a></td>
                      <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $row['id']; ?>">แก้ไขข้อมูล</button></td>
                      <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['id']; ?>">
                          ลบข้อมูล
                        </button></td>
                    </tr>
                    <div class="modal fade" id="Modaldeletel<?php echo $row['id']; ?>">
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
                            <a href="data.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="myModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                              <p>แก้ไขข้อมูลคนในชุมชน</p>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="data.php?act=edit" method="post">
                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                              <label class="col-form-label">รหัสบัตรประชาชน:</label>
                              <input type="text" class="form-control" id="" name="id_card" value="<?php echo $row['id_card']; ?>">

                              <label class="col-form-label">คำนำหน้า:<span class="required-star">*</span></label>
                              <select name="prefix_id" class="form-select" id="inputGroupSelect01" required>
                                <option selected value="<?php echo $row['prefix_id']; ?> "><?php echo $row['prefix']; ?></option>
                                <?php $stmt2 = $conn->prepare("SELECT  * FROM prefix ORDER BY prefix  ASC; ");
                                $stmt2->execute();
                                $result2 = $stmt2->fetchAll();
                                foreach ($result2 as $row2) {
                                ?>
                                  <option value="<?php echo $row2['prefix_id']; ?>"><?php echo $row2['prefix']; ?></option>
                                <?php } ?>
                              </select>
                              <div class="row">
                                <div class="col">
                                  <label class="col-form-label">ชื่อ:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="fname" value="<?php echo $row['name']; ?>" required>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">นามสกุล:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="lname" value="<?php echo $row['lastname']; ?>" required>
                                </div>
                              </div>
                              <label class="col-form-label">วัน-เดือน-ปีเกิด:<span class="required-star">*</span></label>
                              <input type="date" class="form-control" id="" name="bdate" value="<?php echo $row['date']; ?>" required>

                              <label class="col-form-label">เพศ:<span class="required-star">*</span></label>
                              <select name="sex" class="form-select" id="inputGroupSelect01" required>
                                <option selected disabled>--กรุณาเลือก--</option>
                                <option selected value="<?php echo $row['sex']; ?> "><?php echo $row['sex']; ?></option>
                                <option>ชาย</option>
                                <option>หญิง</option>
                              </select>

                              <label class="col-form-label">สถานะ:<span class="required-star">*</span></label>
                              <select name="status" class="form-select" id="inputGroupSelect01" required>
                                <option value="" selected disabled>-- กรุณาเลือก --</option>
                                <option selected value="<?php echo $row['status']; ?> "><?php echo $row['status']; ?></option>
                                <option value="โสด">โสด</option>
                                <option value="สมรส">สมรส</option>
                                <option value="หย่าร้าง">หย่าร้าง</option>
                              </select>

                              <label class="col-form-label">อาชีพ:<span class="required-star">*</span></label>
                              <select name="occupation" class="form-select" id="inputGroupSelect01" required>
                                <option selected disabled>กรุณาเลือกอาชีพ</option>
                                <option selected value="<?php echo $row['occupation_id']; ?> "><?php echo $row['occupation']; ?></option>
                                <?php $stmt2 = $conn->prepare("SELECT  * FROM occupation ORDER BY occupation  ASC; ");
                                $stmt2->execute();
                                $result2 = $stmt2->fetchAll();
                                foreach ($result2 as $row2) {
                                ?>
                                  <option value="<?php echo $row2['occupation_id']; ?>"><?php echo $row2['occupation']; ?></option>
                                <?php } ?>
                              </select>

                              <label class="col-form-label">โรคประจำตัว:<span class="required-star">*</span></label>

                              <div class="form-check">
                                <div>
                                  <input class="form-check-input" type="checkbox" id="check1" name="disease_id[]" value="<?php echo $row['disease'] ?? ''; ?>" checked>
                                  <label class="form-check-label" style="font-weight:400; color:blue;"><?php echo $row['disease']; ?></label>
                                </div>
                              </div>
                              <div id="re">
                                <?php
                                // $ds = $row['disease'];
                                $stmt2 = $conn->prepare("SELECT  * FROM disease  ORDER BY disease  ASC; ");
                                $stmt2->execute();
                                $result2 = $stmt2->fetchAll();
                                foreach ($result2 as $row2) {
                                ?>
                                  <div class="form-check">
                                    <div>
                                      <input class="form-check-input" type="checkbox" id="check1" name="disease_id[]" value="<?php echo $row2['disease'] ?? ''; ?>">
                                      <label class="form-check-label" style="font-weight:400; "><?php echo $row2['disease']; ?> </p></label>
                                    </div>
                                  </div>
                                <?php } ?>
                              </div>

                              <label class="col-form-label">กลุ่มเปราะบาง:<span class="required-star">*</span></label>
                              <select name="handicap" class="form-select" id="inputGroupSelect01" required>
                                <option selected disabled>--กรุณาเลือก--</option>
                                <option selected value="<?php echo $row['handicap']; ?> ">
                                  <?php
                                  if ($row['handicap'] == 'Yes') {
                                    echo 'ใช่';
                                  } else if ($row['handicap'] == 'No') {
                                    echo 'ไม่ใช่';
                                  } else {
                                    echo $row['handicap'];
                                  }; ?>
                                </option>
                                <option value="Yes">ใช่</option>
                                <option value="No">ไม่ใช่</option>
                              </select>

                              <label class="col-form-label">สถานที่รับยา:<span class="required-star">*</span></label>
                              <select name="place" class="form-select" id="inputGroupSelect01" required>
                                <option selected disabled>--กรุณาเลือก--</option>
                                <option selected value="<?php echo $row['place']; ?> "><?php echo $row['place']; ?></option>
                                <option>ไม่มีโรคประจำตัว</option>
                                <option>โรงพยาบาลมหาราช</option>
                                <option>โรงพยาบาลเทคโนโลยีสุรนารี</option>
                                <option>โรงพยาบาลด่านขุนทด (รพ.เก่า)</option>
                                <option>โรงพยาบาลหลวงพ่อคูณปริสุทฺโธ (รพ.ใหม่)</option>
                              </select>

                              <label class="col-form-label">เบอร์โทร:<span class="required-star">*</span></label>
                              <input type="text" class="form-control" id="" name="tel" value="<?php echo $row['tel']; ?>" required>
                              <div class="row">
                                <div class="col">
                                  <label class="col-form-label">รหัสบ้านตามทะเบียนบ้าน:<span class="required-star">*</span></label>
                                  <select name="home_id" class="fstdropdown-select" id="inputGroupSelect01" required>
                                    <option selected disabled>--กรุณาเลือก--</option>
                                    <option selected value="<?php echo $row['home_id']; ?>"><?php echo $row['home_id']; ?></option>
                                    <?php $stmt3 = $conn->prepare("SELECT  * FROM address ORDER BY id_home  ASC; ");
                                    $stmt3->execute();
                                    $result3 = $stmt3->fetchAll();
                                    foreach ($result3 as $row3) {
                                    ?>
                                      <option value="<?php echo $row3['id_home']; ?>"><?php echo $row3['id_home']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">การอยู่อาศัย :<span class="required-star">*</span></label>
                                  <select name="stay" class="form-select" id="inputGroupSelect01" required>
                                    <option selected disabled>--กรุณาเลือก--</option>
                                    <option selected value="<?php echo $row['stay']; ?>"><?php echo $row['stay']; ?></option>
                                    <option>อยู่ตามทะเบียบบ้าน</option>
                                    <option>ไม่อยู่ตามทะเบียบบ้าน</option>
                                  </select>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">ตำแหน่งในบ้าน :<span class="required-star">*</span></label>
                                  <select name="m_rank" class="form-select" id="inputGroupSelect01" required>
                                    <option selected disabled>--กรุณาเลือก--</option>
                                    <option selected value="<?php echo $row['m_rank']; ?>"><?php echo $row['m_rank']; ?></option>
                                    <option>เจ้าบ้าน</option>
                                    <option>ผู้อาศัย</option>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <label class="col-form-label">บ้านเลขที่:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="home_no" value="<?php echo $row['home_no']; ?>" required>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">หมู่:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="swine" value="<?php echo $row['swine']; ?>" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <label class="col-form-label">จังหวัด:<span class="required-star">*</span></label>
                                  <select name="province_id" class="form-select" id="inputGroupSelect01" required>
                                    <option selected disabled>กรุณาเลือกจังหวัด</option>
                                    <option selected value="<?php echo $row['province_id']; ?> "><?php echo $row['pro']; ?></option>
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
                                  <input type="text" class="form-control" id="" name="amphure" value="<?php echo $row['amphure']; ?>" required>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">ตำบล:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="district" value="<?php echo $row['district']; ?>" required>
                                </div>
                                <div class="col">
                                  <label class="col-form-label">รหัสไปรษณีย์:<span class="required-star">*</span></label>
                                  <input type="text" class="form-control" id="" name="zip_code" value="<?php echo $row['zip_code']; ?>" required>
                                </div>
                              </div>
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

    <div class="modal fade" id="homeModal">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <b class="modal-title">เลือกที่อยู่ตามทะเบียนบ้าน</b>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <input class="form-control" id="myInput" type="text" placeholder="ค้นหา.."><br>
            <table class="table table-striped">
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
                </tr>
              </thead>
              <tbody id="myTable-home">
                <?php
                $stmt9 = $conn->prepare(
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
                             ad.district,
                             ad.zip_code
                             FROM 
                             address AS ad
                             JOIN 
                             provinces AS pro ON ad.province_id = pro.province_id 
                             "
                );
                $stmt9->execute();
                $result9 = $stmt9->fetchAll();

                if ($result9 != null) {
                  $i = 1;
                  foreach ($result9 as $row9) {
                ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row9['id_home']; ?></td>
                      <td><?php echo $row9['home_no']; ?></td>
                      <td><?php echo $row9['swine']; ?></td>
                      <td><?php echo $row9['amphure']; ?></td>
                      <td><?php echo $row9['district']; ?></td>
                      <td><?php echo $row9['pro']; ?></td>
                      <td>
                        <?php echo $row9['zip_code']; ?>
                      </td>
                      <td><?php echo $row9['home_type']; ?></td>
                      <td><a type="button" class="btn btn-primary" href="data.php?act=adhome&id_home=<?php echo $row9['id_home']; ?>">เลือก</a></td>
                    </tr>
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable-home tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    </script>
    <script>
      $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
  </body>

  </html>
<?php } ?>