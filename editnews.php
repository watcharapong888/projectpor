<?php
include "db.php";
$id = $_POST['id'];
$query="SELECT news_text from news WHERE news_id = '" . $id . "'";
$result = mysqli_query($dbCon,$query);
$cust = mysqli_fetch_array($result);
if($cust) {
echo json_encode($cust);
} else {
echo "Error: " . $sql . "" . mysqli_error($dbCon);
}
?>