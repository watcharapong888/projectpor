<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ชุมชนด่านขุนทด</title>
</head>

<body>
  <?php include 'menu.php' ?>
  <br>
  <div class="showall">
    <div class="show">
      <center>
        <h3>
          <p>ข่าวสารประจำเดือน</p>
        </h3>
      </center>
      <div class="container mt-3">
        <nav class="navbar navbar-light justify-content-between">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">เพิ่มข่าวสารประจำเดือน</button>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </nav>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr class="table-primary">
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
</body>

</html>