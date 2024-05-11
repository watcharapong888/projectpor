<?php include 'menu.php';   ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ชุมชนด่านขุนทด</title>
  <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e9ecef;
      font-family: 'Arial', sans-serif;
      color: #333;
    }

    .navbar {
      margin-bottom: 20px;
      background-color: #007bff;
      color: #ffffff;
    }

    .navbar a {
      color: #ffffff;
    }

    .showall {
      height: auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border: none;
    }

    .card-header {
      background-color: #726e5e;
      color: #ffffff;
      border-bottom: none;
    }

    .post {
      width: 50%;
      background: #ffffff;
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
    }

    .post:hover {
      transform: translateY(-5px);
    }

    .post img {
      max-width: 100%;
      height: auto;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .post p {
      font-size: 16px;
    }

    iframe {
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .box-post1 {
      padding: 10px;
      background-color: #f0f0f0;
      border-radius: 20px;
      width: 100%;
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
</head>

<body>
  <?php require_once 'db.php'; ?>

  <div class="showall container">
    <div class="card mb-4">
      <h3 class="card-header">Dashboard</h3>
      <div class="card-body">
      <iframe title="project" width="100%"  height="650" src="https://app.powerbi.com/view?r=eyJrIjoiYmQ0N2NhNjUtMGI1MC00YzcwLWJkZTEtOWUzYmJjNDc3NGFhIiwidCI6IjczM2UyY2UwLWNlMjgtNGRmYS04YWY2LWFkNTdiMzcwOTBjZSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
      </div>
    </div>
    <div class="posts">
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
        img.img_id = (SELECT MIN(img_id) FROM img WHERE img_post_id = po.post_id)
    ORDER BY 
    post_id DESC;    
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
          if ($status_img == 'โพสต์หลายรูป') {
          ?>
          <div class="box-post1" >
            <p style="text-align: center;"><?php echo $row['post_text']  ?></p>
          </div><br>
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

</body>

</html>