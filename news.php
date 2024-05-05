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
  if (isset($_POST['post_id']) != null && isset($_POST['post_text']) != null && isset($_POST['post_date']) != null) {

    $stmt = $conn->prepare("INSERT INTO post
  (
    post_id,
    post_text,
    post_date,
    img_id,
    user_id,
  )
  VALUES
  (
  :post_id,
  :post_text,
  :post_date,
  :img_id,
  :user_id,
  )
");

    $stmt->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_STR);
    $stmt->bindParam(':post_text', $_POST['post_text'], PDO::PARAM_STR);
    $stmt->bindParam(':img_id', $_POST['img_id'], PDO::PARAM_STR);
    $stmt->bindParam(':post_date', $_POST['post_date'], PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $_POST['user_id'], PDO::PARAM_STR);

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
      isset($_POST['post_text']) && isset($_POST['img_id']) && isset($_POST['user_id'])
    ) {

      $post_text = $_POST['post_text'];
      $img_id = $_POST['img_id'];
      $user_id = $_POST['user_id'];
      $post_date = $_POST['post_date'];
      // SQL update
      $stmt = $conn->prepare("UPDATE post SET 
        post_text = :post_text, 
        img_id = :img_id,
        user_id = :user_id,
        post_date = :post_date,
        WHERE post_id = :post_id");

      $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindParam(':post_text', $post_text, PDO::PARAM_STR);
      $stmt->bindParam(':img_id', $img_id, PDO::PARAM_STR);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->bindParam(':post_date', $post_date, PDO::PARAM_STR);

      try {
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "แก้ไขข้อมูลสำเร็จ",
                          type: "success"
                      }, function() {
                          window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
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
                          window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
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
                      window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
  }

  if (@isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare('DELETE FROM post WHERE post_id=:post_id');
    $stmt->bindParam(':post_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      echo '<script>
           setTimeout(function() {
            swal({
                title: "ลบข้อมูลสำเร็จ",
                type: "success"
            }, function() {
                window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
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
                window.location = "news.php"; //หน้าที่ต้องการให้กระโดดไป
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
              <p>กิจกรรมและข่าวสารในชุมชน</p>
            </h3>
          </div>
        </div>
        <form method="post" action="news.php?act=add" enctype="multipart/form-data">
          <div class="container mt-3">
            <div class="row">
              <div class="col">
                <label class="col-form-label">ข้อความ:<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="" name="post_text" required>
              </div>
              <div class="col">
                <label class="col-form-label">รูปภาพ:<span class="required-star">*</span></label>
                <input type="file" class="form-control" id="" name="upload" required>
                <input type="submit" name="save" value="Upload" />
              </div>
              <?php
              $locate_img = "pic/";
              if (!is_dir($locate_img)) {
                mkdir($locate_img, 0777, true); // Creates the directory with read/write permissions
              }
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
                  $name_file = $_FILES['upload']['name'];
                  $tmp_name = $_FILES['upload']['tmp_name'];
                  $locate_img = "pic/";
                  // Ensure directory exists and has appropriate permissions
                  if (!is_dir($locate_img)) {
                    mkdir($locate_img, 0777, true); // Use the appropriate permissions for your server environment
                  }
                  if (move_uploaded_file($tmp_name, $locate_img . $name_file)) {
                    echo "File is valid, and was successfully uploaded.\n";
                  } else {
                    echo "Possible file upload attack or permission issue!\n";
                  }
                } else {
                  if (isset($_FILES['upload'])) {
                    echo "Upload failed with error code " . $_FILES['upload']['error'];
                  }
                }
              }



              ?>

            </div> <br>
            <div class="row">
              <center><input type="submit" class="btn btn-primary" value="เพิ่มข้อมูล"> <a href="news.php"
                  class="btn btn-secondary">ล้างข้อมูล</a></center>
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
                <th>ข้อความ</th>
                <th>ตัวอย่างรูป</th>
                <th>วันที่อัพโหลด</th>
                <th>อัพโหลดโดย</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $conn->prepare(
                "SELECT 
                   post_id,
                   post_text,
                   img_id,
                   post_date,
                   user_id	
                   FROM post "
              );
              $stmt->execute();
              $result = $stmt->fetchAll();

              if ($result != null) {
                $i = 1;
                foreach ($result as $row) {
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['post_text']; ?></td>
                    <td><?php echo $row['img_id']; ?></td>
                    <td><?php echo $row['post_date']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#myModal<?php echo $row['post_id']; ?>">แก้ไขข้อมูล</button></td>
                    <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#Modaldeletel<?php echo $row['post_id']; ?>">
                        ลบข้อมูล
                      </button></td>
                  </tr>
                  <div class="modal fade" id="Modaldeletel<?php echo $row['post_id']; ?>">
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
                          <a href="news.php?delete_id=<?php echo $row['post_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="myModal<?php echo $row['post_id']; ?>" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <p>แก้ไขโพสต์</p>
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="address.php?act=edit" method="post">
                            <input type="hidden" name="homeid" value="<?php echo $row['post_id']; ?>">
                            <label class="col-form-label">ข้อความ:<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="" name="post_text"
                              value="<?php echo $row['post_text']; ?>">

                            <label class="col-form-label">รูปภาพ:<span class="required-star">*</span></label>
                            <input type="file" class="form-control" id="" name="img_id"
                              value="<?php echo $row['img_id']; ?>">

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
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>