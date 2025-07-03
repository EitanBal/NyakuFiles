<?php

include 'includes/db.php';

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header('Location: index.php');
    exit;
}

$order_id = intval($_GET['order_id']);

$sql = "SELECT o.*, p.name, p.price
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.id = $order_id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $order = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank You!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow-x: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .fade-in {
      animation: fadeIn 1s ease-out forwards;
      opacity: 0;
      transform: translateY(20px);
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .thank-card {
      background: #ffffff;
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      padding: 40px;
    }

    .checkmark-circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: #28a745;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 25px;
      box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    }

    .checkmark-circle svg {
      width: 50px;
      height: 50px;
      stroke: #fff;
      stroke-width: 4;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
    }

    .details {
      text-align: left;
      font-size: 1.1rem;
      color: #333;
    }

    .details .label {
      font-weight: 600;
      color: #764ba2;
      min-width: 160px;
      display: inline-block;
    }

    .details p {
      margin-bottom: 10px;
    }

    .btn-custom {
      background-color: #764ba2;
      border: none;
      padding: 12px 24px;
      font-weight: bold;
      color: #fff;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #5b3d85;
      transform: translateY(-2px);
      color: #fff;
    }
  </style>
</head>
<body>
  <?php if (isset($order)) : ?>
    <div class="container fade-in">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="thank-card text-center">
            <div class="checkmark-circle">
              <svg viewBox="0 0 52 52">
                <path d="M14 27 L22 35 L38 19"></path>
              </svg>
            </div>
            <h2 class="mb-4 text-success fw-bold">Thank You for Your Order!</h2>
            <h4 class="mb-4 text-primary fw-bold"><?= htmlspecialchars($order['name']) ?></h4>
            <div class="details text-start mx-auto">
              <p><span class="label">Price:</span> $<?= number_format($order['price'], 2) ?></p>
              <p><span class="label">Buyer:</span> <?= htmlspecialchars($order['buyer_name']) ?></p>
              <p><span class="label">Phone:</span> <?= htmlspecialchars($order['buyer_phone']) ?></p>
              <p><span class="label">Payment Method:</span> <?= htmlspecialchars(strtoupper($order['payment_method'])) ?></p>
              <?php if (!empty($order['transaction_id'])): ?>
                <p><span class="label">Transaction ID:</span> <?= htmlspecialchars($order['transaction_id']) ?></p>
              <?php endif; ?>
            </div>
            <a href="products.php" class="btn btn-custom mt-4">Back to Products</a>
          </div>
        </div>
      </div>
    </div>
  <?php else : ?>
    <div class="container fade-in">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="thank-card text-center">
            <h2 class="text-danger">Oops!</h2>
            <p class="text-muted">We could not find your order details.</p>
            <a href="products.php" class="btn btn-custom mt-3">Back to Products</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</body>
</html>
