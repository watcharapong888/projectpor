<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="all.css?v=<?php echo time(); ?>" />
  <title>ชุมชนด่านขุนทด</title>
</head>

<body>
  <div class="sidebar">
    <h2>สวัสดีผู้ใช้งาน</h2>
    <ul>
      <li><a href="Index.php">หน้าแรก</a></li>
      <li><a href="address.php">ข้อมูลครัวเรือน</a></li>
      <li><a href="data.php">ข้อมูลคนในชุมชน</a></li>
      <li><a href="#services">โรคประจำตัว</a></li>
      <li><a href="news.php">ข่าวสารประจำเดือน</a></li>
      <li><a href="#" class="logout-btn">ออกจากระบบ</a></li>
      <ul>
  </div>
  <div class="showall">
    <div class="show">


    </div>
  </div>
  <script>
    // ใช้ JavaScript เพื่อเพิ่มการดักการคลิกปุ่ม "ออกจากระบบ"
    const logoutBtn = document.querySelector('.logout-btn');
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      // ทำการออกจากระบบที่นี่
      alert('ออกจากระบบแล้ว');
    });
  </script>
</body>

</html>