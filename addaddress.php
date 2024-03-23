<?php
include('db.php');
$sql = "SELECT * FROM provinces";
$query = mysqli_query($dbCon, $sql);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" a href="CSS/bootstrap.css" />
	<link rel="stylesheet" href="all.css?v=<?php echo time(); ?>">

	<title>เพิ่มครัวเรือน</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 m-auto">
				<div class="card mt-5">
					<div class="card-title">
						<h3 class="bg-dark text-white text-center py-3">เพิ่มครัวเรือน</h3>
						<div class="card-body">
							<form action="insert.php" method="post">
								<div class="form-group mb-2">
									<div><label>รหัสบ้าน</label></div>
									<div><input class="form-control mb-2" type="text" id="home_id" name="home_id" value="" placeholder="กรุณาใส่รหัสบ้าน" MAXLENGTH=11 required></div>
								</div>
								<div class="form-group mb-2">
									<div><label>เลขที่บ้าน</label></div>
									<div><input class="form-control mb-2" type="text" id="home_no" name="home_no" value="" placeholder="กรุณาใส่เลขที่บ้านตามทะเบียนบ้าน" required></div>
								</div>
								<div class="form-group mb-2">
									<div><label>หมู่</label></div>
									<div><input class="form-control mb-2" type="text" id="swine" name="swine" value="" placeholder="กรุณาใส่หมู่ตามทะเบียนบ้าน(ถ้าไม่มีให้ว่างไว้)"></div>
								</div>
								<div class="form-group mb-2">
									<div><label>จังหวัด</label></div>
									<div><select class="form-select" name="provinces" id="provinces" required>
											<option value="" selected disabled>กรุณาเลือกจังหวัด</option>
											<?php foreach ($query as $value) { ?>
												<option value="<?= $value['province_id'] ?>"><?= $value['province'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group mb-2">
									<div><label>อำเภอ</label></div>
									<div><select class="form-select" name="district" id="district" required>
										</select></div>

								</div>
								<div class="form-group mb-2">
									<div><label>ตำบล</label></div>
									<select class="form-select" name="subdistrict" id="subdistrict" required>
									</select>
								</div>
								<div class="form-group mb-2">
									<div><label>รหัสไปรษณีย์</label></div>
									<div> <input class="form-control mb-2" type="text" id="code" name="code" value="" required></div>
								</div>
								<div class="form-group mb-2">
									<div><label>ประเภทบ้าน</label></div>
									<div>
										<select class="form-select" name="home_type" id="home_type" required>
											<option selected>กรุณาเลือกประเภทบ้าน</option>
											<option value="บ้านส่วนตัว">บ้านส่วนตัว</option>
											<option value="บ้านเช่า">บ้านเช่า</option>
										</select>
									</div>
								</div>

								<div class="form-group mb-2">
									<div><label>ตำแหน่งของบ้าน</label></div>
									<div><input class="form-control mb-2" type="text" id="latitude" name="latitude" value="" placeholder="กรุณาใส่ละติจูด" required>
									</div>
									<div class="form-group mb-2">
										<div><label>ตำแหน่งของบ้าน</label></div>
										<div><input class="form-control mb-2" type="text" id="longitude" name="longitude" value="" placeholder="กรุณาใส่ลองติจูด" required>
										</div>
										<div class="input-group justify-content-around">
											<div><button class="btn btn-warning" type="button" onclick="history.back()" value="ย้อนกลับ">ย้อนกลับ</button></div>
											<div><button class="btn btn-danger" type="reset" value="Reset">ล้างข้อมูล</button></div>
											<div><button class="btn btn-success" name="submit">เพิ่มครัวเรือนใหม่</button></div>
										</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$('#provinces').change(function() {
				var id = $(this).val();
				$.ajax({
					url: "insert.php",
					type: "POST",
					data: {
						id: id,
						function: 'provinces'
					},
					success: function(data) {
						$('#district').html(data);
						$('#subdistrict').html('');
						$('#code').val('');
					}
				});
			});
			$('#district').change(function() {
				var district = $(this).val();
				$.ajax({
					url: "insert.php",
					type: "POST",
					data: {
						id: district,
						function: 'district'
					},
					success: function(data) {
						//console.log(data)
						$('#subdistrict').html(data);

					}
				});
			});
			$('#subdistrict').change(function() {
				var subdistrict = $(this).val();
				$.ajax({
					url: "insert.php",
					type: "POST",
					data: {
						id: subdistrict,
						function: 'subdistrict'
					},
					success: function(data) {
						//console.log(data)
						$('#code').val(data);

					}
				});
			});
		</script>
</body>

</html>