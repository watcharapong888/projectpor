<?php



// //prod.DB <------------------------------------------------------------------------------------------------------------------------------->

$servername = "projectmoo8.mysql.database.azure.com";
$username = "napasorn"; //username
$password = "P@ssw0rd"; //password
 
try {
  $dateDB = "TIMESTAMPDIFF(YEAR, date, CURDATE())"; 
  $user = 'user';
  $conn = new PDO("mysql:host=$servername;dbname=project;charset=utf8", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


// //xampp.DB  <------------------------------------------------------------------------------------------------------------------------------->

// $servername = "localhost";
// $username = "root"; //username
// $password = ""; //password
 
// try {
//   $dateDB = "TIMESTAMPDIFF(YEAR, date, CURDATE())"; 
//   $user = 'user';
//   $conn = new PDO("mysql:host=$servername;dbname=project;charset=utf8", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// //   echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }





















?>



