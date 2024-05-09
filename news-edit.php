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
  $path_post_id = $_GET['post_id'];
  $post_text = $_GET['post_text'];
  $status_img = $_GET['status_img'];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ชุมชนด่านขุนทด</title>
  </head>
  <style>
    .showall {
      margin-left: auto;
      margin-right: auto;
      width: 80%;
    }

    .posts {
      margin-left: auto;
      margin-right: auto;
      width: 80%;
    }

    .box-post2 {
      padding: 10px;
      background-color: #f0f0f0;
      border-radius: 20px;
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
  </style>

  <body>
    <?php
    require_once 'db.php';
    // print_r($_POST);
    // print_r($_FILES);
    if (count($_FILES) > 0) {
      if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $post_date = date('Y-m-d H:i:s');
        $sql_post = "UPDATE post SET
          post_text = :post_text, 
          user_id =   :user_id, 
          post_date = :post_date
          WHERE post_id = $path_post_id
        ";
        $statement_post = $conn->prepare($sql_post);
        $statement_post->bindParam(':post_text', $_POST['post_text'], PDO::PARAM_STR);
        $statement_post->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $statement_post->bindParam(':post_date', $post_date, PDO::PARAM_STR);
        $result = $statement_post->execute();

        $img_post_id = $_POST['img_post_id'];
        $imgData = file_get_contents($_FILES['upload']['tmp_name']);
        $imgType = $_FILES['upload']['type'];
        $sql_img = "UPDATE img SET 
          Img_name = :imgType, 
          img_post_id = :img_post_id, 
          status_img = :status_img, 
          img = :imgData
          WHERE img_post_id = $path_post_id
        ";
        $statement_img = $conn->prepare($sql_img);
        $statement_img->bindParam(':imgType', $imgType, PDO::PARAM_STR);
        $statement_img->bindParam(':img_post_id', $img_post_id, PDO::PARAM_STR);
        $statement_img->bindParam(':status_img', $_POST['status_img'], PDO::PARAM_STR);
        $statement_img->bindParam(':imgData', $imgData, PDO::PARAM_LOB);
        try {
          $statement_img->execute();
        } catch (PDOException $e) {
          echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "เกิดข้อผิดพลาด",
                      text: "' . $e->getMessage() . '",
                      type: "error"
                  }, function() {
                      window.location = "news-edit.php"; //หน้าที่ต้องการให้กระโดดไป
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
          <form method="post" action="" enctype="multipart/form-data">
            <div class="container mt-3">
              <div class="row">
                <div class="col">
                  <label class="col-form-label">โพสต์ไอดี:<span class="required-star">*</span></label>
                  <input type="text" class="form-control" id="" value="<?php echo  $path_post_id ?>" disabled>
                  <input type="hidden" name="img_post_id" value="<?php echo  $path_post_id ?>">
                </div>
                <div class="col">
                  <!-- <label class="col-form-label">รูปแบบโพสต์:<span class="required-star">*</span></label>
                  <input type="text" class="form-control" id="" value="<?php echo  $status_img ?>" disabled>-->
                  <input type="hidden" name="status_img" value="<?php echo  $status_img ?>"> 
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="col-form-label">ข้อความ:<span class="required-star">*</span></label>
                  <textarea type="text" rows="10" class="form-control" id="" name="post_text"><?php echo  $post_text ?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="col-form-label">รูปภาพ:<span class="required-star">*</span></label>
                  <input type="file" class="form-control" id="" name="upload" required>
                </div>
              </div> <br>
              <div class="row">
                <center><input type="submit" class="btn btn-warning" value="แก้ไขข้อมูล"> </center>
              </div>
            </div>
          </form>
        </div>
        <div class="posts">
          <p style="color: red; font-size:20pt;">Ex.ทดสอบ</p>
          <?php
          $stmt = $conn->prepare(
            "SELECT 
            po.post_id AS post_id,
            post_text,
            img.img AS img,
            post_date,
            img.img_post_id AS img_post_id,
            img.status_img AS status_img,
            user_id
        FROM 
            post AS po
        JOIN 
            img AS img ON po.post_id = img.img_post_id
        WHERE 
            img.img_id = (SELECT MIN(img_id) FROM img WHERE img_post_id = $path_post_id);
        
        "
          );
          $stmt->execute();
          $result = $stmt->fetchAll();

          if ($result != null) {
            foreach ($result as $row) {
              $status_img = $row['status_img'];
              $post_id = $row['post_id'];

              // ตรวจสอบค่า status_img และแสดงข้อมูลที่ตรงกับเงื่อนไข
              if ($status_img == 'โพสต์หลายรูป') {
                $stmt2 = $conn->prepare(
                  "SELECT 
             i.img_id,
             i.Img_name,
             i.img,
             i.img_post_id,
             p.post_text,
             i.status_img
             FROM img as i
             join post as p on i.img_post_id = p.post_id
             where status_img = :status_img 
             and img_post_id = :post_id;"
                );
                $stmt2->bindParam(':status_img', $status_img, PDO::PARAM_STR);
                $stmt2->bindParam(':post_id', $post_id, PDO::PARAM_STR);
                $stmt2->execute();
                $result2 = $stmt2->fetchAll();
          ?>
                <div id="box" class="gallery js-flickity" data-flickity-options='{ "wrapAround": true }'>
                  <?php
                  if ($result2 != null) {
                    foreach ($result2 as $row2) { ?>
                      <img src="data:<?php echo $row2['img_id']; ?>;base64,<?php echo base64_encode($row2['img']); ?>" alt="Los Angeles" class="d-block" style="width: 100%;">
                  <?php
                    }
                  }
                  ?>
                </div> <br><br>
              <?php
              }

              if ($status_img == 'โพสต์รูปเดียว') {
                $stmt2 = $conn->prepare(
                  "SELECT 
             i.img_id,
             i.Img_name,
             i.img,
             i.img_post_id,
             p.post_text,
             i.status_img
             FROM img as i
             join post as p on i.img_post_id = p.post_id
             where status_img = :status_img 
             and img_post_id = :post_id;"
                );
                $stmt2->bindParam(':status_img', $status_img, PDO::PARAM_STR);
                $stmt2->bindParam(':post_id', $post_id, PDO::PARAM_STR);
                $stmt2->execute();
                $result2 = $stmt2->fetchAll();
              ?>

                <?php
                if ($result2 != null) {
                  foreach ($result2 as $row2) { ?>
                    <div class="box-post2">
                      <div style="width: 49.5%;">
                        <img src="data:<?php echo $row2['img_id']; ?>;base64,<?php echo base64_encode($row2['img']); ?>" alt="Los Angeles" style="width: 100%;">
                      </div>
                      <div style="width: 49.5%;">
                        <p> <?php echo htmlspecialchars($row2['post_text']); ?></p>
                      </div>
                    </div><br>
                <?php

                  }
                }
                ?>

            <?php
              }
            }
          } else { ?>
            <p style="text-align: center; color:red;">ไม่มีข้อมูล</p>
          <?php } ?>
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