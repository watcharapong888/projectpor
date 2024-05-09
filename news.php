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
    }
  </style>

  <body>
    <?php
    require_once 'db.php';
    print_r($_POST);
    if (count($_FILES) > 0) {
      if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $post_date = date('Y-m-d H:i:s');
        $sql_post = "INSERT INTO post 
        (
          post_text, 
          user_id, 
          post_date
        ) 
        VALUES 
        (
          :post_text, 
          :user_id, 
          :post_date
        )";
        $statement_post = $conn->prepare($sql_post);
        $statement_post->bindParam(':post_text', $_POST['post_text'], PDO::PARAM_STR);
        $statement_post->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $statement_post->bindParam(':post_date', $post_date, PDO::PARAM_STR);
        $result = $statement_post->execute();
        $post_id  = $conn->lastInsertId();

        if (@$_POST['img_post_id'] != null || @$_POST['img_post_id'] != '') {
          $img_post_id = @$_POST['img_post_id'];
        } else {
          $img_post_id = $post_id;
        }

        $imgData = file_get_contents($_FILES['upload']['tmp_name']);
        $imgType = $_FILES['upload']['type'];
        $sql_img = "INSERT INTO img 
        (
          Img_name,
          img_post_id, 
          status_img, 
          img
        ) 
        VALUES 
        (
          :imgType, 
          :img_post_id, 
          :status_img, 
          :imgData
        )";
        $statement_img = $conn->prepare($sql_img);
        $statement_img->bindParam(':imgType', $imgType, PDO::PARAM_STR);
        $statement_img->bindParam(':img_post_id', $img_post_id, PDO::PARAM_STR);
        $statement_img->bindParam(':status_img', $_POST['status_img'], PDO::PARAM_STR);
        $statement_img->bindParam(':imgData', $imgData, PDO::PARAM_LOB);
        $statement_img->execute();

        if ($statement_img) {
          echo '<script>
         setTimeout(function() {
           swal({
           title: "เพิ่มข้อมูลสำเร็จ",
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
                  <textarea type="text" class="form-control" id="" name="post_text"></textarea>
                </div>
              </div>
              <!-- <div class="row">
                <div class="col">
                  <label class="col-form-label">รูปแบบโพสต์:<span class="required-star">*</span></label>
                  <select name="status_img" class="form-select" id="inputGroupSelect01" required>
                    <option selected disabled>--กรุณาเลือก--</option>
                    <option>โพสต์รูปเดียว</option>
                    <option>โพสต์หลายรูป</option>
                  </select>
                </div>
              </div> -->
              <input type="hidden" name="status_img" value="โพสต์รูปเดียว">
              <div class="row">
                <div class="col">
                  <label class="col-form-label">รูปภาพ:<span class="required-star">*</span></label>
                  <input type="file" class="form-control" id="" name="upload" required>
                </div>
              </div> <br>
              <div class="row">
                <center><input type="submit" class="btn btn-primary" value="เพิ่มข้อมูล"> <a href="news.php" class="btn btn-secondary">ล้างข้อมูล</a></center>
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
                  <!-- <th>โพสต์ไอดี</th> -->
                  <th>ข้อความ</th>
                  <!-- <th>ตัวอย่างรูป</th> -->
                  <!-- <th>วันที่อัพโหลด</th>-->
                  <!-- <th>รูปแบบโพสต์</th> -->
                  <th>อัพโหลดโดย</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $conn->prepare(
                  "SELECT 
                  po.post_id AS post_id,
                  po.post_text,
                  img.img AS img,
                  img.img_id,
                  img.status_img,
                  po.post_date,
                  po.user_id,
                  us.user_name as username
              FROM 
                  post AS po
              JOIN 
                  img AS img ON po.post_id = img.img_post_id
              JOIN 
                  user AS us ON po.user_id  = us.user_id 
              WHERE
                  img.img_id IN (
                      SELECT MIN(img_id) 
                      FROM img 
                      WHERE img_post_id = po.post_id
                  );
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
                      <!-- <td><?php echo $row['post_id']; ?></td> -->
                      <td><?php echo $row['post_text']; ?></td>
                      <!-- <td><img width="100px" height="100px" src="data:<?php echo $row['img_id']; ?>;base64,<?php echo base64_encode($row['img']); ?>" alt="Image"></td> -->
                      <!-- <td><?php echo $row['post_date']; ?></td> -->
                      <!-- <td><?php echo $row['status_img']; ?></td> -->
                      <td><?php echo $row['username']; ?></td>
                      <td> <a href="news-edit.php?post_id=<?php echo $row['post_id']; ?>&post_text=<?php echo $row['post_text']; ?>&status_img=<?php echo $row['status_img']; ?>" class="btn btn-warning">แก้ไข</a>
                      </td>
                      <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['post_id']; ?>">
                          ลบ
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
<?php } ?>