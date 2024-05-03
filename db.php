<?php



// //prod.DB <------------------------------------------------------------------------------------------------------------------------------->

// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:projectmmo8.database.windows.net,1433; Database = projectmoo8", "CloudSA3e4c16fa", "P@ssw0rd");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:


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



