<?php
if(count($_POST)>0)
{    
include 'db.php';
$news_text = $_POST['news_text'];
if(empty($_POST['id'])){
$query = "INSERT INTO news (news_text)
VALUES ('$news_text')";
}else{
$query = "UPDATE users set news_text='" . $_POST['news_text'] . "'WHERE news_id='" . $_POST['news_id'] . "'"; 
}
$res = mysqli_query($dbCon, $query);
if($res) {
echo json_encode($res);
} else {
echo "Error: " . $sql . "" . mysqli_error($dbCon);
}
}
?>