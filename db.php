<?php



// //prod.DB <------------------------------------------------------------------------------------------------------------------------------->

try {
   $dateDB = "DATEDIFF(YEAR, date, GETDATE())" ;
   $user = '"user"';
   $conn = new PDO("sqlsrv:server = tcp:projectpor.database.windows.net,1433; Database = projectpor", "adminbp@projectpor", "P@ssw0rd");
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //  echo "Connected successfully";
}
catch (PDOException $e) {
   echo "Error connecting to SQL Server: " . $e->getMessage();
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



