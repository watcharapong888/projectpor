<?php
include('db.php');
if(isset($_POST['function']) && $_POST['function'] == 'provinces'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM district WHERE province_id = '$id' ";
    $query = mysqli_query($dbCon, $sql);
    echo '<option selected disable>กรุณาเลือกอำเภอ</option>';
    foreach ($query as $value) {
    echo '<option value =" '.$value['district_id'].'">' .$value['district'].'</option>';
    }
    exit();
}
if(isset($_POST['function']) && $_POST['function'] == 'district'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM subdistrict WHERE district_id = '$id' ";
    $query = mysqli_query($dbCon, $sql);
    echo '<option selected disable>กรุณาเลือกตำบล</option>';
    foreach ($query as $value) {
    echo '<option value =" '.$value['subdistrict_id'].'">' .$value['subdistrict'].'</option>';
    }
    exit();
}
if(isset($_POST['function']) && $_POST['function'] == 'subdistrict'){
    $id = $_POST['id'];
    $sql = "SELECT * FROM subdistrict WHERE subdistrict_id = '$id' ";
    $query = mysqli_query($dbCon, $sql);
    $result = mysqli_fetch_assoc($query);
    echo $result['code'];
    exit();
}

if(isset($_POST['submit']))
    {
        
        if(empty($_POST['home_id']) || empty($_POST['home_no']) || empty($_POST['latitude'])|| empty($_POST['longitude'])|| empty($_POST['home_type']))
        {
            echo 'Please Fill in the Blanks ';
        }
        else
        {
          $home_id = $_POST['home_id'];
          $home_no = $_POST['home_no'];
          $swine = $_POST['swine'];
          $district= $_POST['district'];
          $subdistrict = $_POST['subdistrict'];
          $id = $_POST['provinces'];
          $latitude = $_POST['latitude'];
          $longitude = $_POST['longitude'];
          $home_type = $_POST['home_type'];

            $query = "INSERT INTO address (home_id ,home_no,swine,district_id,subdistrict_id,province_id,latitude,longitude,home_type)
            VALUES ('$home_id','$home_no','$swine','$district','$subdistrict','$id','$latitude','$longitude','$home_type')";
            $result = mysqli_query($dbCon,$query);

            if($result)
            {
                header("location:address.php");
            }
            else
            {
                echo 'Please Check Your Query ';
            }
            }
            }
            else
            {
            header("location:address.php");
            }
            ?>

