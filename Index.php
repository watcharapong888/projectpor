<?php include 'menu.php';   ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ชุมชนด่านขุนทด</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e9ecef;
      font-family: 'Arial', sans-serif;
      color: #333;
    }
    .navbar {
      margin-bottom: 20px;
      background-color: #007bff;
      color: #ffffff;
    }
    .navbar a {
      color: #ffffff;
    }
    .showall {
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border: none;
    }
    .card-header {
      background-color: #007bff;
      color: #ffffff;
      border-bottom: none;
    }
    .post {
      background: #ffffff;
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: transform 0.3s ease-in-out;
    }
    .post:hover {
      transform: translateY(-5px);
    }
    .post img {
      max-width: 100%;
      height: auto;
      border-radius: 5px;
      margin-bottom: 15px;
    }
    .post p {
      font-size: 16px;
    }
    iframe {
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body>
  <?php require_once 'db.php'; ?>
  
  <div class="showall container">
    <div class="card mb-4">
      <h3 class="card-header">Dashboard</h3>
      <div class="card-body">
        <iframe title="Community Report" width="100%" height="650" 
        src="https://app.powerbi.com/view?r=eyJrIjoiZTlkMmM5ODktNjUyYi00NmU3LWI2NGQtODAwYzA4MzhjMTQ0IiwidCI6IjczM2UyY2UwLWNlMjgtNGRmYS04YWY2LWFkNTdiMzcwOTBjZSIsImMiOjEwfQ%3D%3D"
          frameborder="0" allowFullScreen="true"></iframe>
      </div>
    </div>

    <div class="posts">
      <?php
        $query = "SELECT post_text, img_id FROM post ORDER BY post_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($posts) {
          foreach ($posts as $post) {
            echo '<div class="post">';
            if (!empty($post['img_id'])) {
              echo '<img src="'.htmlspecialchars($post['img_id']).'" alt="Post Image">';
            }
            echo '<p>'.htmlspecialchars($post['post_text']).'</p>';
            echo '</div>';
          }
        } else {
          echo '<p>No posts to display.</p>';
        }
      ?>
    </div>
  </div>

</body>
</html>
