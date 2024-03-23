<?php

// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:projectpor.database.windows.net,1433; Database = projectpor", "adminbp", "P@ssword");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch (PDOException $e) {
    echo "Error connecting to SQL Server: " . $e->getMessage();
}
?>
