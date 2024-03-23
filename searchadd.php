<?php
include 'db.php';
$sql = "SELECT * FROM address WHERE home_id LIKE '%{$_POST['home_id']}%'";
$query = mysqli_query($dbCon, $sql); // fix variable name here, use $sql instead of $query
?>
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ลำดับ</th>
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
            $i = 1;
            while ($result = mysqli_fetch_assoc($query)) { // fix function name here, use mysqli_fetch_assoc instead of mysql_fetch_assoc
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['home_id']; ?></td>
                    <td><?php echo $result['home_no']; ?></td>
                    <td><?php echo $result['moo']; ?></td> <!-- use 'moo' instead of 'subdistrict_id' -->
                    <td><?php echo $result['tambon']; ?></td> <!-- use 'tambon' instead of 'district_id' -->
                    <td><?php echo $result['amphoe']; ?></td> <!-- use 'amphoe' instead of 'province_id' -->
                    <td><?php echo $result['province']; ?></td> <!-- use 'province' instead of 'home_type' -->
                </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>