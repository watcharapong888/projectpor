<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>" />
</head>

<body>
  <form action="action_page.php" method="post">
    <center>
      <h3>บ้านด่านขุนทดหมู่ที่ 8 </h3>
    </center>
    <div class="imgcontainer">
      <img src="home.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>ชื่อผู้ใช้</b></label>
      <input type="text" placeholder="กรุณาใส่ชื่อผู้ใช้" name="uname" required>

      <label for="psw"><b>รหัสผ่าน</b></label>
      <input type="password" placeholder="กรุณาใส่รหัสผ่าน" name="psw" required>

      <button type="submit">เข้าสู่ระบบ</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> จดจำฉัน
      </label>
    </div>

    <div class="container">
      <button type="button" class="cancelbtn">กลับไปที่หน้าหลัก</button>
      <span class="psw">ลืมรหัสผ่าน? <a href="#">เปลี่ยนรหัส</a></span>
    </div>
  </form>
</body>

</html>