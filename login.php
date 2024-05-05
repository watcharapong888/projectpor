<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>เข้าสู่ระบบ</title>
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap');

  * {
    font-family: "IBM Plex Sans Thai", sans-serif;
    font-weight: 600;
    font-style: normal;
  }

  .box {
    padding: 20px;
    width: 50vh;
  }
</style>

<body>
<?php 
 print_r($_POST);
?>
  <div class="container mt-3 box card">
    <h2>
      <p>บ้านด่านขุนทดหมู่ที่ 8</p>
    </h2>
    <img src="img/bg-login.jpg" alt="">
    <form method="post">
      <div class="mb-3 mt-3">
        <label for="text">ชื่อผู้ใช้:</label>
        <input type="text" class="form-control" id="username" placeholder="กรุณาใส่ชื่อผู้ใช้" name="username" required>
      </div>
      <div class="mb-3">
        <label for="pwd">รหัสผ่าน:</label>
        <input type="password" class="form-control" id="pwd" placeholder="กรุณาใส่รหัสผ่าน" name="password" required>
      </div>
      <div class="form-check mb-3">
        <label class="form-check-label">
          <input class="form-check-input" type="checkbox" name="remember"> จดจำฉัน
        </label>
      </div>
      <center>
        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
      </center>
    </form>
  </div>
  <center>
    <br><p>?</p>
    <a href="Index.php" type="button" class="btn btn-light" style="text-decoration: none;">กลับไปที่หน้าหลัก</a>
  </center>
</body>
<?php
    if(isset($_POST['username']) && isset($_POST['password']) ){
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
 
    require_once 'db.php';
    $username = $_POST['username'];
    $password = $_POST['password']; 
 
      $stmt = $conn->prepare("SELECT * FROM user WHERE user = :username AND password = :password");
      $stmt->bindParam(':username', $username , PDO::PARAM_STR);
      $stmt->bindParam(':password', $password , PDO::PARAM_STR);
      $stmt->execute();
 
      if($stmt->rowCount() == 1){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['user_lname'] = $row['user_lname'];
        $_SESSION['user_rank'] = $row['user_rank'];

        echo '<script>window.location.href = "Index.php";</script>';
      }else{ 
         echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                             text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
              $conn = null; 
            } 
    }
    ?>
</html>