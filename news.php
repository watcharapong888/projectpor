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
        $imgData = file_get_contents($_FILES['upload']['tmp_name']);
        $imgType = $_FILES['upload']['type'];

        $sql_img = "INSERT INTO img (Img_name, img) VALUES (:imgType, :imgData)";
        $statement_img = $conn->prepare($sql_img);
        $statement_img->bindParam(':imgType', $imgType, PDO::PARAM_STR);
        $statement_img->bindParam(':imgData', $imgData, PDO::PARAM_LOB); 
        $statement_img->execute();
        $img_id = $conn->lastInsertId(); 

        $post_date = date('Y-m-d H:i:s'); 
        $sql_post = "INSERT INTO post (post_text, user_id, img_id, post_date) VALUES (:post_text, :user_id, :img_id, :post_date)";
        $statement_post = $conn->prepare($sql_post);
        $statement_post->bindParam(':post_text', $_POST['post_text'], PDO::PARAM_STR);
        $statement_post->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $statement_post->bindParam(':post_date', $post_date, PDO::PARAM_STR); 
        $statement_post->bindParam(':img_id', $img_id, PDO::PARAM_INT); 
        $result = $statement_post->execute();

        if ($result) {
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
                   po.img_id,
                   img.img as img,
                   post_date,
                   user_id	
                   FROM post as po
                   join 
                   img as img ON po.img_id = img.img_id"
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
                      <td><img width="100px" height="100px" src="data:<?php echo $row['img_id']; ?>;base64,<?php echo base64_encode($row['img']); ?>" alt="Image"></td>
                      <td><?php echo $row['post_date']; ?></td>
                      <td><?php echo $row['user_id']; ?></td>
                      <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $row['post_id']; ?>">แก้ไขข้อมูล</button></td>
                      <td> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modaldeletel<?php echo $row['post_id']; ?>">
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

                    <div class="modal fade" id="myModal<?php echo $row['post_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <input type="text" class="form-control" id="" name="post_text" value="<?php echo $row['post_text']; ?>">

                              <label class="col-form-label">รูปภาพ:<span class="required-star">*</span></label>
                              <input type="file" class="form-control" id="" name="img_id" value="<?php echo $row['img_id']; ?>">

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
<?php } ?>