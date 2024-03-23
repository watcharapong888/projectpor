<?php
include('db.php');
if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
	$id = $_POST['id'];
	$sql = "SELECT * FROM district WHERE province_id = '$id' ";
	$query = mysqli_query($dbCon, $sql);
	echo '<option selected disable>กรุณาเลือกอำเภอ</option>';
	foreach ($query as $value) {
		echo '<option value =" ' . $value['district_id'] . '">' . $value['district'] . '</option>';
	}
	exit();
}
if (isset($_POST['function']) && $_POST['function'] == 'district') {
	$id = $_POST['id'];
	$sql = "SELECT * FROM subdistrict WHERE district_id = '$id' ";
	$query = mysqli_query($dbCon, $sql);
	echo '<option selected disable>กรุณาเลือกตำบล</option>';
	foreach ($query as $value) {
		echo '<option value =" ' . $value['subdistrict_id'] . '">' . $value['subdistrict'] . '</option>';
	}
	exit();
}
if (isset($_POST['function']) && $_POST['function'] == 'subdistrict') {
	$id = $_POST['id'];
	$sql = "SELECT * FROM subdistrict WHERE subdistrict_id = '$id' ";
	$query = mysqli_query($dbCon, $sql);
	$result = mysqli_fetch_assoc($query);
	echo $result['code'];
	exit();
}
if (isset($_POST['updatebtn'])) {
	$home_id = $_POST['home_id'];
	$home_no = $_POST['home_no'];
	$swine = $_POST['swine'];
	$district= $_POST['district'];
	$subdistrict = $_POST['subdistrict'];
	$id = $_POST['provinces'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$home_type = $_POST['home_type'];

	if (!empty($_POST['home_id'])) {
		$query = "UPDATE address SET home_id='$home_id', home_no='$home_no', swine='$swine', district_id='$district',
                  subdistrict_id='$subdistrict', province_id='$id', longitude='$longitude',latitude='$latitude', home_type='$home_type' 
                  WHERE home_id='" . $_POST['home_id'] . "'";

		$res = mysqli_query($dbCon, $query);

		if($res)
            {
                header("location:address.php");
            } else {
			echo "Error: " . $query . "<br>" . mysqli_error($dbCon);
		}
	} else {
		echo "ID is empty. Cannot perform the update.";
	}
}
