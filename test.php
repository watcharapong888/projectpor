<?php
require_once 'db.php';
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- DataTable CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- Relway Font link -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

  <title>DataTable Demo</title>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      align-items: center;
      flex-direction: column;
      font-family: "Raleway", sans-serif;
      background-color: whitesmoke;
    }

    #heading {
      margin-top: 33px;
      padding: 24px;
      text-transform: uppercase;
      font-weight: 300;
      font-style: 32px;
      letter-spacing: 8px;
    }

    #heading::after {
      content: "";
      display: flex;
      border-top: 1px solid #585858;
      margin-top: 16px;
    }
  </style>

</head>

<body>
  <!-- Awesome HTML code goes here -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS, then DataTable, then script tag -->

  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
  <script>
    // Awesome JS Code Goes here
    $(document).ready(function() {
      $('#myTable').DataTable({
        responsive: true
      });
    });
  </script>

  <h1 id="heading">DataTable Demo</h1>
  <div class="container">
    <table class="table table-hover table-light table-bordered" id="myTable">
      <thead class="thead-dark">

        <tr>
          <th scope="col">Id</th>
          <th scope="col">Country Name</th>
          <th scope="col">ISO</th>
          <th scope="col">ISO3</th>
          <th scope="col">Id</th>
          <th scope="col">Country Name</th>
          <th scope="col">ISO</th>
          <th scope="col">ISO3</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $conn->prepare(
          "SELECT 
                   ad.home_id,
                   ad.home_no,
                   ad.swine,
                   aph.name_th as aph,
                   di.name_th as di,
                   pro.name_th as pro,
                   ad.home_type
                   FROM 
                   address AS ad
                   JOIN 
                   amphures AS aph ON ad.amphure_id = aph.amphure_id 
                   JOIN 
                   districts AS di ON ad.district_id = di.district_id 
                   JOIN 
                   provinces AS pro ON ad.province_id = pro.province_id 
                   "
        );
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null) {
          $i = 1;
          foreach ($result as $row) {
        ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['home_id']; ?></td>
              <td><?php echo $row['home_no']; ?></td>
              <td><?php echo $row['swine']; ?></td>
              <td><?php echo $row['aph']; ?></td>
              <td><?php echo $row['di']; ?></td>
              <td><?php echo $row['pro']; ?></td>
              <td><?php echo $row['home_type']; ?></td>
            </tr>
          <?php $i++;
          }
        } else { ?>
          <tr>
            <td colspan="11" style="text-align: center; color:red;">ไม่มีข้อมูล</td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>
  </div>
</body>

</html>