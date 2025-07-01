<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Smartphones for Sale</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Approved Smartphones</h2>
  <div class="row">
    <?php
    $result = $conn->query("SELECT * FROM products WHERE status = 'approved' ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()):
    ?>
      <div class="col-md-4 mb-3">
        <div class="card">
          <img src="uploads/<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
          <div class="card-body">
            <h5 class="card-title"><?= $row['name'] ?></h5>
            <p class="card-text"><?= $row['specs'] ?></p>
            <p class="card-text"><strong>$<?= $row['price'] ?></strong></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
