<?php

include 'includes/db.php';

// Ensure product id is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$product_id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id = $product_id AND status='approved'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout - <?= htmlspecialchars($product['name']) ?> | Product Portal</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- ScrollReveal -->
  <script src="https://unpkg.com/scrollreveal"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #333;
      overflow-x: hidden;
    }

    .navbar {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
    }

    .navbar-brand {
      font-weight: 700;
      color: #fff;
    }

    .navbar-nav .nav-link {
      color: #fff;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: #ffd700;
    }

    .sticky-top {
      position: sticky;
      top: 0;
      z-index: 1020;
    }

    .checkout-hero {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
      padding: 60px 20px;
      color: #fff;
      text-align: center;
    }

    .checkout-hero h1 {
      font-weight: 700;
      font-size: 2.5rem;
    }

    .checkout-section {
      background: #f5f7fa;
      padding: 60px 20px;
      border-radius: 12px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
      max-width: 700px;
      margin: auto;
    }

    .btn-buy {
      background: linear-gradient(135deg, #28a745, #85e085);
      color: #fff;
      border: none;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 50px;
      text-decoration: none;
      display: inline-block;
      transition: 0.3s ease;
    }

    .btn-buy:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      color: #fff;
    }

    footer {
      background: #222;
      color: #ccc;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
      margin-top: 50px;
    }

    @media (max-width: 768px) {
      .checkout-hero h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>

<body>

  <!-- Sticky Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Product Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="checkout-hero">
    <h1>Checkout</h1>
    <p class="lead">Complete your order for <strong><?= htmlspecialchars($product['name']) ?></strong></p>
  </section>

  <section class="checkout-section">
    <form action="process_order.php" method="post">
      <input type="hidden" name="product_id" value="<?= $product_id ?>">

      <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="buyer_name" class="form-control" placeholder="Enter your full name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" name="buyer_phone" class="form-control" placeholder="e.g. 0123456789" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select name="payment_method" class="form-select" required>
          <option value="">Select</option>
          <option value="momo">Mobile Money</option>
          <option value="cod">Cash on Delivery</option>
        </select>
      </div>

      <div class="mb-3" id="transactionField" style="display: none;">
        <label class="form-label">Mobile Money Transaction ID</label>
        <input type="text" name="transaction_id" class="form-control" placeholder="e.g. MOMO123456">
      </div>

      <button type="submit" class="btn-buy">Place Order</button>
    </form>
  </section>

  <footer>
    &copy; <?= date("Y") ?> Product Portal | Crafted with ❤️ by You
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    ScrollReveal().reveal('.navbar', {
      duration: 1000,
      origin: 'top',
      distance: '50px',
      easing: 'ease-out',
      opacity: 0
    });

    ScrollReveal().reveal('.checkout-hero', {
      duration: 1200,
      origin: 'bottom',
      distance: '60px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.checkout-section', {
      duration: 1200,
      origin: 'bottom',
      distance: '60px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('footer', {
      duration: 1000,
      origin: 'bottom',
      distance: '40px',
      opacity: 0,
      easing: 'ease-out'
    });

    document.querySelector('select[name="payment_method"]').addEventListener('change', function() {
      if (this.value === 'momo') {
        document.getElementById('transactionField').style.display = 'block';
      } else {
        document.getElementById('transactionField').style.display = 'none';
      }
    });
  </script>

</body>
</html>
