<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ชุมชนด่านขุนทด</title>
</head>

<body>
  <?php include 'menu.php' ?>
  <br>
  <div class="showall">
    <div class="show">
      <center>
        <h3>
          <p>ข้อมูลครัวเรือน</p>
        </h3>
      </center>
      <div class="container mt-3">
        <nav class="navbar navbar-light justify-content-between">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">เพิ่มที่ครัวเรือนใหม่</button>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </nav>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr class="table-success">
                <th>ลำดับ</th>
                <th>รหัสบ้าน</th>
                <th>บ้านเลขที่</th>
                <th>หมู่</th>
                <th>ตำบล</th>
                <th>อำเภอ</th>
                <th>จังหวัด</th>
                <th>ประเภทบ้าน</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              require_once 'db.php';
              $stmt = $conn->prepare("SELECT 
                   ad.home_id,
                   ad.home_no,
                   ad.swine,
                   aph.name_th as aph,
                   di.name_th as di,
                   pro.name_th as pro,
                   ad.home_type
                   FROM 
                   address AS ad
                   JOIN 
                   amphures AS aph ON ad.amphure_id = aph.amphure_id 
                   JOIN 
                   districts AS di ON ad.district_id = di.district_id 
                   JOIN 
                   provinces AS pro ON ad.province_id = pro.province_id 
                   ");
              $stmt->execute();
              $result = $stmt->fetchAll();

              if ($result != null) {
                $i = 1;
                foreach ($result as $row) {
              ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['home_id']; ?></td>
                    <td><?php echo $row['home_no']; ?></td>
                    <td><?php echo $row['swine']; ?></td>
                    <td><?php echo $row['aph']; ?></td>
                    <td><?php echo $row['di']; ?></td>
                    <td><?php echo $row['pro']; ?></td>
                    <td><?php echo $row['home_type']; ?></td>
                    <td><button type="button" class="btn btn-success">ดูข้อมูล</button></td>
                    <td> <a href="editaddress.php? id=<?= $array[0]; ?>" class="btn btn-warning edit">แก้ไขข้อมูล</a></td>
                    <td> <a href="javascript:void(0)" class="btn btn-danger delete" data-id="<?php echo $array[0]; ?>">ลบข้อมูล</a></td>
                  </tr>
                <?php }
                $i++;
              } else { ?>
                  <tr>
                    <td colspan="11" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
                  </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มครัวเรือน</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <label class="col-form-label">รหัสบ้าน:</label>
            <input type="text" class="form-control" id="">

            <label class="col-form-label">บ้านเลขที่:</label>
            <input type="text" class="form-control" id="">

            <label class="col-form-label">หมู่:</label>
            <input type="text" class="form-control" id="">

            <label class="col-form-label">จังหวัด:</label>
            <select class="form-select" id="inputGroupSelect01">
              <option selected>กรุณาเลือกจังหวัด</option>
              <?php $stmt2 = $conn->prepare("SELECT  * FROM provinces ORDER BY name_th  ASC; ");
              $stmt2->execute();
              $result2 = $stmt2->fetchAll();
              foreach ($result2 as $row2) {
              ?>
                <option value="<?php echo $row2['province_id']; ?>"><?php echo $row2['name_th']; ?></option>
              <?php } ?>
            </select>

            <label class="col-form-label">อำเภอ:</label>
            <select class="form-select" id="inputGroupSelect01">
              <option selected>กรุณาเลือกอำเภอ</option>
              <?php $stmt3 = $conn->prepare("SELECT  amphure_id,name_th FROM amphures ORDER BY name_th  ASC; ");
              $stmt3->execute();
              $result3 = $stmt3->fetchAll();
              foreach ($result3 as $row3) {
              ?>
                <option value="<?php echo $row3['amphure_id']; ?>"><?php echo $row3['name_th']; ?></option>
              <?php }  ?>
            </select>

            <label class="col-form-label">ตำบล:</label>
            <input type="text" class="form-control" id="">

            <label class="col-form-label">รหัสไปรษณีย์:</label>
            <input type="text" class="form-control" id="">

            <label class="form-label">ประเภทบ้าน:</label>
            <input type="text" class="form-control" id="">

            <label class="col-form-label">ตำแหน่งของบ้าน:</label>
            <input type="text" class="form-control" id="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
          <button type="button" class="btn btn-primary">เพิ่มข้อมูล</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>