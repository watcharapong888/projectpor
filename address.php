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
      <center>
        <h3>
          <p>ข้อมูลครัวเรือน</p>
        </h3>
      </center>
      <nav class="navbar navbar-light justify-content-between">
        <button style="width: auto;"><a href="addaddress.php" class="btn btn-info">เพิ่มที่ครัวเรือนใหม่</a></button>
        <form class="form-inline">
          <input type="text" name="itemname" id="itemname" autocomplete="off" class="form-control mr-sm-2" id="#live_search" placeholder="ค้นหาครัวเรือน" />
          <button type="button" id="btnSearch" class="btn btn-outline-success my-2 my-sm-0">
            ค้นหา
          </button>
          <script type="text/javascript" src="jquery-1.11.2.min.js"></script>

        </form>
      </nav>
      <br />
      <table>
        <thead>
          <tr>
            <th scope="col">รหัสบ้าน</th>
            <th scope="col">บ้านเลขที่</th>
            <th scope="col">หมู่</th>
            <th scope="col">ตำบล</th>
            <th scope="col">อำเภอ</th>
            <th scope="col">จังหวัด</th>
            <th scope="col">ประเภทบ้าน</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';
          $query = "SELECT home_id,home_no,swine,subdistrict,district,province,home_type
                        FROM subdistrict AS sub,district AS di,provinces AS pro,address AS ad
                        WHERE ad.subdistrict_id = sub.subdistrict_id AND ad.district_id = di.district_id AND ad.province_id = pro.province_id limit 150";
          $result = mysqli_query($dbCon, $query);
          ?>
          <?php if ($result->num_rows > 0) : ?>
            <?php while ($array = mysqli_fetch_row($result)) : ?>
              <tr>
                <td scope="row"><?php echo $array[0]; ?></td>
                <td><?php echo $array[1]; ?></td>
                <td><?php echo $array[2]; ?></td>
                <td><?php echo $array[3]; ?></td>
                <td><?php echo $array[4]; ?></td>
                <td><?php echo $array[5]; ?></td>
                <td><?php echo $array[6]; ?></td>
                <td style="width: 450px">
                  <button type="button" class="btn btn-primary">เพิ่มสมาชิกครัวเรือน</button>
                  <button type="button" class="btn btn-success">ดูข้อมูล</button>
                  <a href="editaddress.php? id=<?=$array[0]; ?>" class="btn btn-warning edit">แก้ไขข้อมูล</a>
                  <a href="javascript:void(0)" class="btn btn-danger delete" data-id="<?php echo $array[0]; ?>">ลบข้อมูล</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" rowspan="1" headers="">ไม่มีข้อมูล</td>
            </tr>
          <?php endif; ?>
          <?php mysqli_free_result($result); ?>
        </tbody>
      </table>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function($) {
      $('#addNewUser').click(function() {
        $('#userInserUpdateForm').trigger("reset");
        $('#userModel').html("Add New User");
        $('#user-model').modal('show');
      });
      $('body').on('click', '.delete', function() {
        if (confirm("Delete Record?") == true) {
          var id = $(this).data('id');
          // ajax
          $.ajax({
            type: "POST",
            url: "delete.php",
            data: {
              id: id
            },
            dataType: 'json',
            success: function(res) {
              $('#home_id').html(res.home_id);
              $('#home_no').html(res.home_no);
              $('#swine').html(res.swine);
              $('#subdistrict').html(res.subdistrict);
              $('#district').html(res.district);
              $('#province').html(res.province);
              $('#home_type').html(res.home_type);
              window.location.reload();
            }
          });
        }
      });
    });
    const logoutBtn = document.querySelector('.logout-btn');
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      // ทำการออกจากระบบที่นี่
      alert('ออกจากระบบแล้ว');
    });
  </script>
  </script>
</body>

</html>