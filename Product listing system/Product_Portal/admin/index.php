<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Pending Products</h2>
  <?php
  $result = $conn->query("SELECT * FROM products WHERE status = 'pending'");
  while ($row = $result->fetch_assoc()):
  ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= $row['name'] ?></h5>
        <p><?= $row['specs'] ?></p>
        <p><strong>$<?= $row['price'] ?></strong></p>
        <img src="../uploads/<?= $row['image'] ?>" width="100">
        <form method="POST" action="approve.php">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button class="btn btn-success mt-2">Approve</button>
        </form>
      </div>
    </div>
  <?php endwhile; ?>
</body>
</html>
