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
          <p>ข่าวสารประจำเดือน</p>
        </h3>
      </center>

      <nav class="navbar navbar-light justify-content-between"><button type="button" id="addNewUser" class="btn btn-info">เพิ่มข่าวสารประจำเดือน</button>
        <form class="form-inline">
          <input class="form-control mr-sm-2" type="search" placeholder="ค้นหาข่าวสาร" aria-label="Search" />
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            ค้นหา
          </button>
        </form>
      </nav>
      <br>

      <table>
        <thead>
          <tr>
            <th scope="col">รหัสข่าว</th>
            <th scope="col" style="width:750px;">ข้อความ</th>
            <th scope="col">วันเดือนปีที่ลง</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';
          $query = "SELECT news_id,news_text,news_date FROM news limit 150";
          $result = mysqli_query($dbCon, $query);
          ?>
          <?php if ($result->num_rows > 0) : ?>
            <?php while ($array = mysqli_fetch_row($result)) : ?>
              <tr>
                <td scope="row"><?php echo $array[0]; ?></td>
                <td><?php echo $array[1]; ?></td>
                <td><?php echo $array[2]; ?></td>
                <td>
                  <a href="javascript:void(0)" class="btn btn-warning edit" data-id="<?php echo $array[0]; ?>">แก้ไขข้อมูล</a>
                  <a href="javascript:void(0)" class="btn btn-danger delete" data-id="<?php echo $array[0]; ?>">ลบข้อมูล</a>
              </tr>
            <?php endwhile; ?>
          <?php else : ?>
            <tr>
              <td colspan="3" rowspan="1" headers="">ไม่มีข้อมูล</td>
            </tr>
          <?php endif; ?>
          <?php mysqli_free_result($result); ?>
        </tbody>
      </table>
    </div>
    <!-- boostrap model -->
    <div class="modal fade" id="user-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <form action="javascript:void(0)" id="userInserUpdateForm" name="userInserUpdateForm" class="form-horizontal" method="POST">
              <input type="hidden" name="news_id" id="news_id">
              <div class="form-group">
                <label for="exampleFormControlTextarea1" class="col-sm control-label">รายละเอียดข่าวประชาสัมพันธ์</label>
                <div class="col">
                  <textarea type="text" class="form-control" id="news_text" name="news_text" placeholder="กรุณาเพิ่มข่าวสาร" value="" required=""></textarea>
                </div>
              </div>

              <div class="input-group justify-content-around">
                <button class="btn btn-danger" type="reset" value="Reset">ล้างข้อมูล</button>
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewUser">บันทึกข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function($) {
      $('#addNewUser').click(function() {
        $('#userInserUpdateForm').trigger("reset");
        $('#userModel').html("Add New User");
        $('#user-model').modal('show');
      });
      $('body').on('click', '.edit', function() {
        var id = $(this).data('id');
        // ajax
        $.ajax({
          type: "POST",
          url: "editnews.php",
          data: {
            id: id
          },
          dataType: 'json',
          success: function(res) {
            $('#userModel').html("Edit User");
            $('#user-model').modal('show');
            $('#news_text').html(res.news_text);
          }
        });
      });
      $('body').on('click', '.delete', function() {
        if (confirm("Delete Record?") == true) {
          var id = $(this).data('id');
          // ajax
          $.ajax({
            type: "POST",
            url: "deletenews.php",
            data: {
              id: id
            },
            dataType: 'json',
            success: function(res) {
              $('#news_id').html(res.news_id);
              $('#user_id ').html(res.user_id);
              $('#news_text').html(res.news_text);
              $('#news_date').html(res.news_date);
              window.location.reload();
            }
          });
        }
      });
      $('#userInserUpdateForm').submit(function() {
        // ajax
        $.ajax({
          type: "POST",
          url: "insert-updatenews.php",
          data: $(this).serialize(), // get all form field value in 
          dataType: 'json',
          success: function(res) {
            window.location.reload();
          }
        });
      });
    });

    // ใช้ JavaScript เพื่อเพิ่มการดักการคลิกปุ่ม "ออกจากระบบ"
    const logoutBtn = document.querySelector('.logout-btn');
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      // ทำการออกจากระบบที่นี่
      alert('ออกจากระบบแล้ว');
    });
  </script>
  </div>
  </div>
</body>

</html>