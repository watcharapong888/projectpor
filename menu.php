<?php session_start();
// print_r($_SESSION);
// $user_name = $_SESSION['user_name'];
// $user_lname = $_SESSION['user_lname'];
// $user_rank = $_SESSION['user_rank'];
// if ($_SESSION['user_name'] == '' || $_SESSION['user_name'] == null) {
//   header("Location: login.php"); // ทำการ redirect ไปยังหน้า login.php
//   exit; // จบการทำงานของสคริปต์
// }
?>

<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="fstdropdown/fstdropdown.js"></script>
<link rel="stylesheet" href="fstdropdown/fstdropdown.css">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script> -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<style>
  @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap');

  * {
    font-family: "IBM Plex Sans Thai", sans-serif;
    font-weight: 600;
    font-style: normal;
  }

  .bartop {
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .btn-login a {
    justify-content: center;
    display: flex;
    align-items: center;
    width: 100px;
    height: 50px;
    background-color: blue;
    text-decoration: none;
    color: white;
    border-radius: 40PX;
  }
</style>
<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">ย้อนกลับ &times;</button>
  <p style="font-size: 15pt;" class="w3-bar-item">สวัสดีผู้ใช้งาน</p>
  <p class="w3-bar-item" style="color: green;"></p>
  <a href="Index.php" class="w3-bar-item w3-button">หน้าแรก</a>
  <a href="address.php" class="w3-bar-item w3-button">ข้อมูลครัวเรือน</a>
  <a href="data.php" class="w3-bar-item w3-button">ข้อมูลคนในชุมชน</a>
  <a href="#services" class="w3-bar-item w3-button">โรคประจำตัว</a>
  <a href="news.php" class="w3-bar-item w3-button">กิจกรรมและข่าวสารประจำเดือน</a>
  <a href="logout.php" class="w3-bar-item w3-button" style="color: red;">ออกจากระบบ</a>
</div>

<div id="main">

  <div class="w3-teal ">
    <button id="openNav" class="w3-button w3-teal w3-xlarge print-button" onclick="w3_open()">&#9776;</button>
    <div class="bartop">
      <div>
        <h4>
          <a>ระบบจัดการข้อมูลคนในชุมชน</a>
        </h4>
      </div>
      <div class="btn-login"><a href="login.php">เข้าสู่ระบบ</a></div>
    </div>
  </div>


  <script>
    function w3_open() {
      document.getElementById("main").style.marginLeft = "250px";
      document.getElementById("mySidebar").style.width = "250px";
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("openNav").style.display = 'none';
    }

    function w3_close() {
      document.getElementById("main").style.marginLeft = "0%";
      document.getElementById("mySidebar").style.display = "none";
      document.getElementById("openNav").style.display = "inline-block";
    }
    var select_box_element = document.querySelector('#select_box');

    dselect(select_box_element, {
      search: true
    });
  </script>