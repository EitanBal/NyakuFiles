<!DOCTYPE html>
<html>
<head>
  <title>Submit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Submit a Smartphone</h2>
  <form action="submit.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Specifications:</label>
      <textarea name="specs" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label>Price ($):</label>
      <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Image:</label>
      <input type="file" name="image" class="form-control" required>
    </div>
    <button class="btn btn-primary" type="submit">Submit Product</button>
  </form>
</body>
</html>
